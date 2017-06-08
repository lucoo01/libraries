<?php 
/* 实例 -----------------------------------------------
	$feed = new RSS();
	$feed->title       = "RSS Feed 标题";
	$feed->link        = "http://w3cschool.cn";
	$feed->description = "RSS 订阅列表描述。";

	$db->query($query);  // 数据库查询
	$result = $db->result;
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$item = new RSSItem();
		$item->title = $title;
		$item->link  = $link;
		$item->setPubDate($create_date); 
		$item->description = "<![CDATA[ $html ]]>";
		$feed->addItem($item);
	}
	echo $feed->serve();
---------------------------------------------------------------- */

class RSS
{
	var $title;
	var $link;
	var $description;
	var $language = "en-us";
	var $pubDate;
	var $items;
	var $tags;

	function RSS()
	{
		$this->items = array();
		$this->tags  = array();
	}

	function addItem($item)
	{
		$this->items[] = $item;
	}

	function setPubDate($when)
	{
		if(strtotime($when) == false)
			$this->pubDate = date("D, d M Y H:i:s ", $when) . "GMT";
		else
			$this->pubDate = date("D, d M Y H:i:s ", strtotime($when)) . "GMT";
	}

	function getPubDate()
	{
			if(empty($this->pubDate))
			return date("D, d M Y H:i:s ") . "GMT";
		else
			return $this->pubDate;
	}

	function addTag($tag, $value)
	{
		$this->tags[$tag] = $value;
	}

	function out()
	{
		$out  = $this->header();
		$out .= "<channel>\n";
		$out .= "<title>" . $this->title . "</title>\n";
		$out .= "<link>" . $this->link . "</link>\n";
		$out .= "<description>" . $this->description . "</description>\n";
		$out .= "<language>" . $this->language . "</language>\n";
		$out .= "<pubDate>" . $this->getPubDate() . "</pubDate>\n";

		foreach($this->tags as $key => $val) $out .= "<$key>$val</$key>\n";
		foreach($this->items as $item) $out .= $item->out();

		$out .= "</channel>\n";

		$out .= $this->footer();

		$out = str_replace("&", "&amp;", $out);

		return $out;
	}

	function serve($contentType = "application/xml")
	{
		$xml = $this->out();
		header("Content-type: $contentType");
		echo $xml;
	}

	function header()
	{
		$out  = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
		$out .= '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">' . "\n";
		return $out;
	}

	function footer()
	{
		return '</rss>';
	}
}