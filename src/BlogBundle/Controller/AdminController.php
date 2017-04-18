<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use BlogBundle\Form\PostType;
use BlogBundle\Services\CreatePostUseCase;
use BlogBundle\Services\ListAllPosts;
use BlogBundle\Services\SearchPostBySlug;
use BlogBundle\Services\UpdatePostUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends Controller
{
    /**
     * Shows post list
     * The Admin index
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adminAction()
    {
        /** @var ListAllPosts $listAllPosts */
        $listAllPosts = $this->get('blog_post.list.all');
        $posts        = $listAllPosts();

        return $this->render('BlogBundle:Admin:list.html.twig', array(
            'posts' => $posts,
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
        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            /** @var CreatePostUseCase $createPostUseCase */
            $createPostUseCase = $this->get('blog_post.create');
            $createPostUseCase($post);
            $this->throwPostCreatedSuccessFlashMessage($post);

            return $this->redirectToRoute('blog_list');
        }

        return $this->render('BlogBundle:Admin:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Throws a success flash message
     * when new post is created
     *
     * @param $post
     */
    private function throwPostCreatedSuccessFlashMessage(Post $post)
    {
        $this->addFlash(
            'success',
            'Post "' . $post->getTitle() . '" created successfully!'
        );
    }

    /**
     * Edit current post | show edit form
     * depends on the request method
     *
     * @param Request $request
     * @param $postSlug
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editPostAction(Request $request, $postSlug)
    {
        /** @var SearchPostBySlug $searchPostBySlug */
        $searchPostBySlug = $this->get('blog_post.find.by_slug');
        $post             = $searchPostBySlug($postSlug);

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            /** @var UpdatePostUseCase $updatePostUseCase */
            $updatePostUseCase = $this->get('blog_post.update');
            $updatedPost       = $updatePostUseCase($post);
            $this->throwPostUpdatedSuccessFlashMessage($post);

            return $this->redirectToRoute('post', [
                'postSlug' => $updatedPost->getSlug()
            ]);
        }

        return $this->render('BlogBundle:Admin:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Throws a success flash message
     * when a post is updated
     *
     * @param $post
     */
    private function throwPostUpdatedSuccessFlashMessage(Post $post)
    {
        $this->addFlash(
            'success',
            'Post updated successfully!'
        );
    }
}