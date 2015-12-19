<?php

View::composer('*', function ($view) {
    $menusRepository = App::make('menus_repository');
    $view->with('mainMenu', $menusRepository->findMainMenu());
});
