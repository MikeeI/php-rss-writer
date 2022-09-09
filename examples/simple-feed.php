<?php

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

// Load test target classes
spl_autoload_register(function ($c) {
    @include_once strtr($c, '\\_', '//') . '.php';
});
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . '/src');

$feed = new Feed();
header('Content-type: application/rss+xml');

$date_now = new DateTime('now', new DateTimeZone('UTC'));
//$date_now_rfc822 = $date_now->format(DateTime::RFC822);
$date_now_int = $date_now->getTimestamp();

$channel = new Channel();
$channel
    ->title('Channel of Odd Jobsman - RSS Feed')
    ->description('Odd Jobsman Feedly Feed Fad Fud Feed Description')
    ->url('https://feed.oddjobsman.me/php/php-rss-writer/examples/')
    ->feedUrl('https://feed.oddjobsman.me/php/php-rss-writer/examples/simple-feed.php')
    ->language('en-US')
    ->copyright('Copyright 2022, Odd Jobsman')
    ->pubDate($date_now_int)
    ->lastBuildDate($date_now_int)
    ->ttl(60)
    ->webfeeds_cover('https://feed.oddjobsman.me/php/php-rss-writer/examples/assets/img_600x100.png')
    ->webfeeds_icon('https://feed.oddjobsman.me/php/php-rss-writer/examples/assets/img_128x128.png')
    ->webfeeds_logo('https://feed.oddjobsman.me/php/php-rss-writer/examples/assets/img_96x96.png')
    ->webfeeds_accentColor('#ff0000')
    ->webfeeds_related('card')
    ->webfeeds_analytics('UA-XXXXX-Y')
    ->pubsubhubbub('https://feed.oddjobsman.me/php/php-rss-writer/examples/simple-feed.php', 'http://pubsubhubbub.appspot.com')
    ->appendTo($feed);

// Blog item
$item = new Item();
$item
->title('Blog Entry Of Odd Jobsman Number 1')
->description('<div>Blog body 1</div>')
->contentEncoded('<div>Blog body 1</div>')
->url('https://feed.oddjobsman.me/php/php-rss-writer/examples/article1')
->author('author@oddjobsman.me (Odd Jobsman)')
->pubDate($date_now_int)
->guid('https://feed.oddjobsman.me/php/php-rss-writer/examples/article1', true)
->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
->appendTo($channel);

$item = new Item();
$item
->title('Blog Entry Of Odd Jobsman Number 2')
->description('<div>Blog body 2</div>')
->contentEncoded('<div>Blog body 2 </div>')
->url('https://feed.oddjobsman.me/php/php-rss-writer/examples/article2')
->author('author@oddjobsman.me (Odd Jobsman)')
->pubDate($date_now_int)
->guid('https://feed.oddjobsman.me/php/php-rss-writer/examples/article2', true)
->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
->appendTo($channel);


/*
// Podcast item
$item = new Item();
$item
    ->title('Some Podcast Entry')
    ->description('<div>Podcast body</div>')
    ->url('http://podcast.example.com/2012/08/21/podcast-entry/')
    ->enclosure('http://podcast.example.com/2012/08/21/podcast.mp3', 4889, 'audio/mpeg')
    ->appendTo($channel);
*/
echo $feed; // or echo $feed->render();
