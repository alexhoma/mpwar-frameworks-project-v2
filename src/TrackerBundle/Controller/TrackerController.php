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
     * Insert registry
     * Handles ajax request with all user agent data
     * Persists this data into a record table
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function trackAction(Request $request)
    {
        $tracked = json_decode($request->getContent());

        /** @var SearchPostBySlug $searchPostBySlug */
        $searchPostBySlug = $this->get('search.post.by_slug');
        $post = $searchPostBySlug($tracked->postSlug);

        $record = new Record(
            $post,
            $tracked->device,
            $tracked->operatingSystem,
            $tracked->browser,
            $tracked->version,
            $tracked->language,
            $tracked->cookieEnabled
        );

        /** @var CreateRecordUseCase $createRecordUseCase */
        $createRecordUseCase = $this->get('create.record');
        $createRecordUseCase($record);

        return new JsonResponse(array('tracked' => true));
    }

}
