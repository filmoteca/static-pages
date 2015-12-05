<?php

namespace Filmoteca\StaticPages\Repositories\MenusRepository;

use Filmoteca\StaticPages\Models\Menu\MenuEloquent as Menu;
use Filmoteca\StaticPages\Models\Menu\MenuEntryEloquent as MenuEntry;

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
        $menu = Menu::findOrNew(isset($rawMenu['id'])?$rawMenu['id']: null);
        $menu->name = isset($rawMenu['name'])? $rawMenu['name']: '';
        $menu->save();

        $menu->entries->each(function ($entry) {
            $entry->delete();
        });

        if (isset($rawMenu['entries'])) {
            $entries = $this->uniqueEntries($rawMenu['entries']);
            $this->saveEntries($menu, $entries);
        }

        return $menu;
    }

    /**
     * @param int $id
     * @param array $rawMenu
     * @return \Filmoteca\StaticPages\Models\Menu\MenuInterface
     */
    public function update($id, array $rawMenu)
    {
        $rawMenu['id'] = $id;

        return $this->store($rawMenu);
    }

    /**
     * @param int $id
     * @return \Filmoteca\StaticPages\Models\Menu\MenuInterface
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->delete();

        return $menu;
    }

    /**
     * @param int $amount
     * @return mixed
     */
    public function paginate($amount = MenusRepositoryInterface::DEFAULT_AMOUNT)
    {
        return Menu::paginate($amount);
    }

    public function findById($id)
    {
        return Menu::find($id);
    }

    /**
     * @param string $name
     * @return \Filmoteca\StaticPages\Models\Menu\MenuInterface
     */
    public function findByName($name)
    {
        return Menu::where('name', $name)->get()->first();
    }

    /**
     * @param $menu
     * @param array $entries
     * @return \Filmoteca\StaticPages\Models\Menu\MenuInterface
     */
    protected function saveEntries(Menu $menu, array $entries)
    {
        $menuEntries = array_reduce($entries, function ($menuEntries, $entry) {

            $menuEntry = MenuEntry::firstOrNew([
                'url' => $entry['url'],
                'label' => $entry['label']
            ]);

            $menuEntries[] = $menuEntry;

            return $menuEntries;
        }, []);

        $menu->entries()->saveMany($menuEntries);

        return $menu;
    }

    /**
     * @param array $entries
     * @return array
     */
    protected function uniqueEntries(array $entries)
    {
        $uniqueEntries = array_reduce($entries, function ($uniqueEntries, $entryToInsert) {

            if (!$this->isInEntries($uniqueEntries, $entryToInsert)) {
                $uniqueEntries[] = $entryToInsert;
            }

            return $uniqueEntries;
        }, []);

        return $uniqueEntries;
    }

    /**
     * @param array $entries
     * @param array $entryToInsert
     * @return bool
     */
    protected function isInEntries(array $entries, array $entryToInsert)
    {
        $repeatEntries = array_filter($entries, function ($uniqueEntry) use ($entryToInsert) {
            $label  = $uniqueEntry['label'] === $entryToInsert['label'];
            $url    = $uniqueEntry['url'] === $entryToInsert['url'];

            return $label && $url;
        });

        return !empty($repeatEntries);
    }
}
