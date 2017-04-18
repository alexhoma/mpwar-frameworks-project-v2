<?php

namespace BlogBundle\Controller;

use BlogBundle\Services\ListPosts;
use BlogBundle\Services\SearchPostBySlug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BlogController extends Controller
{
    /**
     * Shows post list / home blog
     * The main view of the blog
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction()
    {
        /** @var ListPosts $listPosts */
        $listPosts = $this->get('blog_post.list');
        $posts     = $listPosts();

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
