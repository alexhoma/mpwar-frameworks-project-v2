<?php


namespace TrackerBundle\Services;


use BlogBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use TrackerBundle\Entity\Record;

class ListPostRecords
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(Post $post)
    {
        $records = $this->entityManager
            ->getRepository(Record::class)
            ->findBy(['post' => $post]);

        return $records;
    }
}