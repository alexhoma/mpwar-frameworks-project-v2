<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TrackerBundle\Services\SearchRecordUseCase;

class DashboardController extends Controller
{
    /**
     * Dashboard index / registry list
     * Displays two lists:
     *  - Posts list
     *  - Records list
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $records = $entityManager
            ->getRepository('TrackerBundle\Entity\Record')
            ->findAll();
        $posts = $entityManager
            ->getRepository('BlogBundle\Entity\Post')
            ->findAll();

        return $this->render('TrackerBundle:Tracker:dashboard.html.twig', array(
            'records' => $records,
            'posts' => $posts
        ));
    }

    /**
     * Show single record details
     * Displays the user agent data of a single record
     */
    public function recordAction($recordId)
    {
        /** @var SearchRecordUseCase $searchRecordUseCase */
        $searchRecordUseCase = $this->get('search.record');
        $record = $searchRecordUseCase($recordId);

        return $this->render('TrackerBundle:Tracker:recordDetail.html.twig', array(
            'record' => $record
        ));
    }

    /**
     * Shows a list of records related to a post
     * The list of "visits" tracked of a post.
     */
    public function postRecordsAction($postId)
    {
        /** @var SearchRecordUseCase $searchPostUseCase */
        $searchPostUseCase = $this->get('search.post');
        $post = $searchPostUseCase($postId);

        // get records
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $records = $entityManager
            ->getRepository('TrackerBundle\Entity\Record')
            ->findBy(['post' => $post]);

        return $this->render('TrackerBundle:Tracker:postRecordsDetail.html.twig', array(
            'post' => $post,
            'records' => $records
        ));
    }
}