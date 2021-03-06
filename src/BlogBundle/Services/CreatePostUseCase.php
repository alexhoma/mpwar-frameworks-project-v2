<?php

namespace BlogBundle\Services;

use BlogBundle\Entity\Post;
use BlogBundle\Entity\PostRepository;
use Cocur\Slugify\Slugify;


class CreatePostUseCase
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

    /**
     * Set post slug and save it
     *
     * @param Post $post
     */
    public function __invoke(Post $post)
    {
        $postTitle = $post->getTitle();
        $postSlug  = $this->slugify->slugify($postTitle);
        $post->setSlug($postSlug);

        $this->postRepository->save($post);
    }
}