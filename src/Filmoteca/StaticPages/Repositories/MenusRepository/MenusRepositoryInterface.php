<?php

namespace Filmoteca\StaticPages\Repositories\MenusRepository;

/**
 * Interface MenuRepositoryInterface
 * @package Filmoteca\StaticPages\Repositories
 */
interface MenuRepositoryInterface
{
    /**
     * @param array $rawMenu
     * @return \Filmoteca\StaticPages\Models\MenuInterface
     */
    public function store(array $rawMenu);

    /**
     * @param int $id
     * @param array $rawMenu
     * @return \Filmoteca\StaticPages\Models\MenuInterface
     */
    public function update($id, array $rawMenu);

    /**
     * @param int $id
     * @return \Filmoteca\StaticPages\Models\MenuInterface
     */
    public function destroy($id);
}
