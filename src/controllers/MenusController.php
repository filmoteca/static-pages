<?php

namespace Filmoteca\StaticPages;

use Config;
use Filmoteca\StaticPages\Factories\PagesTreeFactory;
use Filmoteca\StaticPages\Models\Menu\MenuEloquent;
use Filmoteca\StaticPages\Models\Menu\MenuInterface;
use Filmoteca\StaticPages\Models\StaticPage\StaticPageProviderInterface;
use Filmoteca\StaticPages\Repositories\MenusRepository\MenusRepositoryInterface;
use Illuminate\Support\Collection;
use Input;
use Lang;
use Redirect;
use View;

/**
 * Class MenusController
 * @package Filmoteca\StaticPages
 */
class MenusController extends BaseController
{
    /**
     * @var MenusRepositoryInterface
     */
    protected $repository;

    /**
     * @var StaticPageProvider
     */
    protected $pageProvider;


    /**
     * @param MenusRepositoryInterface $repository
     * @param StaticPageProviderInterface $pageProvider
     */
    public function __construct(
        MenusRepositoryInterface $repository,
        StaticPageProviderInterface $pageProvider
    ) {
        $this->repository       = $repository;
        $this->pageProvider     = $pageProvider;
    }

    /**
     * @param MenuInterface $menu
     * @return mixed
     */
    public function create(MenuInterface $menu = null)
    {
        $pages          = $this->pageProvider->findAll();
        $pagesTree      = PagesTreeFactory::create($pages);
        $data           = compact('menu', 'pagesTree');

        return View::make(self::PACKAGE_NAME . '::menus.create', $data);
    }

    public function store()
    {
        $menu = $this->repository->store(Input::all());

        $successfulMessage = Input::has('id')?
            Lang::get('filmoteca/static-pages::menus.updated'):
            Lang::get('filmoteca/static-pages::menus.stored');

        return Redirect::action(get_class($this) . '@create')
            ->with(
                'success',
                $successfulMessage
            )
            ->withInput(['menu' => $menu]);
    }
}
