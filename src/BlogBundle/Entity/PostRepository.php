<?php

namespace BlogBundle\Entity;

interface PostRepository
{
    /**
     * Finds a post by its slug
     *
     * @param string $slug
     * @return mixed
     */
    public function findBySlug(string $slug);

    /**
     * Lists all posts
     *
     * @return array
     */
    public function listPublished(): array;

    /**
     * Persists a post into database
     *
     * @param Post $post
     * @return mixed
     */
    public function save(Post $post);

    /**
     * Updates a Post
     *
     * @param Post $post
     * @return Post
     */
    public function update(Post $post);
}