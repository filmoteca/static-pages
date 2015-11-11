<?php

use Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface;
use Illuminate\Support\Collection;

Form::macro('selectParentPage', function ($name, Collection $pages, StaticPageInterface $page = null, $attributes) {

    $parentPageId = $page === null? : $page->getParentId();

    $newValues = $pages->reduce(function ($newValues, StaticPageInterface $page) {

        $newValues[$page->getId()] = $page->getTitle();

        return $newValues;
    }, []);

    return Form::select($name, $newValues, $parentPageId, $attributes);
});
