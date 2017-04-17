<?php

namespace TrackerBundle\Services;

use BlogBundle\Entity\Post;
use Doctrine\ORM\EntityManager;

class SearchPostByIdUseCase
{
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    function __invoke($postId)
    {
        $post = $this->entityManager
            ->getRepository(Post::class)
            ->find($postId);

        $this->ensurePostExists($post);

        return $post;
    }

    /**
     * @param $post
     */
    private function ensurePostExists($post)
    {
        if (!$post) {
            throw $this->createNotFoundException('Post not found!');
        }
    }
}