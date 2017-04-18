<?php


namespace BlogBundle\Services;

use BlogBundle\Entity\PostRepository;

class ListPosts
{
    private $postRepository;

    public function __construct(
        PostRepository $postRepository
    )
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(): array
    {
        $records = $this->postRepository->list();

        return $records;
    }
}