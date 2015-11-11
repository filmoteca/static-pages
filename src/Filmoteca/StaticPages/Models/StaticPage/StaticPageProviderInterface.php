<?php

namespace Filmoteca\StaticPages\Models\StaticPage;

interface StaticPageProviderInterface
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function findAll();

    /**
     * @param int $id
     * @return \Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface
     */
    public function findById($id);

    /**
     * @param string $slug
     * @return \Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface
     */
    public function findBySlug($slug);

    /**
     * @return \Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface
     */
    public function createModel();

    /**
     * @return \Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface
     */
    public function getEmptyStaticPage();

    /**
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate();
}
