<?php
/**
 * Created by PhpStorm.
 * User: donatas
 * Date: 16.6.11
 * Time: 16.22
 */

namespace AppBundle\Model\Feed;

use Symfony\Component\Validator\Constraints as Assert;

class FeedModel
{
    /**
     * @var string
     *
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url"
     * )
     */
    protected $url;

    /**
     * @var string
     *
     * @Assert\NotNull(
     *    message = "The title must be set"
     * )
     */
    protected $title;

    /**
     * @var string
     *
     * @Assert\NotNull(
     *    message = "The category must be set"
     * )
     */
    protected $category;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     *
     * @return FeedModel
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return FeedModel
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     *
     * @return FeedModel
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }
}