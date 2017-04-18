<?php

namespace TrackerBundle\Repository;

use BlogBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;
use TrackerBundle\Entity\Record;
use TrackerBundle\Entity\RecordRepository;


class DoctrineRecordRepository extends EntityRepository implements RecordRepository
{
    public function save(Record $record)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($record);
        $entityManager->flush($record);
    }

    public function list(): array
    {
        return $this->findAll();
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function findByPost(Post $post): array
    {
        return $this->findBy([
            'post' => $post
        ]);
    }
}