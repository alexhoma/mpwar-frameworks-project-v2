<?php

namespace TrackerBundle\Entity;

use BlogBundle\Entity\Post;


interface RecordRepository
{
    public function save(Record $record);

    public function list(): array;

    public function findById(int $id);

    public function findByPost(Post $post): array;
}