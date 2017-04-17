<?php


namespace TrackerBundle\Services;

use BlogBundle\Entity\Post;
use Doctrine\ORM\EntityManager;

class ListPosts
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke()
    {
        $records = $this->entityManager
            ->getRepository(Post::class)
            ->findAll();

        return $records;
    }
}