<?php

namespace BlogBundle\Repository;

use BlogBundle\Entity\Post;
use BlogBundle\Entity\PostRepository;
use Doctrine\ORM\EntityRepository;


class DoctrinePostRepository extends EntityRepository implements PostRepository
{
    /**
     * {@inheritdoc}
     */
    public function save(Post $post)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($post);
        $entityManager->flush($post);
    }

    /**
     * {@inheritdoc}
     */
    public function list(): array
    {
        return $this->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlug(string $slug)
    {
        return $this->findOneBy([
            'slug' => $slug
        ]);
    }
}