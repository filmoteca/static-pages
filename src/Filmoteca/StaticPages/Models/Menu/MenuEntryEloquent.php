<?php

namespace Filmoteca\StaticPages\Models\Menu;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MenuEntry
 * @property int        id
 * @property string     url
 * @property string     label
 * @property int        menu_id
 * @property int        position
 * @property Collection subEntries
 * @package Filmoteca\StaticPages\Models\Menu
 */
class MenuEntryEloquent extends Eloquent implements MenuEntryInterface
{
    /**
     * @var string
     */
    protected $table = 'filmoteca_menu_entries';

    /**
     * @var string
     */
    protected static $menuModel = '\Filmoteca\StaticPages\Models\Menu\Menu';

    /**
     * @var string
     */
    protected static $subEntryModel = '\Filmoteca\StaticPages\Models\Menu\MenuEntryEloquent';

    /**
     * @var array
     */
    protected $fillable = ['url', 'label', 'position', 'menu_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function menu()
    {
        return $this->belongsTo(static::$menuModel);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function superEntry()
    {
        return $this->belongsTo(static::$subEntryModel);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function subEntries()
    {
        return $this->hasMany(static::$subEntryModel, 'super_entry_id', 'id');
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
     * @return mixed
     */
    public function setId($id)
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return Collection
     */
    public function getSubEntries()
    {
        return $this->subEntries;
    }

    /**
     * @param Collection $subEntries
     */
    public function setSubEntries(Collection $subEntries)
    {
        $this->subEntries = $subEntries;
    }

    /**
     * @return bool
     */
    public function hasSubEntries()
    {
        return !$this->getSubEntries()->isEmpty();
    }
}
