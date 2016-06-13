<?php
/**
 * Created by PhpStorm.
 * User: donatas
 * Date: 16.6.11
 * Time: 14.32
 * Design pattern: Simple factory
 * Pattern source: https://github.com/domnikl/DesignPatternsPHP/tree/master/Creational/SimpleFactory
 */
namespace AppBundle\Model\Feed;

use AppBundle\Entity\Feeds;
use AppBundle\Entity\Items;

class FeedFactory
{

    /**
     * @param string $url
     * @param string $title
     * @param string $category
     *
     * @return Feeds
     */
    public function createFeed($url, $title, $category)
    {
        /**
         * @SPL Class member access on instantiation
         */
        return (new Feeds())
            ->setUrl($url)
            ->setTitle($title)
            ->setCategory($category);
    }

    /**
     * @param string $title
     * @param string $link
     * @param string $description
     * @param \DateTime $publishDate
     * @param Feeds $feed
     *
     * @return Items
     */
    public function createFeedItem($title, $link, $description, \DateTime $publishDate, Feeds $feed)
    {
        /**
         * @SPL Class member access on instantiation
         */
        return (new Items())
            ->setTitle($title)
            ->setLink($link)
            ->setDescription($description)
            ->setPublished($publishDate)
            ->setFeed($feed);
    }
}