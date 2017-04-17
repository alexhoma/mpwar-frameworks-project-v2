<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TrackerBundle\Entity\Record;
use TrackerBundle\Services\CreateRecordUseCase;
use TrackerBundle\Services\SearchPostBySlug;


class TrackerController extends Controller
{
    /**
     * Creates a new record when a user visits a post.
     * Handles ajax request with all user agent data
     * And persists this data into a record table
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function trackAction(Request $request)
    {
        $trackedRecord = json_decode($request->getContent());

        /** @var SearchPostBySlug $searchPostBySlug */
        $searchPostBySlug = $this->get('search.post.by_slug');
        $post             = $searchPostBySlug($trackedRecord->postSlug);

        $record = new Record(
            $post,
            $trackedRecord->device,
            $trackedRecord->operatingSystem,
            $trackedRecord->browser,
            $trackedRecord->version,
            $trackedRecord->language,
            $trackedRecord->cookieEnabled
        );

        /** @var CreateRecordUseCase $createRecordUseCase */
        $createRecordUseCase = $this->get('create.record');
        $createRecordUseCase($record);

        return new JsonResponse([
            'tracked' => true
        ]);
    }
}
