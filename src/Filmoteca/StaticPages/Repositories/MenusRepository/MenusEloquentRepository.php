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
        $repeatEntry = array_filter($entries, function ($uniqueEntry) use ($entryToInsert) {
            $label  = $uniqueEntry['label'] !== $entryToInsert['label'];
            $url    = $uniqueEntry['url'] !== $entryToInsert['url'];

            return $label && $url;
        });

        return !empty($repeatEntry);
    }
}
