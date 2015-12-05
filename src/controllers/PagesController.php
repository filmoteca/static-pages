<?php

namespace Filmoteca\StaticPages;

use Filmoteca\StaticPages\Models\StaticPage\StaticPageProviderInterface;
use Filmoteca\StaticPages\Repositories\MenusRepository\MenusRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use View;
use Config;

/**
 * Class PagesController
 * @package Filmoteca\StaticPages
 */
class PagesController extends BaseController
{
    /**
     * @var StaticPagesRepositoryInterface
     */
    protected $staticPageProvider;

    /**
     * @var MenusRepositoryInterface
     */
    protected $menusRepository;

    /**
     * @param StaticPageProviderInterface $staticPageProvider
     * @param MenusRepositoryInterface $menusRepository
     */
    public function __construct(
        StaticPageProviderInterface $staticPageProvider,
        MenusRepositoryInterface $menusRepository
    ) {
        $this->staticPageProvider   = $staticPageProvider;
        $this->menusRepository     = $menusRepository;
    }

    /**
     * @param $parentSlug
     * @param string $childSlug
     */
    public function show($parentSlug, $childSlug = '')
    {
        $slug = $childSlug === ''? $parentSlug: $parentSlug . ' /' . $childSlug;

        $page = $this->staticPageProvider->findBySlug($slug);

        if ($page === null) {
            throw new NotFoundHttpException();
        }

        $mainMenu = $this->menusRepository->findByName(Config::get(self::PACKAGE_NAME . '::main-menu-name'));

        return View::make(self::PACKAGE_NAME . '::pages.show', compact('page', 'mainMenu'));
    }
}
