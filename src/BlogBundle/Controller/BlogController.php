<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use BlogBundle\Form\PostType;
use BlogBundle\Services\CreatePostUseCase;
use BlogBundle\Services\ListPosts;
use BlogBundle\Services\SearchPostBySlug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

        return $this->render('BlogBundle:Blog:blog.html.twig', array(
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
        $searchPostBySlug = $this->get('blog_post.search.by_slug');
        $post             = $searchPostBySlug($postSlug);

        return $this->render('BlogBundle:Blog:post.html.twig', array(
            'post' => $post
        ));
    }

    /**
     * Create new post | show form
     * depends on the request method
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createPostAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            /** @var CreatePostUseCase $createPostUseCase */
            $createPostUseCase = $this->get('blog_post.create');
            $createPostUseCase($post);
            $this->throwSuccessFlashMessage($post);

            return $this->redirectToRoute('blog_list');
        }

        return $this->render('BlogBundle:Blog:createPost.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Throws a success flash message
     * when new post is created
     *
     * @param $post
     */
    private function throwSuccessFlashMessage(Post $post)
    {
        $this->addFlash(
            'success',
            'Post "' . $post->getTitle() . '" created successfully!'
        );
    }
}
