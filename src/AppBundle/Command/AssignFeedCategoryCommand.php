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

class AssignFeedCategoryCommand extends ContainerAwareCommand
{
    const NAME                  = 'rss-feed:assign-category';

    const ARGUMENT_URL          = 'url';
    const ARGUMENT_CATEGORY     = 'category';

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Command for rss feed category assign')
            ->addArgument(
                self::ARGUMENT_URL,
                InputArgument::REQUIRED,
                'Feed url'
            )
            ->addArgument(
                self::ARGUMENT_CATEGORY,
                InputArgument::REQUIRED,
                'Category of the rss feed'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->getContainer()->get('feed.service')->assignFeedCategory(
                $input->getArgument(self::ARGUMENT_URL),
                $input->getArgument(self::ARGUMENT_CATEGORY)
            );

            $output->writeln('Feed category assign success');
            return 0;
        } catch(\Exception $e) {
            $output->writeln('Feed category assign failed');
            $output->writeln($e->getMessage());
            return 1;
        }
    }
}