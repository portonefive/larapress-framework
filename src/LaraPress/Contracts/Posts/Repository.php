<?php namespace LaraPress\Contracts\Posts;

use App\Post;

interface Repository {

    /**
     * @param $id
     *
     * @return Post
     */
    public function findById($id);

    /** @return string */
    public function getModelClassName();
}
