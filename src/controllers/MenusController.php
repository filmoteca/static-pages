<?php

namespace Filmoteca\StaticPages;

use Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface;
use Filmoteca\StaticPages\Models\StaticPage\StaticPageProviderInterface;
use Filmoteca\StaticPages\Repositories\MenusRepository\MenusRepositoryInterface;
use Config;
use Filmoteca\StaticPages\Types\NodeInterface;
use Illuminate\Support\Collection;
use View;

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

    public function __construct(
        MenusRepositoryInterface $repository,
        StaticPageProviderInterface  $pageProvider
    ) {
        $this->repository = $repository;
        $this->pageProvider = $pageProvider;
    }

    public function create($menu = null)
    {
        $pages  = $this->getLeavesTree();
        $data   = compact('menu', 'pages');

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

    protected function getLeavesTree()
    {
        $tree   = new \Filmoteca\StaticPages\Types\Node();

        $pages = $this->pageProvider->findAll()->groupBy(function (StaticPageInterface $page) {
            return $page->hasParent()? 'children' : 'parents';
        });

        $parents = new Collection($pages->get('parents'));
        $parents->each(function (StaticPageInterface $page) use ($tree) {
            $node = new \Filmoteca\StaticPages\Types\Node();
            $node->setId($page->getId());
            $node->setContent($page);

            $tree->addChild($node);
        });

        $this->insertChildren($tree, new Collection($pages->get('children')));

        return $tree;
    }

    /**
     * @param NodeInterface $tree
     * @param Collection $children
     * @return NodeInterface
     */
    protected function insertChildren(NodeInterface $tree, Collection $children)
    {
        if (count($children) === 0) {
            return $tree;
        }

        $withoutParent = $children
            ->reduce(function (Collection $withoutParent, StaticPageInterface $child) use ($tree) {
                $parent = $tree->findNode($child->getParentId());

                if ($parent !== null) {
                    $node = new \Filmoteca\StaticPages\Types\Node();
                    $node->setId($child->getId());
                    $node->setContent($child);

                    $parent->addChild($node);
                } else {
                    $withoutParent->push($child);
                }

                return $withoutParent;
            }, new Collection([]));

        if ($children->count() === $withoutParent->count()) {
            return $tree;
        }

        return $this->insertChildren($tree, $withoutParent);
    }
}
