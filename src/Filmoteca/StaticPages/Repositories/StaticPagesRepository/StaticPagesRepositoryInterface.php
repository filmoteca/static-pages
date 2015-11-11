<?php

namespace Filmoteca\StaticPages\Repositories\StaticPagesRepository;

/**
 * Interface StaticPagesRepositoryInterface
 * @package Filmoteca\StaticPages\Repositories
 */
interface StaticPagesRepositoryInterface
{
    /**
     * @param array $rawStaticPage
     * @return \Filmoteca\StaticPages\Models\StaticPageInterface
     */
    public function store(array $rawStaticPage);

    /**
     * @param int $id
     * @param array $rawStaticPage
     * @return \Filmoteca\StaticPages\Models\StaticPageInterface
     */
    public function update($id, array $rawStaticPage);

    /**
     * @param int $id
     * @return \Filmoteca\StaticPages\Models\StaticPageInterface
     */
    public function destroy($id);
}
