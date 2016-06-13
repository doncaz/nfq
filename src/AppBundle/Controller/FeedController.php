<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FeedController
 * @package AppBundle\Controller
 * @Route("/feed")
 */
class FeedController extends Controller
{
    /**
     * @Route("/list/{category}", name="feed_list")
     * @Template()
     */
    public function listAction($category)
    {
        $feedList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Feeds')
            ->getList([
                'category' => $category
            ]);

        /**
         * @SPL array shorter
         */
        return [
            'feedList'  => $feedList
        ];
    }

    /**
     * @Route("/recent-article-list/{feedId}", name="feed_recent_article_list")
     * @Template()
     */
    public function recentArticlesAction($feedId)
    {
        $recentArticleList = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Items')
            ->getRecentFeedItems($feedId);

        /**
         * @SPL array shorter
         */
        return [
            'recentArticleList' => $recentArticleList
        ];
    }
}
