<?php

namespace Filmoteca\StaticPages\Types;

use Illuminate\Support\Collection;

/**
 * Class Node
 * @package Filmoteca\StaticPages\Types
 */
class Node implements NodeInterface
{
    /**
     * @var NodeInterface
     */
    protected $parent = null;

    /**
     * @var Collection
     */
    protected $children;

    /**
     * @var mixin
     */
    protected $content;

    /**
     * @var int
     */
    protected $id;

    public function __construct()
    {
        $this->children = new Collection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param $children
     * @return $this
     */
    public function setChildren(Collection $children)
    {
        if ($children instanceof Collection) {
            $this->children = $children;
            return;
        }

        $this->children = new Collection($children);
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return !$this->children->isEmpty();
    }

    /**
     * @param NodeInterface $node
     */
    public function addChild(NodeInterface $node)
    {
        $node->setParent($this);
        $this->children->push($node);
    }

    /**
     * @param $id
     * @return NodeInterface
     */
    public function findChild($id)
    {
        return $this->findNode($id, 1);
    }

    /**
     * Searches First in Depth
     * @param $id
     * @param int $maxDepth
     * @return NodeInterface|null
     */
    public function findNode($id, $maxDepth = self::DEFAULT_MAX_DEPTH)
    {
        if ($maxDepth <= 0) {
            return null;
        }

        $children = $this->getChildren()->all();

        /** @var $child NodeInterface */
        foreach ($children as $child) {
            if ($child->getId() === $id) {
                return $child;
            }

            $descendant = $child->findNode($id, $maxDepth - 1);

            if ($descendant !== null) {
                return $descendant;
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasParent()
    {
        return $this->parent !== null;
    }

    /**
     * @return NodeInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param NodeInterface $parent
     */
    public function setParent(NodeInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}
