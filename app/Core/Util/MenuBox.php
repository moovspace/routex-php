<?php
namespace App\Core\Util;

/**
 * Sub menu part
 */
class MenuBox
{
	// Top url
	public $Title = [];
	// Submenu
	public $All = [];
	// Open urls
	public $Urls = [];
	// Main url
	public $TitleUrl;

	function __construct($name, $url, $icon = '<i class="fas fa-radiation-alt"></i>', $chevron = '<i class="fas fa-chevron-down"></i>', $open_urls = [])
	{
		// Open for urls
		foreach($open_urls as $u)
		{
			$this->Urls[] = $u;
		}
		$this->Urls[] = $url;
		$this->CurrUrl = $this->CurrUrl();

		$this->Title['name'] = $name;
		$this->Title['url'] = $url;
		$this->Title['icon'] = $icon;
		$this->Title['chevron'] = $chevron;
	}

	function AddLink($name, $url, $icon = '<i class="fas fa-dot-circle"></i>')
	{
		$this->Urls[] = $url;

		$c = '';
		if($url == $this->CurrUrl)
		{
			$c = 'mlink-active';
		}
		$this->All[] = '<a href="'.$url.'" class="mlink '.$c.'"> <span>'.$icon.'</span> '.$name.' <span class="show-chevron"><i class="fas fa-chevron-right"></i></span> </a>';
	}

	/**
	 * Html - Get menu html
	 *
	 * @return string Menu html content
	 */
	function Html()
	{
		$sub = '';
		$open = '';
		$open_title = '';
		if(in_array($this->CurrUrl, $this->Urls))
		{
			$open = 'submenu-open';
			$open_title = 'title-open';
		}

		foreach($this->All as $k => $v)
		{
			$sub .= $v;
		}

		$chevron = '';

		if(!empty($this->Title['chevron']))
		{
			$chevron = $this->Title['chevron'];
		}

		$Title = '<a href="'.$this->Title['url'].'" class="mlink '.$open_title.'"> <span>'.$this->Title['icon'].'</span> '.$this->Title['name'].' <span class="chevron">'.$chevron.'</span> </a>';

		return '<div class="menu-box">'
				.$Title.
				'<div class="submenu '.$open.'">'
					.$sub.
				'</div>
				</div>';
	}

	function CurrUrl()
	{
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}

	static function Style()
	{
		return '
		<link href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" rel="stylesheet">
		<style>
		.menu{
			float: left;
			width: 300px;
			background: #fff;
			margin: 20px;
			padding: 10px;
			border-radius: 10px;
			box-shadow: 0px 1px 3px #96b0c238
		}
		.menu-box{
			float: left; width: 100%; overflow: hidden;
		}
		.menu-box *{
			color: var(--color-steel);
			font-size: 15px;
		}
		.menu-box .submenu{
			display: none;
		}
		.menu-box .submenu-open{
			float: left; width: 100%; overflow: hidden;
			display: inherit;
		}
		.menu-box .mlink{
			float: left; width: 100%; text-decoration: none;
			padding: 10px;
			margin-bottom: 3px;
			transition: all .6s;
		}
		.menu-box .mlink span i{
			padding: 0px 10px 0px 0px;
		}
		.menu-box .mlink .show-chevron{
			display: none
		}
		.menu-box .mlink:hover{
			color: var(--color-orange);
			border-radius: var(--input-border-radius);
		}
		.menu-box .mlink:hover i{
			color: var(--color-orange);
		}
		.menu-box .submenu-open{
			padding-left: 20px;
		}
		.menu-box .submenu-open .mlink{
			color: #a5b2be;
		}
		.menu-box .submenu-open .mlink i{
			color: #a5b2be;
		}
		.menu-box .mlink-active{
			color: var(--color-steel);
			background: var(--color-steel-light);
			border-radius: var(--input-border-radius);
			font-weight: 600;
		}
		.menu-box .submenu-open .mlink-active{
			color: var(--color-steel)
		}
		.menu-box .submenu-open .mlink-active i{
			color: var(--color-steel)
		}
		.menu-box .mlink-active .show-chevron{
			display: inherit
		}
		.menu-box .submenu-open .mlink:hover{
			color: var(--color-orange)
		}
		.menu-box .submenu-open .mlink:hover i{
			color: var(--color-orange)
		}
		.menu-box .title-open, .menu-box .title-open *{
			color: var(--color-steel);
			font-weight: 600;
		}
		.menu-box .chevron{
			float: right
		}
		.menu-box .show-chevron{
			float: right
		}
		</style>';
	}
}
/*
// How to
$m = new MenuBox('Panel', '/login', '<i class="fas fa-user"></i>');
$m->AddLink('Login', '/login');
$m->AddLink('Register', '/register');
// Get menu html
echo $m->Html();
// Get menu style
echo MenuBox::Style();
*/
