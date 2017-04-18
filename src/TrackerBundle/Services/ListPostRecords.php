<?php

namespace TrackerBundle\Services;

use BlogBundle\Entity\Post;
use TrackerBundle\Entity\RecordRepository;


class ListPostRecords
{
    private $recordRepository;

    public function __construct(
        RecordRepository $recordRepository
    )
    {
        $this->recordRepository = $recordRepository;
    }

    public function __invoke(Post $post)
    {
        $records = $this->recordRepository->findByPost($post);

        return $records;
    }
}