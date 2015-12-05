<?php

return [
    /*
     |-----------------------------------------------------------------------------------------------------------------
     | Not add slash neither at the first and at the end, because the slashes are going to replaced with a dot
     | to the named route.
     */
    'admin-url'     => 'filmoteca/static-pages',
    'pages-layout'  => 'filmoteca/static-pages::layouts.pages',
    'sections'      => [
        'title'     => 'title',
        'sidebar'   => 'sidebar',
        'main-menu' => 'main-menu',
        'content'   => 'content'
    ],
    'main-menu-name' => 'main'
];
