<?php

namespace AlertBundle\Services;


use Doctrine\ORM\EntityManager;
use Swift_Mailer;
use Swift_Message;
use TrackerBundle\Entity\Record;

class Alert
{
    const MIN_COUNT_ALERT   = 10;
    const MED_COUNT_ALERT   = 50;
    const MAX_COUNT_ALERT   = 100;
    const SENDER_EMAIL      = 'alexcm.14@gmail.com';
    const DESTINATION_EMAIL = 'alexcm.14@gmail.com';

    private $mailer;
    private $entityManager;

    /**
     * Alert constructor.
     * @param Swift_Mailer $mailer
     * @param EntityManager $entityManager
     */
    public function __construct(
        Swift_Mailer $mailer,
        EntityManager $entityManager
    )
    {
        $this->mailer        = $mailer;
        $this->entityManager = $entityManager;
    }

    /**
     * Class entry point
     * Receives the event of the every current visited post
     * and decides if it should alert or not
     * depending on the visits/records count
     *
     * @param $recordEvent
     */
    public function shouldAlert($recordEvent)
    {
        $post         = $recordEvent->getPost();
        $recordsCount = $this->recordsCount($post);

        if ($this->hasReachedEnoughToAlert($recordsCount)) {
            $this->sendAlert($post, $recordsCount);
        }
    }

    /**
     * Counts the total visits/records
     * of a post
     *
     * @param $post
     * @return int
     */
    private function recordsCount($post)
    {
        $records = $this->entityManager
            ->getRepository(Record::class)
            ->findBy(['post' => $post]);

        return count($records);
    }

    /**
     * Sends an email alert
     * Telling to the destination email that his
     * post has reached a specified amount of visits.
     *
     * @param $post
     * @param $recordsCount
     */
    private function sendAlert($post, $recordsCount)
    {
        $message = Swift_Message::newInstance()
            ->setSubject('Congratulations')
            ->setFrom(self::SENDER_EMAIL)
            ->setTo(self::DESTINATION_EMAIL)
            ->setBody('Visits alert:')
            ->addPart(
                'Your post <b>' . $post->getTitle() . '</b> has reached <b>' . $recordsCount . ' visits.</b>',
                'text/html'
            );

        $this->mailer->send($message);
    }

    /**
     * Verifies if a post has reached the
     * specified visits/records count
     *
     * @param $recordsCount
     * @return bool
     */
    private function hasReachedEnoughToAlert($recordsCount): bool
    {
        return ($recordsCount == self::MIN_COUNT_ALERT ||
                $recordsCount == self::MED_COUNT_ALERT ||
                $recordsCount == self::MAX_COUNT_ALERT);
    }
}