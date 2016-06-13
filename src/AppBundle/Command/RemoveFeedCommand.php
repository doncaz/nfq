<?php
/**
 * Created by PhpStorm.
 * User: donatas
 * Date: 16.6.11
 * Time: 14.13
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveFeedCommand extends ContainerAwareCommand
{
    const NAME          = 'rss-feed:remove';

    const ARGUMENT_URL  = 'url';

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Command for remove rss feed')
            ->addArgument(
                self::ARGUMENT_URL,
                InputArgument::REQUIRED,
                'Feed url'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->getContainer()->get('feed.service')->removeFeed(
                $input->getArgument(self::ARGUMENT_URL)
            );

            $output->writeln('Feed remove success');
            return 0;
        } catch(\Exception $e) {
            $output->writeln('Feed remove failed');
            $output->writeln($e->getMessage());
            return 1;
        }
    }
}