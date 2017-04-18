<?php

namespace BlogBundle\Controller;

use BlogBundle\Services\ListPublishedPosts;
use BlogBundle\Services\SearchPostBySlug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BlogController extends Controller
{
    /**
     * Shows posts published list
     * The main view of the blog
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction()
    {
        /** @var ListPublishedPosts $listPublishedPosts */
        $listPublishedPosts = $this->get('blog_post.list.published');
        $posts              = $listPublishedPosts();

        return $this->render('BlogBundle:Blog:list.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * Shows post detail
     *
     * @param $postSlug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction($postSlug)
    {
        /** @var SearchPostBySlug $searchPostBySlug */
        $searchPostBySlug = $this->get('blog_post.find.by_slug');
        $post             = $searchPostBySlug($postSlug);

        return $this->render('BlogBundle:Blog:post.html.twig', array(
            'post' => $post
        ));
    }
}
