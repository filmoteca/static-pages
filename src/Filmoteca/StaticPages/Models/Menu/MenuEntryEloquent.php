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
    protected $menuModel = '\Filmoteca\StaticPages\Models\Menu\Menu';

    /**
     * @var array
     */
    protected $fillable = ['url', 'label', 'position', 'menu_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function menu()
    {
        return $this->belongsTo($this->menuModel);
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
}
