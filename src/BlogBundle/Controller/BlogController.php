<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use Cocur\Slugify\Slugify;
use BlogBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    private $slugify;

    public function __construct()
    {
        $this->slugify = new Slugify();
    }

    /**
     * Shows post list / home blog
     */
    public function blogAction()
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $posts = $entityManager
            ->getRepository('BlogBundle\Entity\Post')
            ->findAll();

        return $this->render('BlogBundle:Blog:blog.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * Shows post detail
     * @param $postSlug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction($postSlug)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $post = $entityManager
            ->getRepository('BlogBundle\Entity\Post')
            ->findOneBy(['slug' => $postSlug]);

        $this->ensurePostExists($postSlug, $post);

        return $this->render('BlogBundle:Blog:post.html.twig', array(
            'post' => $post
        ));
    }

    /**
     * Guard clause to ensure the post we are looking exists
     * @param $postSlug
     * @param $post
     */
    private function ensurePostExists($postSlug, $post)
    {
        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for this slug: ' . $postSlug
            );
        }
    }

    /**
     * Create new post or show form
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createPostAction(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $post      = $form->getData();
            $postTitle = $post->getTitle();

            // Add post slug
            $postSlug = $this->slugify->slugify($postTitle);
            $post->setSlug($postSlug);
            $post->setDatetime(date_create(date("Y-m-d H:i:s")));

            $entityManager = $this->get('doctrine.orm.default_entity_manager');
            $entityManager->persist($post);
            $entityManager->flush();

            $request
                ->getSession()
                ->getFlashBag()
                ->add('success', 'Post created successfully!');

            return $this->redirectToRoute('blog_list');
        }

        return $this->render('BlogBundle:Blog:createPost.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
