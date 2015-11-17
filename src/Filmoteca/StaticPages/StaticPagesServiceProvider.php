<?php namespace Filmoteca\StaticPages;

use Filmoteca\StaticPages\Models\StaticPage\Eloquent\StaticPageProvider;
use Filmoteca\StaticPages\Validators\StaticPageValidator;
use Illuminate\Support\ServiceProvider;

class StaticPagesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('filmoteca/static-pages', 'filmoteca/static-pages');
        $this->loadIncludes();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['config']->package('filmoteca/static-pages', __DIR__ . '/../../config');

        $this->registerStaticPageProvider();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            '\Filmoteca\StaticPages\Models\StaticPage\StaticPageProviderInterface'
        ];
    }

    public function loadIncludes()
    {
        include __DIR__ . '/../../routes.php';
        include __DIR__ . '/../../form.php';
    }

    protected function registerStaticPageProvider()
    {
        $this->app->bind(
            '\Filmoteca\StaticPages\Models\StaticPage\StaticPageProviderInterface',
            '\Filmoteca\StaticPages\Models\StaticPage\Eloquent\StaticPageProvider'
        );

        $this->app->bind(
            'Filmoteca\StaticPages\Repositories\StaticPagesRepository\StaticPagesRepositoryInterface',
            'Filmoteca\StaticPages\Repositories\StaticPagesRepository\StaticPagesEloquentRepository'
        );

        $this->app->bind(
            'Filmoteca\StaticPages\Repositories\MenusRepository\MenusRepositoryInterface',
            'Filmoteca\StaticPages\Repositories\MenusRepository\MenusEloquentRepository'
        );
    }
}
