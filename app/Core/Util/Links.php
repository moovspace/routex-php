<?php
namespace App\Core\Util;

use DOMDocument;

class Links
{
	static function Linkify(string $value, int $img = 1, int $video = 1, array $protocols = array('http', 'mail', 'twitter', 'https'), array $attributes = array('target' => '_blank'), $video_height = 400)
	{
		$links = array();
		$value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);
		foreach ((array)$protocols as $protocol) {
			switch ($protocol) {
				case 'http':
				case 'https':
					$value = preg_replace_callback('~(?:\(?(https?)://([^\s\!]+)(?<![?,:.\"]))~i',
					function ($match) use ($protocol, &$links, $attr, $img, $video, $video_height) {
						if ($match[1]){

							$protocol = $match[1];
							$str = $match[0];
							if($str[0] === '(') { $match[2] = substr($match[2],0,-1); }
							$link = $match[2] ?: $match[3];
							if($video) {
								if(strpos($link, 'youtube.com') !== false || strpos($link, 'youtu.be') !== false){
									$exp = explode('=', $link);
									$ht = '<iframe width="100%" height="'.$video_height.'" src="https://www.youtube.com/embed/'.end($exp).'?rel=0&showinfo=0&color=orange&iv_load_policy=3" frameborder="0" allowfullscreen></iframe>';
									return '<' . array_push($links, $ht) . '></a>';
								}
								if(strpos($link, 'vimeo.com') !== false){
									$exp = explode('/', $link);
									$ht = '<iframe width="100%" height="'.$video_height.'" src="https://player.vimeo.com/video/'.end($exp).'" frameborder="0" allowfullscreen></iframe>';
									return '<' . array_push($links, $ht) . '></a>';
								}
							}
							if($img) {
								if(strpos($link, '.png') !== false || strpos($link, '.jpg') !== false || strpos($link, '.jpeg') !== false || strpos($link, '.gif') !== false || strpos($link, '.bmp') !== false || strpos($link, '.webp') !== false){
									return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" class=\"htmllink\"><img src=\"$protocol://$link\" class=\"htmlimg\">") . '></a>';
								}
							}

							if($str[0] === '(') {
								return '<' . array_push($links, "(<a $attr href=\"$protocol://$link\" class=\"htmllink\">$link</a>)") . '>';
							} else {
								return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" class=\"htmllink\">$link</a>") . '>';
							}
						}
				}, $value); break;
				case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\" class=\"htmllink\">{$match[1]}</a>") . '>'; }, $value); break;
				case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#]([\w\._]+)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\" class=\"htmllink\">{$match[0]}</a>") . '>'; }, $value); break;
				default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\" class=\"htmllink\">{$match[1]}</a>") . '>'; }, $value); break;
			}
		}
		return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
	}

	static function UrlToLink($str, $blank = true, $www = true){
		if($www) {
			if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches)){
				$pop = ($blank == TRUE) ? " target=\"_blank\" " : "";
				for ($i = 0; $i < count($matches['0']); $i++){
					$period = '';
					if (preg_match("|\.$|", $matches['6'][$i])){
						$period = '.';
						$matches['6'][$i] = substr($matches['6'][$i], 0, -1);
					}
					$str = str_replace($matches['0'][$i],
					$matches['1'][$i].'<a href="http'.
					$matches['4'][$i].'://'.
					$matches['5'][$i].
					$matches['6'][$i].'"'.$pop.'>http'.
					$matches['4'][$i].'://'.
					$matches['5'][$i].
					$matches['6'][$i].'</a>'.
					$period, $str);
				}
			}
		} else {
			$str = preg_replace('/(http[s]{0,1}\:\/\/\S{4,})\s{0,}/ims', '<a href="$1" target="_blank">$1</a> ', $str);
		}
		return $str;
	}

	static function Data() {
		return '
		<a href="https://boom.doom"> Html LINK </a>
		Youtube https://www.youtube.com/watch?v=tpKCqp9CALQ
		Vimeo https://vimeo.com/331653781
		Image https://www.google.pl/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png
		Url http://google.com:
		Input: Quotes "http://example.com"
		Exlamation: http://example.com!
		Exlamation: http://example.com?
		Exlamation: http://example.com:
		Exlamation: http://example.com.
		Exlamation: http://example.com,
		Brackets (http://example.com)
		Brackets https://en.wikipedia.org/wiki/Chaquicocha_(mountain)
		Twitter @twitter
		Email boom@super.mail
		<h2> html text </h2>
		<style>.htmllink {font-weight: 900; }</style>
		';
	}
}