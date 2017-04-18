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
    public function findBySlug(string $slug)
    {
        return $this->findOneBy([
            'slug' => $slug
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function listPublished(): array
    {
        return $this->findBy([
            'published' => true
        ]);
    }

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
    public function update(Post $post)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->flush($post);
    }
}