<?php

namespace Filmoteca\StaticPages;

use Filmoteca\StaticPages\Exceptions\PageSlugExistsException;
use Filmoteca\StaticPages\Models\StaticPage\StaticPageProviderInterface;
use Filmoteca\StaticPages\Repositories\StaticPagesRepository\StaticPagesRepositoryInterface;
use Filmoteca\StaticPages\Validators\StaticPagesValidator;
use Illuminate\Support\Str;
use Validator;
use Redirect;
use View;
use Input;
use Config;
use Lang;
use Session;
use Request;
use Illuminate\Routing\Controller;

/**
 * Class StaticPagesController
 * @package Filmoteca\StaticPages
 */
class StaticPagesController extends Controller
{
    const DEFAULT_STATUS    = 'publish';

    const PACKAGE_NAME      = 'filmoteca/static-pages';

    /**
     * @var StaticPageProviderInterface
     */
    protected $staticPageProvider;

    /**
     * @var StaticPagesRepositoryInterface
     */
    protected $repository;

    /**
     * @param StaticPageProviderInterface $staticPageProvider
     * @param StaticPagesRepositoryInterface $repository
     * @param StaticPagesValidator $staticPageValidator
     */
    public function __construct(
        StaticPageProviderInterface $staticPageProvider,
        StaticPagesRepositoryInterface $repository,
        StaticPagesValidator $staticPageValidator
    ) {
        $this->staticPageProvider   = $staticPageProvider;
        $this->repository           = $repository;
        $this->staticPageValidator  = $staticPageValidator;
    }

    public function index()
    {
        $pages  = $this->staticPageProvider->paginate();

        return View::make(self::PACKAGE_NAME  .  '::static-pages.index', compact('pages'));
    }

    /**
     * @param \Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface $page
     */
    public function create($page = null)
    {
        $availableStatus    = $this->staticPageProvider->getEmptyStaticPage()->getAvailableStatus();
        $pages              = $this->staticPageProvider->findAll();
        $data               = [
            'status'        => array_combine($availableStatus, $availableStatus),
            'defaultStatus' => self::DEFAULT_STATUS,
            'pages'         => $pages,
            'page'          => $page
        ];

        return View::make(self::PACKAGE_NAME  .  '::static-pages.create', $data);
    }

    public function store()
    {
        $createPath                     = Request::path() . '/create';
        $cleanRawData                   = Input::all();
        $cleanRawData['parent_page_id'] = Input::get('parent_page_id') == ''? null: Input::get('parent_page_id');
        $validator                      = $this->staticPageValidator->validate($cleanRawData);

        if (!$validator->errors()->isEmpty()) {
            return Redirect::to($createPath)
                ->withErrors($validator)
                ->withInput(Input::all());
        }

        try {
            $this->repository->store($cleanRawData);
        } catch (PageSlugExistsException $e) {
            $path = Input::has('id')? Request::path() . '/' . Input::get('id') . '/edit': $createPath;

            return Redirect::to($path)
                ->with(
                    'danger',
                    Lang::get(
                        'filmoteca/static-pages::errors.static-pages.slug-already-exists',
                        ['slug' => $cleanRawData['slug']]
                    )
                )
                ->withInput(Input::all());
        }

        $successfulMessage = Input::has('id')?
            Lang::get('filmoteca/static-pages::static-pages.updated'):
            Lang::get('filmoteca/static-pages::static-pages.stored');

        return Redirect::action(get_class($this) . '@index')
            ->with(
                'success',
                $successfulMessage
            );
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        $page = $this->staticPageProvider->findById($id);
        return $this->create($page);
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $this->repository->destroy($id);

        return Redirect::action(get_class($this) . '@index');
    }
}
