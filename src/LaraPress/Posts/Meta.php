<?php namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Meta extends Eloquent {

    protected $table = 'wp_postmeta';

    public function getValue()
    {
        return $this->attributes['meta_value'];
    }

    public function getKey()
    {
        return $this->attributes['meta_key'];
    }
}
