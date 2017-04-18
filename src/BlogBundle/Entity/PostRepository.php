<?php

namespace BlogBundle\Entity;

interface PostRepository
{
    /**
     * Persists a post into database
     *
     * @param Post $post
     * @return mixed
     */
    public function save(Post $post);

    /**
     * Lists all posts
     *
     * @return array
     */
    public function list(): array;

    /**
     * Finds a post by its slug
     *
     * @param string $slug
     * @return mixed
     */
    public function findBySlug(string $slug);
}