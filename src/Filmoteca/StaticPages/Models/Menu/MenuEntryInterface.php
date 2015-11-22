<?php

namespace Filmoteca\StaticPages\Models\Menu;

/**
 * Interface MenuEntryInterface
 * @package Filmoteca\StaticPages\Models\Menu
 */
interface MenuEntryInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param string $url
     */
    public function setUrl($url);

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @param string $label
     */
    public function setLabel($label);
}
