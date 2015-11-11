<?php

namespace Filmoteca\StaticPages\Repositories\StaticPagesRepository;

use Filmoteca\StaticPages\Models\StaticPage\Eloquent\StaticPageProvider;
use Filmoteca\StaticPages\Exceptions\PageSlugExistsException;

/**
 * Class StaticPagesEloquentRepository
 * @package Filmoteca\StaticPages\Repositories\StaticPagesRepository
 */
class StaticPagesEloquentRepository implements StaticPagesRepositoryInterface
{
    public function __construct(StaticPageProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param array $rawStaticPage
     * @return \Filmoteca\StaticPages\Models\StaticPageInterface
     * @throws PageSlugExistsException
     */
    public function store(array $rawStaticPage)
    {
        $model      = $this->provider->createModel();
        $edition    = isset($rawStaticPage['id']);

        if ($edition) {
            $model = $model->findOrNew($rawStaticPage['id']);
        }

        $model->fill($rawStaticPage);
        $slug   = $rawStaticPage['slug'];
        $models = $this->provider->findBySlug($slug);

        if (!$models->isEmpty() && !($edition && $models->first()->id == $model->id)) {
            throw new PageSlugExistsException('A page with the slug ' . $slug . ' already exists.');
        }

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     * @param array $rawStaticPage
     * @return \Filmoteca\StaticPages\Models\StaticPageInterface
     */
    public function update($id, array $rawStaticPage)
    {
        $model = $this->store(array_merge($rawStaticPage, ['id' => $id]));

        return $model;
    }

    /**
     * @param int $id
     * @return \Filmoteca\StaticPages\Models\StaticPageInterface
     */
    public function destroy($id)
    {
        $model = $this->provider->findById($id);

        $model->delete();

        return $model;
    }
}
