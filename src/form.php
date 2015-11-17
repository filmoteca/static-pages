<?php

use Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface;
use Filmoteca\StaticPages\Types\NodeInterface;
use Illuminate\Support\Collection;

Form::macro('selectParentPage', function ($name, Collection $pages, StaticPageInterface $page = null, $attributes) {

    $parentPageId = $page === null? : $page->getParentId();

    $newValues = $pages->reduce(function ($newValues, StaticPageInterface $page) {

        $newValues[$page->getId()] = $page->getTitle();

        return $newValues;
    }, []);

    return Form::select($name, $newValues, $parentPageId, $attributes);
});


Form::macro('staticPagesTree', function (NodeInterface $tree) {

    $leaves = $tree->getChildren();

    $result = '<ul>';

    foreach ($leaves as $leaf) {
        $item = '<li>';

        $page = $leaf->getContent();

        if (!$page instanceof StaticPageInterface) {
            throw new Exception('The tree is not a tree of StaticPages.');
        }

        $item .= Form::checkbox('page-' . $page->getId(), $page->getId());
        $item .= $page->getTitle();

        $item .= Form::staticPagesTree($leaf);

        $item .= '</li>';

        $result .= $item;
    }

    $result .= '</ul>';

    return $result;
});
