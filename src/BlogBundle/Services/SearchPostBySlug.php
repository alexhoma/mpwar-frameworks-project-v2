<?php

namespace BlogBundle\Services;

use BlogBundle\Entity\PostRepository;

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
     * otherwise throws a NotFoundException
     *
     * @param $post
     * @param $slug
     */
    private function ensurePostExists($post, $slug)
    {
        if (!$post) {
            throw $this->createNotFoundException(
                'Post with slug: "' . $slug . '" not found!'
            );
        }
    }
}