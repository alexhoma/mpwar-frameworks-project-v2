<?php

namespace TrackerBundle\Entity;

use BlogBundle\Entity\Post;


interface RecordRepository
{
    /**
     * Persists a Record into database
     *
     * @param Record $record
     * @return mixed
     */
    public function save(Record $record);

    /**
     * List all records
     *
     * @return array
     */
    public function list(): array;

    /**
     * Find Record by Id
     *
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

    /**
     * Find Record by its related Post
     *
     * @param Post $post
     * @return array
     */
    public function findByPost(Post $post): array;
}