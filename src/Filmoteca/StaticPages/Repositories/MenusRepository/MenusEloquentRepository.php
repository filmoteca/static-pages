<?php

namespace Filmoteca\StaticPages\Repositories\MenusRepository;

use Filmoteca\StaticPages\Models\Menu\MenuEloquent as Menu;
use Filmoteca\StaticPages\Models\Menu\MenuEntryEloquent as MenuEntry;
use Input;

/**
 * Class MenusEloquentRepository
 * @package Filmoteca\StaticPages\Repositories
 */
class MenusEloquentRepository implements MenusRepositoryInterface
{
    /**
     * @param array $rawMenu
     * @return MenuInterface
     */
    public function store(array $rawMenu)
    {
        $menu = Menu::findOrNew(Input::get('id'));
        $menu->name = Input::get('name', '');
        $menu->save();

        if (Input::has('entries')) {
            $this->saveEntries($menu, Input::get('entries'));
        }

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

    /**
     * @param $menu
     * @param array $entries
     * @return mixed
     */
    protected function saveEntries($menu, array $entries)
    {
        $menuEntries = array_reduce($entries, function ($menuEntries, $entry) {

            $menuEntry = MenuEntry::firstOrCreate(['url' => $entry['url'], 'label' => $entry['label']]);

            $menuEntries[] = $menuEntry;

            return $menuEntries;
        }, []);

        $menu->entries()->saveMany($menuEntries);

        return $menu;
    }
}
