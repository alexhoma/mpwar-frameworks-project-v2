<?php


namespace TrackerBundle\Entity;

use BlogBundle\Entity\Post;
use DateTime;


class Record
{
    private $id;
    private $post;
    private $device;
    private $operatingSystem;
    private $browser;
    private $version;
    private $language;
    private $cookieEnabled;
    private $datetime;

    /**
     * Record constructor.
     * @param $post
     * @param $device
     * @param $operatingSystem
     * @param $browser
     * @param $version
     * @param $language
     * @param $cookieEnabled
     */
    public function __construct(
        $post,
        $device,
        $operatingSystem,
        $browser,
        $version,
        $language,
        $cookieEnabled
    )
    {
        $this->post            = $post;
        $this->device          = $device;
        $this->operatingSystem = $operatingSystem;
        $this->browser         = $browser;
        $this->version         = $version;
        $this->language        = $language;
        $this->cookieEnabled   = $cookieEnabled;
        $this->datetime        = new DateTime('now');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @return string
     */
    public function getDevice(): string
    {
        return $this->device;
    }

    /**
     * @return string
     */
    public function getOperatingSystem(): string
    {
        return $this->operatingSystem;
    }

    /**
     * @return string
     */
    public function getBrowser(): string
    {
        return $this->browser;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return bool
     */
    public function getCookieEnabled(): bool
    {
        return $this->cookieEnabled;
    }

    /**
     * @return DateTime
     */
    public function getDatetime(): DateTime
    {
        return $this->datetime;
    }
}