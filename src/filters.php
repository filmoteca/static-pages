<?php

View::composer('*', function ($view) {
    $menusRepository = new \Filmoteca\StaticPages\Repositories\MenusRepository\MenusEloquentRepository();
    $view->with('mainMenu', $menusRepository->findMainMenu());
});
