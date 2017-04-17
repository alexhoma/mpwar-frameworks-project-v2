<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TrackerBundle\Services\ListPosts;
use TrackerBundle\Services\ListRecords;
use TrackerBundle\Services\SearchPostById;
use TrackerBundle\Services\SearchRecordById;

class DashboardController extends Controller
{
    /**
     * Dashboard index / registry list
     * Displays two lists:
     *  - Posts list
     *  - Records list
     */
    public function dashboardAction()
    {
        /** @var ListRecords $listRecords */
        $listRecords = $this->get('list.records');
        $records     = $listRecords();

        /** @var ListPosts $listPosts */
        $listPosts = $this->get('list.posts');
        $posts     = $listPosts();

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
        /** @var SearchRecordById $searchRecordById */
        $searchRecordById = $this->get('search.record.by_id');
        $record           = $searchRecordById($recordId);

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
        /** @var SearchPostById $searchPostById */
        $searchPostById = $this->get('search.post.by_id');
        $post           = $searchPostById($postId);

        // get post visits (post records)
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $records       = $entityManager
            ->getRepository('TrackerBundle\Entity\Record')
            ->findBy(['post' => $post]);

        return $this->render('TrackerBundle:Tracker:postRecordsDetail.html.twig', array(
            'post' => $post,
            'records' => $records
        ));
    }
}