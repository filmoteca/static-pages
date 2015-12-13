<?php

use Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface;
use Filmoteca\StaticPages\Models\Menu\MenuEntryInterface;
use Filmoteca\StaticPages\Models\Menu\MenuInterface;
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

    $result = '<ul class="pages">';

    foreach ($leaves as $leaf) {
        $item = '<li class="page">';

        $page = $leaf->getContent();

        if (!$page instanceof StaticPageInterface) {
            throw new Exception('The tree is not a tree of StaticPages.');
        }

        $item .= Form::checkbox('page-' . $page->getId(), $page->getId());
        $item .= '<span class="title">' . $page->getTitle() . '</span>';
        $item .= '<span class="slug">' . $page->getSlug() . '</span>';
        $item .= '<span class="url">//' .
            Request::getHost() . '/' .
            Config::get('filmoteca/static-pages::pages-url-prefix') . '/' .
            $page->getSlug() .
            '</span>';
        $item .= '<span class="id">' . $page->getId() . '</span>';

        $item .= Form::staticPagesTree($leaf);

        $item .= '</li>';

        $result .= $item;
    }

    $result .= '</ul>';

    return $result;
});

Form::macro('siblingsPages', function (StaticPageInterface $currentPage) {

    if (!$currentPage->hasParent()) {
        return '<ul></ul>';
    }

    $listItems = $currentPage
        ->getParentPage()
        ->getChildPages()
        ->reduce(function ($listItems, StaticPageInterface $childPage) use ($currentPage) {

            $class  = $currentPage->getId() === $childPage->getId()? 'current': '';
            $url    = '//' .
                Request::getHost() . '/' .
                Config::get('filmoteca/static-pages::pages-url-prefix') . '/' .
                $currentPage->getSlug();

            $listItems .= "<li class=\"$class\">";
            $listItems .= HTML::link($url, $childPage->getTitle());
            $listItems .= '</li>';

            return $listItems;
        }, '');

    return '<ul>' . $listItems . '</ul>';
});

Form::macro('menu', function (
    $menu = null,
    $menuClass = '',
    $entryClass = '',
    $linkClass = '',
    $subMenuClass = ''
) {

    if ($menu === null) {
        return '<ul></ul>';
    }

    if ($menu instanceof MenuInterface) {
        $menuEntries = $menu->getEntries();
    }

    if ($menu instanceof Collection) {
        $menuEntries = $menu;
    }

    $listItems = $menu->reduce(
        function ($listItems, MenuEntryInterface $menuEntry) use ($entryClass, $linkClass, $menuClass, $subMenuClass) {

            if ($menuEntry->hasSubEntries()) {
                $listItems .= "<li class=\"dropdown $entryClass\">";

                $listItems .=
                    "<a href=\"" . $menuEntry->getUrl() . "\" " .
                    "data-toggle=\"dropdown\" " .
                    "class=\"dropdown-toggle $linkClass\"" .
                    ">" .
                    $menuEntry->getLabel() . '<span class="caret"></span>' .
                    "</a>";

                $listItems .= Form::menu(
                    $menuEntry->getSubEntries(),
                    $subMenuClass,
                    $entryClass,
                    $linkClass,
                    $subMenuClass
                );
            } else {
                $listItems .= "<li class=\"$entryClass\">";
                $listItems .= HTML::link(
                    $menuEntry->getUrl(),
                    $menuEntry->getLabel(),
                    ['class' => $linkClass]
                );
            }

            $listItems .= '</li>';

            return $listItems;
        },
        ''
    );

    return "<ul class=\"$menuClass\">" . $listItems . '</ul>';
});
