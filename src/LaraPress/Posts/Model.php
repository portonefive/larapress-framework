<?php namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent {

    protected $table = 'wp_posts';

    protected $with = ['meta'];

    protected $dates = ['post_modified', 'post_modified_gmt', 'post_date', 'post_date_gmt'];

    protected $guarded = [''];

    protected $the_post;

    public static function boot()
    {
        parent::boot();

        self::addGlobalScope(new PostTypeScope());
        self::addGlobalScope(new PublishedScope());
    }

    public static function resolveWordpressPostToModel(\WP_Post $post)
    {
        /** @var PostTypeManager $postTypes */
        $postTypes = app('posts.types');

        if ($class = $postTypes->get($post->post_type))
        {
            return with(new $class)->newInstance($post->to_array());
        }

        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meta()
    {
        return $this->hasMany('LaraPress\Posts\Meta', 'post_id', 'ID');
    }

    /**
     * @param $metaKey
     *
     * @return mixed
     */
    public function getMeta($metaKey)
    {
        /** @var Collection $matchingMeta */
        $matchingMeta = $this->meta->filter(
            function (Meta $meta) use ($metaKey)
            {
                return $meta->getKey() == $metaKey;
            }
        );

        return $matchingMeta->count() == 1 ? $matchingMeta->first()->getValue() : null;
    }

    /**
     * @param $metaKey
     * @param $metaValue
     */
    public function setMeta($metaKey, $metaValue)
    {
        update_post_meta($this->ID, $metaKey, $metaValue);

        $this->load('meta');
    }

    public function toWordpressPost()
    {
        $postData = (object)$this->toArray();

        return new \WP_Post($postData);
    }
}
