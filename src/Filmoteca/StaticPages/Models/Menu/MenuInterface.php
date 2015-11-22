<?php

namespace Filmoteca\StaticPages\Models\Menu;

use Illuminate\Support\Collection;

/**
 * Interface MenuInterface
 * @package Filmoteca\StaticPages\Models\Menu
 */
interface MenuInterface
{
    /**
     * @return int id
     */
    public function getId();

    /**
     * @param int $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return Collection of MenuEntriesInterface
     */
    public function getEntries();

    /**
     * @param Collection $menuEntries
     */
    public function setEntries(Collection $menuEntries);
}
