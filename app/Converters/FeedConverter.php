<?php

namespace App\Converters;

use Carbon\Carbon;

class FeedConverter
{

    private $url;

    public function __construct(String $url)
    {
        $this->url = $url;
    }

    public function getPdfFromFeed()
    {
        $xml = $this->getFeedXML();

        return $xml;
    }

    public function getFeedXML()
    {
        $feedXML = simplexml_load_file($this->url);

        $mpdf = new \Mpdf\Mpdf();

        foreach($feedXML->channel->item as $feedItem){

            $pubDate = Carbon::createFromTimeString($feedItem->pubDate);

            $mpdf->addPage();

            $html = "<div class=\"rss-item-container\">";
            $html .= "<h1>".$feedItem->title."</h1>";

            if(isset($feedItem->source)){
                $html .= "<h4>Source: ".$feedItem->source."</h4>";
            }

            if(isset($feedItem->pubDate)){
                $html .= "<h6>Published on: ".$pubDate->toFormattedDateString()."</h6>";
            }

            $html .= "<a href=\"".$feedItem->link."\" >View Article</a>";
            $html .= "</div>";

            $mpdf->writeHTML($html);
        }

        return $mpdf;
    }
}
