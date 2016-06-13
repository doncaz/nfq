<?php
/**
 * Created by PhpStorm.
 * User: donatas
 * Date: 16.6.11
 * Time: 15.43
 */

namespace AppBundle\Service\Feed;

use AppBundle\Entity\Feeds;
use AppBundle\Exception\FeedExistException;
use AppBundle\Exception\FeedNotFoundException;
use AppBundle\Model\Feed\FeedFactory;
use Doctrine\ORM\EntityManager;

class FeedService
{
    private $entityManager;

    private $feedFactory;

    public function __construct(EntityManager $entityManager, FeedFactory $feedFactory)
    {
        $this->entityManager  = $entityManager;
        $this->feedFactory    = $feedFactory;
    }

    /**
     * @param string $url
     * @param string $title
     * @param string $category
     *
     * @return Feeds
     *
     * @throws FeedExistException
     */
    public function createFeed($url, $title, $category)
    {
        $feedEntity = $this->loadFeedByUrl($url);

        if (!is_null($feedEntity)) {
            throw new FeedExistException('Feed with given url already exist');
        }

        $feed = $this->feedFactory->createFeed(
            $url,
            $title,
            $category
        );

        $this->entityManager->persist($feed);
        $this->entityManager->flush();

        return $feed;
    }

    /**
     * @param string $url
     * @param string $category
     *
     * @return Feeds
     *
     * @throws FeedNotFoundException
     */
    public function assignFeedCategory($url, $category)
    {
        $feedEntity = $this->loadFeedByUrl($url);

        if (is_null($feedEntity)) {
            throw new FeedNotFoundException('Feed with given url not exist');
        }

        $feedEntity
            ->setCategory($category);

        $this->entityManager->flush();

        return $feedEntity;
    }

    /**
     * @param string $title
     * @param string $link
     * @param string $description
     * @param \DateTime $publishedDate
     * @param Feeds $feed
     * @return \AppBundle\Entity\Items
     */
    public function createFeedItem($title, $link, $description, \DateTime $publishedDate, Feeds $feed)
    {
        $feedItem = $this->feedFactory->createFeedItem(
            $title,
            $link,
            $description,
            $publishedDate,
            $feed
        );

        $this->entityManager->persist($feedItem);
        $this->entityManager->flush();

        return $feedItem;
    }

    /**
     * @param $url
     *
     * @throws FeedNotFoundException
     */
    public function removeFeed($url)
    {
        $feed = $this->loadFeedByUrl($url);

        if (is_null($feed)) {
            throw new FeedNotFoundException('Feed with given url not exist');
        }

        $this->entityManager->remove($feed);
        $this->entityManager->flush();
    }

    /**
     * @param $url
     * @return null|Feeds
     */
    public function loadFeedByUrl($url)
    {
        return $this->entityManager
            ->getRepository('AppBundle:Feeds')
            ->findOneBy([
                'url' => $url
            ]);
    }
}