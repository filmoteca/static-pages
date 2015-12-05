<?php

namespace Filmoteca\StaticPages\Models\StaticPage;

interface StaticPageInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return int
     */
    public function getParentId();

    /**
     * @return StaticPageInterface
     */
    public function getParentPage();

    /**
     * @param int $id
     * @return void
     */
    public function setId($id);

    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title);

    /**
     * @param string $content
     * @return void
     */
    public function setContent($content);

    /**
     * @param string $status
     * @return void
     */
    public function setStatus($status);

    /**
     * @param string $slug
     * @return void
     */
    public function setSlug($slug);

    /**
     * @param $parentId
     * @return void
     */
    public function setParentId($parentId);

    /**
     * @param StaticPageInterface $parent
     */
    public function setParentPage(StaticPageInterface $parent);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getChildPages();

    /**
     * @param StaticPageInterface $staticPage
     * @return void
     */
    public function addChildPage(StaticPageInterface $staticPage);

    /**
     * @return bool
     */
    public function hasParent();

    /**
     * @return array
     */
    public static function getAvailableStatus();
}
