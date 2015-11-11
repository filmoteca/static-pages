<?php

Route::group(['prefix' => Config::get('static-pages::admin-url')], function () {

    Route::resource('page', 'Filmoteca\StaticPages\StaticPagesController');
});
