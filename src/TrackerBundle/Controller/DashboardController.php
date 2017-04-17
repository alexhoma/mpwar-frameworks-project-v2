<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TrackerBundle\Services\ListPostRecords;
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
     *
     * @return \Symfony\Component\HttpFoundation\Response
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
     *
     * @param $recordId
     * @return \Symfony\Component\HttpFoundation\Response
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
     * Shows the number of "visits/records" related to a post.
     * It gets the records from the Record Entity
     * because the Post Entity isn't from this bundle.
     *
     * @param $postId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postRecordsAction($postId)
    {
        /** @var SearchPostById $searchPostById */
        $searchPostById = $this->get('search.post.by_id');
        $post           = $searchPostById($postId);

        /** @var ListPostRecords $listPostRecords */
        $listPostRecords = $this->get('list.post_records');
        $postRecords     = $listPostRecords($post);

        return $this->render('TrackerBundle:Tracker:postRecordsDetail.html.twig', array(
            'post' => $post,
            'postRecords' => $postRecords
        ));
    }
}