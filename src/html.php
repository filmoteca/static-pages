<?php

use Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface;
use Filmoteca\StaticPages\Models\Menu\MenuEntryInterface;
use Filmoteca\StaticPages\Models\Menu\MenuInterface;

HTML::macro('siblingsPages', function (StaticPageInterface $currentPage) {

    $childPages = $currentPage->hasParent()?
        $currentPage->getParentPage()->getChildPages():
        $currentPage->getChildPages();

    $listItems = $childPages
        ->reduce(function ($listItems, StaticPageInterface $childPage) use ($currentPage) {

            $class  = $currentPage->getId() === $childPage->getId()? 'current': '';
            $url    = filmoteca_create_link_of_page($childPage);

            if ($childPage->getChildPages()->isEmpty()) {
                $listItems .= "<li class=\"$class\">";
                $listItems .= HTML::link($url, $childPage->getTitle());
            } else {
                $listItems .= "<li class=\"$class has-sub\">";
                $listItems .= HTML::link($url, $childPage->getTitle());
                $listItems .= HTML::siblingsPages($childPage->getChildPages()->first());
            }

            $listItems .= '</li>';

            return $listItems;
        }, '');

    return '<ul>' . $listItems . '</ul>';
});

HTML::macro('menu', function (
    $menuEntries = null,
    $menuClass = '',
    $entryClass = '',
    $linkClass = '',
    $subMenuClass = ''
) {

    if ($menuEntries === null) {
        return '<ul></ul>';
    }

    if ($menuEntries instanceof MenuInterface) {
        $menuEntries = $menuEntries->getEntries();
    }

    $listItems = $menuEntries->reduce(
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

                $listItems .= HTML::menu(
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

HTML::macro('breadcrumbs', function (StaticPageInterface $currentPage, $isActive = true) {

    $items  = '';
    $url    = filmoteca_create_link_of_page($currentPage);

    if (!$currentPage->hasParent()) {
        if ($isActive) {
            return "<li class\"active\">" . $currentPage->getTitle() . "</li>";
        }

        return "<li><a href=\"" . $url . "\">" . $currentPage->getTitle() . "</a></li>";
    }

    $items .= HTML::breadcrumbs($currentPage->getParentPage(), false);

    if ($isActive) {
        $items .= "<li class\"active\">" . $currentPage->getTitle() . "</li>";
    } else {
        $items .= "<li><a href=\"$url\">" . $currentPage->getTitle() . "</a></li>";
    }

    return $items;
});


function filmoteca_create_link_of_page(StaticPageInterface $page)
{
    $url = '//' .
    Request::getHost() . '/' .
    Config::get('filmoteca/static-pages::pages-url-prefix') . '/' .
    $page->getSlug();

    return $url;
}
