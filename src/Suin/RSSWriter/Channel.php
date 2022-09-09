<?php

namespace Suin\RSSWriter;

/**
 * Class Channel
 * @package Suin\RSSWriter
 */
class Channel implements ChannelInterface
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $url;

    /** @var string */
    protected $feedUrl;

    /** @var string */
    protected $description;

    /** @var string */
    protected $language;

    /** @var string */
    protected $copyright;

    /** @var int */
    protected $pubDate;

    /** @var int */
    protected $lastBuildDate;

    /** @var int */
    protected $ttl;
    
    //CUSTOM
    
    /** @var string */
    protected $webfeeds_accentColor;
    protected $webfeeds_related;
    protected $webfeeds_icon;
    protected $webfeeds_logo;
    protected $webfeeds_cover;
    protected $webfeeds_analytics;
    
    //CUSTOM

    /** @var string[] */
    protected $pubsubhubbub;

    /** @var ItemInterface[] */
    protected $items = [];

    /**
     * Set channel title
     * @param string $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set channel URL
     * @param string $url
     * @return $this
     */
    public function url($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set URL of this feed
     * @param string $url
     * @return $this;
     */
    public function feedUrl($url)
    {
        $this->feedUrl = $url;
        return $this;
    }

    /**
     * Set channel description
     * @param string $description
     * @return $this
     */
    public function description($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set ISO639 language code
     *
     * The language the channel is written in. This allows aggregators to group all
     * Italian language sites, for example, on a single page. A list of allowable
     * values for this element, as provided by Netscape, is here. You may also use
     * values defined by the W3C.
     *
     * @param string $language
     * @return $this
     */
    public function language($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Set channel copyright
     * @param string $copyright
     * @return $this
     */
    public function copyright($copyright)
    {
        $this->copyright = $copyright;
        return $this;
    }

    /**
     * Set channel published date
     * @param int $pubDate Unix timestamp
     * @return $this
     */
    public function pubDate($pubDate)
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    /**
     * Set channel last build date
     * @param int $lastBuildDate Unix timestamp
     * @return $this
     */
    public function lastBuildDate($lastBuildDate)
    {
        $this->lastBuildDate = $lastBuildDate;
        return $this;
    }

    /**
     * Set channel ttl (minutes)
     * @param int $ttl
     * @return $this
     */
    public function ttl($ttl)
    {
        $this->ttl = $ttl;
        return $this;
    }

    //CUSTOM

    public function webfeeds_accentColor($webfeeds_accentColor)
    {
        $this->webfeeds_accentColor = $webfeeds_accentColor;
        return $this;
    }

    public function webfeeds_related($webfeeds_related)
    {
        $this->webfeeds_related = $webfeeds_related;
        return $this;
    }

    public function webfeeds_icon($webfeeds_icon)
    {
        $this->webfeeds_icon = $webfeeds_icon;
        return $this;
    }

    public function webfeeds_logo($webfeeds_logo)
    {
        $this->webfeeds_logo = $webfeeds_logo;
        return $this;
    }

    public function webfeeds_cover($webfeeds_cover)
    {
        $this->webfeeds_cover = $webfeeds_cover;
        return $this;
    }

    public function webfeeds_analytics($webfeeds_analytics)
    {
        $this->webfeeds_analytics = $webfeeds_analytics;
        return $this;
    }

    //CUSTOM

    /**
     * Enable PubSubHubbub discovery
     * @param string $feedUrl
     * @param string $hubUrl
     * @return $this
     */
    public function pubsubhubbub($feedUrl, $hubUrl)
    {
        $this->pubsubhubbub = [
            'feedUrl' => $feedUrl,
            'hubUrl' => $hubUrl,
        ];
        return $this;
    }

    /**
     * Add item object
     * @param ItemInterface $item
     * @return $this
     */
    public function addItem(ItemInterface $item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Append to feed
     * @param FeedInterface $feed
     * @return $this
     */
    public function appendTo(FeedInterface $feed)
    {
        $feed->addChannel($this);
        return $this;
    }

    /**
     * Return XML object
     * @return SimpleXMLElement
     */
    public function asXML()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><channel></channel>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);
        $xml->addChild('title', $this->title);
        $xml->addChild('link', $this->url);
        $xml->addChild('description', $this->description);

        if($this->feedUrl !== null) {
            $link = $xml->addChild('atom:link', '', "http://www.w3.org/2005/Atom");
            $link->addAttribute('href',$this->feedUrl);
            $link->addAttribute('type','application/rss+xml');
            $link->addAttribute('rel','self');
        }

        if ($this->language !== null) {
            $xml->addChild('language', $this->language);
        }

        if ($this->copyright !== null) {
            $xml->addChild('copyright', $this->copyright);
        }

        if ($this->pubDate !== null) {
            $xml->addChild('pubDate', date(DATE_RSS, $this->pubDate));
        }

        if ($this->lastBuildDate !== null) {
            $xml->addChild('lastBuildDate', date(DATE_RSS, $this->lastBuildDate));
        }

        if ($this->ttl !== null) {
            $xml->addChild('ttl', $this->ttl);
        }
        
        
        
        //CUSTOM

        //<webfeeds:analytics id="UA-238360219-1" engine="GoogleAnalytics"/>
        if ($this->webfeeds_analytics !== null) {
            $feedUrl = $xml->addChild('xmlns:webfeeds:analytics');
            $feedUrl->addAttribute('id', $this->webfeeds_analytics);
            $feedUrl->addAttribute('engine', 'GoogleAnalytics');
        }
        
        //<webfeeds:accentColor>249F80</webfeeds:accentColor>
        if ($this->webfeeds_accentColor !== null) {
            $xml->addChild('xmlns:webfeeds:accentColor', $this->webfeeds_accentColor);
        }

        //<webfeeds:cover image="https://www.programmableweb.com/sites/default/files/pw-logo.png"/>
        if ($this->webfeeds_cover !== null) {
            $feedUrl = $xml->addChild('xmlns:webfeeds:cover');
            $feedUrl->addAttribute('image', $this->webfeeds_cover);
        }

        //<webfeeds:icon>https://www.programmableweb.com/sites/all/themes/pw_bootstrap_two/images/logo_onscroll.png</webfeeds:icon>
        if($this->webfeeds_icon !== null) {
            $xml->addChild('xmlns:webfeeds:icon', $this->webfeeds_icon);
        }

        //<webfeeds:logo>https://www.programmableweb.com/sites/default/files/pw-logo.png</webfeeds:logo>
        if($this->webfeeds_logo !== null) {
            $xml->addChild('xmlns:webfeeds:logo', $this->webfeeds_logo);
        }

        //<webfeeds:related layout="card" target="browser"/>
        if($this->webfeeds_related !== null) {
            $feedUrl = $xml->addChild('xmlns:webfeeds:related');
            $feedUrl->addAttribute('layout', $this->webfeeds_related);
            $feedUrl->addAttribute('target', 'browser');
        }


        /*
        protected $webfeeds_accentColor;
        protected $webfeeds_analytics;
        protected $webfeeds_cover;
        protected $webfeeds_icon;      
        protected $webfeeds_logo;
        protected $webfeeds_related;
        
        */





        /*
        $image = new \SimpleXMLElement('<image />');
		if ($this->imageUrl !== null) {
			$image->addChild('url', $this->imageUrl);
		}
		if ($this->imageTitle !== null) {
			$image->addChild('title', $this->imageTitle);
		}
		if ($this->imageLink !== null) {
			$image->addChild('link', $this->imageLink);
		}

        if ($this->webfeeds_cover !== null) {
            
        }
        */
        
        
        //CUSTOM

        if ($this->pubsubhubbub !== null) {
            $feedUrl = $xml->addChild('xmlns:atom:link');
            $feedUrl->addAttribute('rel', 'self');
            $feedUrl->addAttribute('href', $this->pubsubhubbub['feedUrl']);
            $feedUrl->addAttribute('type', 'application/rss+xml');

            $hubUrl = $xml->addChild('xmlns:atom:link');
            $hubUrl->addAttribute('rel', 'hub');
            $hubUrl->addAttribute('href', $this->pubsubhubbub['hubUrl']);
        }

        foreach ($this->items as $item) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($item->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        return $xml;
    }
}
