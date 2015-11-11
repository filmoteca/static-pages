<?php

namespace Filmoteca\StaticPages\Models\StaticPage\Eloquent;

use Filmoteca\StaticPages\Models\StaticPage\StaticPageProviderInterface;

/**
 * Class StaticPageProvider
 * @package Filmoteca\StaticPages\Models\StaticPage\Eloquent
 */
class StaticPageProvider implements StaticPageProviderInterface
{
    /**
     * @var string
     */
    protected $model = 'Filmoteca\StaticPages\Models\StaticPage\Eloquent\StaticPage';

    /**
     * @return \Illuminate\Support\Collection
     */
    public function findAll()
    {
        return $this->createModel()->newQuery()->get();
    }

    /**
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate()
    {
        return $this->createModel()->newQuery()->paginate();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findById($id)
    {
        return $this->createModel()->newQuery()->find($id);
    }

    public function findBySlug($slug)
    {
        return $this->createModel()->newQuery()->where('slug', $slug)->get();
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }

    /**
     * @return StaticPage
     */
    public function getEmptyStaticPage()
    {
        return $this->createModel();
    }

    /*
     |-------------------------------------------------------------------------
     | Getters and Setters
     |-------------------------------------------------------------------------
     */

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }
}
