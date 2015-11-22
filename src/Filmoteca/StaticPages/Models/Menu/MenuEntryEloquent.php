<?php

namespace Filmoteca\StaticPages\Models\Menu;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class MenuEntry
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
    protected $menuModel = '\Filmoteca\StaticPages\Models\Menu';

    /**
     * @var array
     */
    protected $fillable = ['url', 'label', 'menu_id'];

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
     * @return mixed
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
}
