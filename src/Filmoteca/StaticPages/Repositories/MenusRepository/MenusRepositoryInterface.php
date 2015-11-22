<?php

namespace Filmoteca\StaticPages\Repositories\MenusRepository;

/**
 * Interface MenusRepositoryInterface
 * @package Filmoteca\StaticPages\Repositories
 */
interface MenusRepositoryInterface
{
    /**
     * @param array $rawMenu
     * @return \Filmoteca\StaticPages\Models\Menu\MenuInterface
     */
    public function store(array $rawMenu);

    /**
     * @param int $id
     * @param array $rawMenu
     * @return \Filmoteca\StaticPages\Models\Menu\MenuInterface
     */
    public function update($id, array $rawMenu);

    /**
     * @param int $id
     * @return \Filmoteca\StaticPages\Models\Menu\MenuInterface
     */
    public function destroy($id);
}
