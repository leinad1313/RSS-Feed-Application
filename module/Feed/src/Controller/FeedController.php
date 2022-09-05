<?php

declare(strict_types=1);

namespace Feed\Controller;

use Feed\Model\Feed;
use Feed\Model\Item;
use Laminas\Mvc\Controller\AbstractActionController;

class FeedController extends AbstractActionController
{

    /**
     * Use JSON object to create feed and item objects
     *
     * @param  object $rssData
     * @return Feed
     */
    public function createFeedByRSSData(object $rssData): Feed
    {
        $items = [];
        if ($rssData->items) {
            foreach ($rssData->items as $item) {
                $items[] = new Item($item->title, $item->description, $item->pubDate, $item->categories, $item->link, $item->guid, $item->thumbnail, $item->author);
            }
        }
        return new Feed($rssData->feed->title, $rssData->feed->description, $items, $rssData->feed->url, $rssData->feed->link, $rssData->feed->image, $rssData->feed->author);
    }
}
