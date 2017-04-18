<?php

namespace BlogBundle\Services;

use BlogBundle\Entity\Post;
use BlogBundle\Entity\PostRepository;
use Cocur\Slugify\Slugify;


class UpdatePostUseCase
{
    private $postRepository;
    private $slugify;

    public function __construct(
        PostRepository $postRepository,
        Slugify $slugify
    )
    {
        $this->postRepository = $postRepository;
        $this->slugify        = $slugify;
    }

    public function __invoke(Post $post)
    {
        $post->setTitle($post->getTitle());
        $post->setDescription($post->getDescription());
        $post->setPublished($post->getPublished());
        $post->setSlug(
            $this->slugify->slugify(
                $post->getTitle()
            )
        );

        $this->postRepository->update($post);

        return $post;
    }

}