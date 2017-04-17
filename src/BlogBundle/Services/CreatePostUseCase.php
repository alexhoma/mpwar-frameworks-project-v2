<?php

namespace BlogBundle\Services;

use BlogBundle\Entity\Post;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManager;


class CreatePostUseCase
{
    private $entityManager;
    private $slugify;

    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
        $this->slugify = new Slugify();
    }

    public function __invoke(Post $post)
    {
        // set slug
        $postTitle = $post->getTitle();
        $postSlug = $this->slugify->slugify($postTitle);
        $post->setSlug($postSlug);

        $this->entityManager->persist($post);
        $this->entityManager->flush($post);
    }
}