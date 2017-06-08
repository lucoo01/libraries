<?php 
class RSSItem
{
	var $title;
	var $link;
	var $description;
	var $pubDate;
	var $guid;
	var $tags;
	var $attachment;
	var $length;
	var $mimetype;

	function RSSItem()
	{ 
		$this->tags = array();
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
		$out .= "<item>\n";
		$out .= "<title>" . $this->title . "</title>\n";
		$out .= "<link>" . $this->link . "</link>\n";
		$out .= "<description>" . $this->description . "</description>\n";
		$out .= "<pubDate>" . $this->getPubDate() . "</pubDate>\n";

		if($this->attachment != "")
			$out .= "<enclosure url='{$this->attachment}' length='{$this->length}' type='{$this->mimetype}' />";

		if(empty($this->guid)) $this->guid = $this->link;
		$out .= "<guid>" . $this->guid . "</guid>\n";

		foreach($this->tags as $key => $val) $out .= "<$key>$val</$key\n>";
		$out .= "</item>\n";
		return $out;
	}

	function enclosure($url, $mimetype, $length)
	{
		$this->attachment = $url;
		$this->mimetype   = $mimetype;
		$this->length     = $length;
	}
}