<?php

namespace Filmoteca\StaticPages\Types;

use Illuminate\Support\Collection;

/**
 * Interface NodeInterface
 * @package Filmoteca\StaticPages\Types
 */
interface NodeInterface
{
    const DEFAULT_MAX_DEPTH = 10;

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $id
     */
    public function setId($id);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getChildren();

    /**
     * @param $children
     */
    public function setChildren(Collection $children);

    /**
     * @return bool
     */
    public function hasChildren();

    /**
     * @param NodeInterface $node
     */
    public function addChild(NodeInterface $node);

    /**
     * @param $id
     * @return NodeInterface|null
     */
    public function findChild($id);

    /**
     * @param $id
     * @param int $maxDepth
     * @return NodeInterface
     */
    public function findNode($id, $maxDepth = self::DEFAULT_MAX_DEPTH);

    /**
     * @return NodeInterface
     */
    public function getParent();

    /**
     * @param NodeInterface $parent
     */
    public function setParent(NodeInterface $parent);

    /**
     * @return boolean
     */
    public function hasParent();

    /***
     * @param mixed
     */
    public function setContent($node);

    /**
     * @return mixed
     */
    public function getContent();
}
