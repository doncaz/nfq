<?php
/**
 * Created by PhpStorm.
 * User: donatas
 * Date: 16.6.11
 * Time: 14.13
 */

namespace AppBundle\Command;

use AppBundle\Entity\Feeds;
use Debril\RssAtomBundle\Exception\FeedException\FeedNotFoundException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SyncFeedCommand extends ContainerAwareCommand
{
    const NAME          = 'rss-feed:sync';

    const OPTION_URL    = 'url';

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Command synchronize feeds')
            ->addOption(
                self::OPTION_URL,
                null,
                InputOption::VALUE_OPTIONAL,
                'Feed url'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $url = $input->getOption(self::OPTION_URL);

            if ($url) {
                $feed = $this->getContainer()
                    ->get('feed.service')
                    ->loadFeedByUrl($url);

                if($feed instanceof Feeds) {
                    $this->getContainer()
                        ->get('feed.processor.sync')
                        ->process($feed);
                } else {
                    throw new FeedNotFoundException('Feed with given url not exist');
                }
            } else {
                $this->getContainer()
                    ->get('feed.processor.sync')
                    ->doSync();
            }

            $output->writeln('Sync success');
            return 0;
        } catch(\Exception $e) {
            $output->writeln('Sync failed');
            $output->writeln($e->getMessage());
            return 1;
        }
    }
}