<?php

namespace Filmoteca\StaticPages\Models\Menu;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Collection;

/**
 * Class Menu
 * @property int        id
 * @property string     name
 * @property Collection entries
 * @package Filmoteca\StaticPages\Models
 */
class MenuEloquent extends Eloquent implements MenuInterface
{
    /**
     * @var string
     */
    protected $table = 'filmoteca_menus';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @var string
     */
    protected $menuEntryModel = '\Filmoteca\StaticPages\Models\Menu\MenuEntryEloquent';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany($this->menuEntryModel, 'menu_id');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Collection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /***
     * @param Collection $menuEntries
     */
    public function setEntries(Collection $menuEntries)
    {
        $menuEntries->each(function (MenuEntryInterface$menuEntry) {
            // It is let empty on purpose.
        });
    }
}
