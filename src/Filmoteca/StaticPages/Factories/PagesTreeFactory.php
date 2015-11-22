<?php

namespace Filmoteca\StaticPages\Factories;

use Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface;
use Filmoteca\StaticPages\Types\NodeInterface;
use Filmoteca\StaticPages\Types\Node;
use Illuminate\Support\Collection;

/**
 * Class PagesTreeFactory
 * @package Filmoteca\StaticPages\Factories
 */
class PagesTreeFactory
{
    /**
     * @param Collection $pages
     * @return \Filmoteca\StaticPages\Types\NodeInterface
     */
    public static function create(Collection $pages)
    {
        $tree   = new Node();
        $pages  = $pages->groupBy(function (StaticPageInterface $page) {
            return $page->hasParent()? 'children' : 'parents';
        });

        $parents = new Collection($pages->get('parents'));
        $parents->each(function (StaticPageInterface $page) use ($tree) {
            $node = new Node();
            $node->setId($page->getId());
            $node->setContent($page);

            $tree->addChild($node);
        });

        static::insertChildren($tree, new Collection($pages->get('children')));

        return $tree;
    }

    /**
     * @param NodeInterface $tree
     * @param Collection $children
     * @return NodeInterface
     */
    protected static function insertChildren(NodeInterface $tree, Collection $children)
    {
        if ($children->isEmpty()) {
            return $tree;
        }

        $withoutParent = $children
            ->reduce(function (Collection $withoutParent, StaticPageInterface $child) use ($tree) {
                $parent = $tree->findNode($child->getParentId());

                if ($parent !== null) {
                    $node = new Node();
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

        return static::insertChildren($tree, $withoutParent);
    }
}
