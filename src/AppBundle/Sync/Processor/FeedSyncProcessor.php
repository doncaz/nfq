<?php
/**
 * Created by PhpStorm.
 * User: donatas
 * Date: 16.6.11
 * Time: 17.35
 */

namespace AppBundle\Sync\Processor;

use AppBundle\Entity\Feeds;
use AppBundle\Service\Feed\FeedService;
use Debril\RssAtomBundle\Protocol\FeedReader;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class FeedSyncProcessor implements LoggerAwareInterface
{
    /**
     * @SPL php traits
     */
    use LoggerAwareTrait;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var FeedReader
     */
    private $feedReader;

    /**
     * @var FeedService
     */
    private $feedService;

    public function __construct(
        EntityManager $entityManager,
        FeedReader $feedReader,
        FeedService $feedService)
    {
        $this->entityManager    = $entityManager;
        $this->feedReader       = $feedReader;
        $this->feedService      = $feedService;
    }

    public function doSync()
    {
        /** @var Feeds[] $feedList */
        $feedList = $this->entityManager
            ->getRepository('AppBundle:Feeds')
            ->findAll();

        foreach ($feedList as $feed) {
            $this->logger->info(sprintf('Feed "%s" processing start', $feed->getTitle()));
            try {
                $this->process($feed);
                $this->logger->info(sprintf('Feed "%s" processing end', $feed->getTitle()));
            } catch(\Exception $e) {
                $this->logger->error(sprintf('Feed processing failed "%s"', $e->getMessage()));
            }
        }
    }

    /**
     * @param Feeds $feed
     */
    public function process(Feeds $feed)
    {
        $feedContent = $this->feedReader->getFeedContent(
            $feed->getUrl(),
            $feed->getLastUpdate()
        );

        /** @var \Debril\RssAtomBundle\Protocol\Parser\Item[] $items */
        $items = $feedContent->getItems();

        $newItems = count($items);
        $success = 0;

        foreach ($items as $item) {
            try {
                $this->feedService->createFeedItem(
                    $item->getTitle(),
                    $item->getLink(),
                    $item->getDescription(),
                    $item->getUpdated(),
                    $feed
                );
                $this->logger->info(sprintf('Item "%s" persisted', $item->getTitle()));
                $success++;
            } catch (\Exception $e) {
                $this->logger->error(sprintf('Item "%s" not persisted "%s"', $item->getTitle(), $e->getMessage()));
            }
        }

        $this->logger->info(sprintf('New items found %d, success persisted %s', $newItems, $success));

        $feed->setLastUpdate(new \DateTime());
        $this->entityManager->flush();
    }
}