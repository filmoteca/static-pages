<?php

namespace Filmoteca\StaticPages\Repositories\MenusRepository;

/**
 * Interface MenusRepositoryInterface
 * @package Filmoteca\StaticPages\Repositories
 */
interface MenusRepositoryInterface
{
    const DEFAULT_AMOUNT = 15;

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

    /**
     * @param int $amount
     * @return mixed
     */
    public function paginate($amount = self::DEFAULT_AMOUNT);

    /**
     * @param int $id
     * @return \Filmoteca\StaticPages\Models\Menu\MenuInterface
     */
    public function findById($id);

    /**
     * @param $name
     * @return \Filmoteca\StaticPages\Models\Menu\MenuInterface
     */
    public function findByName($name);

    /**
     * @return \Filmoteca\StaticPages\Models\Menu\MenuInterface
     */
    public function findMainMenu();
}
