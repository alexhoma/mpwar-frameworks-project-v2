<?php

namespace BlogBundle\Services;

use BlogBundle\Entity\PostRepository;
use Doctrine\ORM\EntityNotFoundException;

class SearchPostBySlug
{
    private $postRepository;

    public function __construct(
        PostRepository $postRepository
    )
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(string $slug)
    {
        $post = $this->postRepository->findBySlug($slug);
        $this->ensurePostExists($post, $slug);

        return $post;
    }

    /**
     * Guard clause to ensure if a post exists
     * otherwise throws an EntityNotFoundException
     *
     * @param $post
     * @param $slug
     * @throws EntityNotFoundException
     */
    private function ensurePostExists($post, $slug)
    {
        if (!$post) {
            throw new EntityNotFoundException(
                'Post with slug: "' . $slug . '" not found!'
            );
        }
    }
}