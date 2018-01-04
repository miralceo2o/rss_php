<?php

$i = 0; // counter
$url = "http://m.tvb.com/news/latest/world/0"; // url to parse
$rss = simplexml_load_file($url); // XML parser
$keywords = array("全球最巨型飛機加州進行測");//Set up filter

function has_keywords($haystack, $wordlist)
{
  $found = false;
  foreach ($wordlist as $w)
  {
    if (stripos($haystack, $w) !== false) {
      $found = true;
      break;
    }
  }
  return $found;
}

$data = '<rss xmlns:bing="http://bing.com/schema/media/" xmlns:media="http://search.yahoo.com/mrss/" xmlns:dcterms="http://purl.org/dc/terms/" version="2.0">';

$data .= '<channel>';
$data .= '<title><![CDATA[ '.$rss->channel->title.' ]]></title>';
$data .= '<link><![CDATA[ '.$rss->channel->link.' ]]></link>';
$data .= '<description><![CDATA[ '.$rss->channel->description.' ]]></description>';
$data .= '<copyright><![CDATA[ '.$rss->channel->copyright.' ]]></copyright>';
$data .= '<pubDate><![CDATA[ '.$rss->channel->pubDate.' ]]></pubDate>';

$data .= '<lastBuildDate><![CDATA[ '.$rss->channel->lastBuildDate.' ]]></lastBuildDate>';
$data .= '<language><![CDATA[ '.$rss->channel->language.' ]]></language>';
$data .= '<generator><![CDATA[ '.$rss->channel->generator.' ]]></generator>';

//$data .= '<atom:link href="'.BASE_URL.'/rss/" rel="self" type="application/rss+xml"/>';

$i =2;
foreach($rss->channel as $channel) {

}

$i = 0;
foreach($rss->channel->item as $item) {



   if($i<20){// parse only 20 items
if (has_keywords($item->title, $keywords)) { 
    $data .= '<removed_item>';
    $data .= '<title>'. $item->title.' ***REMOVED***'.'</title>';
    //$data .= '<item_id>'.' '. $channel->item[$i]['id'].'</item_id>';
    $data .= '</removed_item>';
    //print $item->title.'</a><br />';
} else {
     //$data .= '<item id="592bc0366db28c2c6f888574" app_exclusive="false" top_news="true" create_datetime="Mon, 29 May 2017 14:31:18 +0800" expired_datetime="Fri, 28 Jul 2017 14:31:00 +0800" publish_datetime="Mon, 29 May 2017 14:31:00 +0800">';
    //$data .= '<item>';
     $data .= '<item id="' .  $channel->item[$i]['id'] . '" app_exclusive=  "'. $channel->item[$i]['app_exclusive']
   //   '" top_news= "'. $channel->item[$i]['top_news']
      .'" create_datetime= "'. $channel->item[$i]['create_datetime'].'" expired_datetime= "'. $channel->item[$i]['expired_datetime'].'" publish_datetime= "'. $channel->item[$i]['publish_datetime'].'">
     ';
     //$data .= print_r($item) ;
    // $data .= '<item_id>'.' '. $channel->item[$i]['id'].'</item_id>';
    // $data .= '<app_exclusive>'.' '. $channel->item[$i]['app_exclusive'].'</app_exclusive>';
     //$data .= '<top_news>'.' '. $channel->item[$i]['top_news'].'</top_news>';
     //$data .= '<create_datetime>'.' '. $channel->item[$i]['create_datetime'].'</create_datetime>';
     //$data .= '<expired_datetime>'.' '. $channel->item[$i]['expired_datetime'].'</expired_datetime>';
     //$data .= '<publish_datetime>'.' '. $channel->item[$i]['publish_datetime'].'</publish_datetime>';

    // $data .= '<item>';
    $data .= '<title><![CDATA[ '. $item->title.' ]]></title>';
    if($item->topnews_datetime==''){
    }else
    {
        $data .= '<topnews_datetime><![CDATA[ '.$item->topnews_datetime.' ]]></topnews_datetime>';
    }

    if($item->description==''){
    }else
    {
        $data .= '<description><![CDATA[ '.$item->description.' ]]></description>';
    }
 //  $data .= '<topnews_datetime><![CDATA[ '.$item->topnews_datetime.'NOT removed'.' ]]></topnews_datetime>';
    
        if($item->category==''){
    }else
    {
    $data .= '<category><![CDATA[ '.$item->category.' ]]></category>';
    }


            if($item->tags==''){
    }else
    {
    $data .= '<tags><![CDATA[ '.$item->tags.' ]]></tags>';
    }

//$data .= '<video>'. $item->video->attributes()['url'].'</video>';

   // $data .= '<video>'. $item->video->attributes()->url->__toString().'</video>';
  //  $data .= '<title>'.$i.' ' ."<img src=\"". 'NOT removed'.''."\">".'</title>';
//$data .= '<video='$test'>'.'</video>';
   //$data .= print_r($item);

$j = 0;
foreach($item->video as $video) {
$data .= '
<video url="' . $item->video[$j]['url'] .'" bitrate="'  . $item->video[$j]['bitrate']. '" language="' . $item->video[$j]['language']. '" />
<video_android url="' . $item->video_android[$j]['url'] .'" bitrate="'  . $item->video_android[$j]['bitrate']. '" language="' . $item->video_android[$j]['language']. '" />
<video_web url="' . $item->video_web[$j]['url'] .'" bitrate="'  . $item->video_web[$j]['bitrate']. '" language="' . $item->video_web[$j]['language']. '" />
<video_smoothStream url="' . $item->video_smoothStream[$j]['url'] .'" bitrate="'  . $item->video_smoothStream[$j]['bitrate']. '" language="' . $item->video_smoothStream[$j]['language']. '" />
';
$j++;
}

$k = 0;
foreach($item->image as $image) {
$data .= '
<image url="' . $item->image[$k]['url'] .'" link="'  . $item->image[$k]['link']. '" type="' . $item->image[$k]['type']. '" default="' . $item->image[$k]['default'].'" />
';
$k++;
}

            if($item->pubDate==''){
    }else
    {
    $data .= '<pubDate><![CDATA[ '.$item->pubDate.' ]]></pubDate>';
    }

//$data .="<test>".sizeof($item->video)."</test>";

//$data .="<test>".sizeof($item->image)."</test>";
    $data .= '</item>';


 

}
$i++;
}
}


//getNamespaces
//$data .="<test>".sizeof($video)."</test>";
//sizeof($video);


$data .= '</channel>';
$data .= '</rss>';

header('Content-Type: application/xml');
echo $data;
?>


