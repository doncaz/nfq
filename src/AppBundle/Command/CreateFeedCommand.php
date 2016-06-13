<?php
/**
 * Created by PhpStorm.
 * User: donatas
 * Date: 16.6.11
 * Time: 14.13
 */

namespace AppBundle\Command;

use AppBundle\Model\Feed\FeedModel;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class CreateFeedCommand extends ContainerAwareCommand
{
    const NAME              = 'rss-feed:create';

    const ARGUMENT_URL      = 'url';
    const ARGUMENT_TITLE    = 'title';
    const ARGUMENT_CATEGORY = 'category';

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Command for create rss feed')
            ->addArgument(
                self::ARGUMENT_URL,
                InputArgument::REQUIRED,
                'Feed url'
            )
            ->addArgument(
                self::ARGUMENT_TITLE,
                InputArgument::REQUIRED,
                'Feed title'
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
            $feedModel = new FeedModel();
            $feedModel
                ->setUrl($input->getArgument(self::ARGUMENT_URL))
                ->setTitle($input->getArgument(self::ARGUMENT_TITLE))
                ->setCategory($input->getArgument(self::ARGUMENT_CATEGORY));

            $validation = $this->getContainer()
                ->get('validator')
                ->validate($feedModel);

            if (count($validation) > 0) {
                throw new ValidatorException($validation);
            }

            $this->getContainer()->get('feed.service')->createFeed(
                $feedModel->getUrl(),
                $feedModel->getTitle(),
                $feedModel->getCategory()
            );

            $output->writeln('Feed create success');
            return 0;
        } catch(\Exception $e) {
            $output->writeln('Feed create failed');
            $output->writeln($e->getMessage());
            return 1;
        }
    }
}