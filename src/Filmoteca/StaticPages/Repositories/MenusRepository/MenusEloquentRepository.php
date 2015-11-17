<?php

namespace Filmoteca\StaticPages\Repositories\MenusRepository;

use Filmoteca\StaticPages\Models\Menu;

/**
 * Class MenusEloquentRepository
 * @package Filmoteca\StaticPages\Repositories
 */
class MenusEloquentRepository implements MenusRepositoryInterface
{
    /**
     * @param array $rawMenu
     * @return Menu
     */
    public function store(array $rawMenu)
    {
        $menu = Menu::findOrNew($rawMenu['id']);
        $menu->fill($rawMenu);
        $menu->save();

        return $menu;
    }

    /**
     * @param int $id
     * @param array $rawMenu
     */
    public function update($id, array $rawMenu)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param int $id
     */
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
