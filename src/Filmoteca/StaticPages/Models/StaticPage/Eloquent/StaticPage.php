<?php

namespace Filmoteca\StaticPages\Models\StaticPage\Eloquent;

use Filmoteca\StaticPages\Models\StaticPage\StaticPageInterface;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Str;

/**
 * Class StaticPage
 * @property int        id
 * @property string     title
 * @property string     content
 * @property string     status
 * @property string     slug
 * @property int        parent_page_id
 * @property mixed      childPages
 * @package Filmoteca\StaticPages\Models
 */
class StaticPage extends Eloquent implements StaticPageInterface
{
    /**
     * @var string
     */
    protected $table = 'filmoteca_static_pages';

    /**
     * @var array
     */
    protected $fillable = ['id', 'title', 'content', 'status', 'slug', 'parent_page_id'];

    /**
     * @var array
     */
    protected static $availableStatus = ['publish', 'pending', 'draft', 'trash'];

    /**
     * @var string
     */
    protected static $childPageModel = '\Filmoteca\StaticPages\Models\StaticPage\Eloquent\StaticPage';

    /**
     * @var string
     */
    protected static $parentPageModel = '\Filmoteca\StaticPages\Models\StaticPage\Eloquent\StaticPage';

    /**
     * @return Collection
     */
    public function getChildPages()
    {
        return $this->childPages;
    }

    /**
     * @param StaticPageInterface $staticPage
     * @return void
     */
    public function addChildPage(StaticPageInterface $staticPage)
    {
        if (!$staticPage instanceof StaticPage) {
            throw new \InvalidArgumentException(
                'This implementation requires a Eloquent object. ' . gettype($staticPage) . 'given.'
            );
        }

        $this->childPages()->save($staticPage);
    }

    /**
     * @return bool
     */
    public function hasParent()
    {
        return $this->parent_page_id !== null;
    }

    /**
     * @return array
     */
    public static function getAvailableStatus()
    {
        return self::$availableStatus;
    }

    /*
     |-------------------------------------------------------------------------
     | Relationships
     |-------------------------------------------------------------------------
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childPages()
    {
        return $this->hasMany(static::$childPageModel, 'parent_pages_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentPage()
    {
        return $this->belongsTo(static::$parentPageModel);
    }

    /*
     |------------------------------------------------------------------------
     | Getters and Setter
     |-------------------------------------------------------------------------
     */

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_page_id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        if (!in_array(Str::slug($status), self::$availableStatus)) {
            throw new \InvalidArgumentException('The available status were: ' . implode(',', self::$availableStatus));
        }

        $this->status = $status;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @param $parentId
     */
    public function setParentId($parentId)
    {
        $this->parent_page_id = $parentId;
    }
}
