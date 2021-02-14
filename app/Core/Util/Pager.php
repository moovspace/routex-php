<?php
namespace App\Core\Util;

use Exception;
use App\Core\Mysql\Db;

class Pager
{
	public $MinPerpage = 1;

	/**
	 * Minimum perpage value
	 *
	 * @param integer $perpage Records per page
	 * @return void
	 */
	function Perpage(int $perpage = 8)
	{
		$this->MinPerpage = $perpage;
	}

	/**
	 * Get links
	 *
	 * $page Current page
	 * $records Records in table
	 * $perpage Rows per page
	 * $subpage Show sub links 2 3 4 5/66 6 7 8
	 * $subpage_nr Number of sub links
	 * $attributes Array with $_GET['attribute'] in links ?perpage=1&page=4&search=hohoho
	 * $next Next page button html
	 * $back Back page button html
	 */
	final function Links(int $page = 1, int $records = 11, int $perpage = 1, bool $subpage = true, int $subpage_nr = 3, array $attributes = ['page', 'perpage','search','edit','delete','id'], $next = '<i class="fas fa-chevron-right"></i>', $back = '<i class="fas fa-chevron-left"></i>') : string
	{
		if($page < 1) { $page = 1; }
		if($perpage < $this->MinPerpage) { $perpage = $this->MinPerpage; }
		// Count max page number
		$this->MaxPage($records, $perpage);
		// Attr
		$this->Attributes = $attributes;
		// Links
		$link = '<div class="pager">';
		$link .= $this->BackLink($page, $back);
		if($subpage) { $link .= $this->PageLinkLeft($page, $subpage_nr); }
		if($page <= $this->MaxPage) { $link .= $this->CurrPageLink($page, $this->MaxPage); }
		if($subpage) { $link .= $this->PageLinkRight($page, $subpage_nr); }
		$link .= $this->NextLink($page, $next);
		$link .= '</div>';

		return $link;
	}

	/**
	 * Undocumented function
	 *
	 * @param integer $records
	 * @param integer $perpage
	 * @return void
	 */
	protected function MaxPage(int $records, int $perpage)
	{
		if($records > $perpage)
		{
			$this->MaxPage = (int) ($records / $perpage);
			if(($records % $perpage) > 0) { $this->MaxPage = $this->MaxPage + 1; }
		}
		else
		{
			$this->MaxPage = 1;
		}
	}

	protected function NextLink($page = 1, $icon = 'next')
	{
		if($page >= $this->MaxPage) { $page = $this->MaxPage; }
		$next = $page + 1;
		if($page < $this->MaxPage)
		{
			return '<a href="'.$this->Attributes().'page='.$next.'" class="nav-link next-link"> '.$icon.' </a>';
		}
		else
		{
			return '';
		}
	}

	protected function BackLink($page = 1, $icon = 'back')
	{
		if($page < 1) { $page = 1; }
		$back = $page - 1;
		if($page > 1)
		{
			return '<a href="'.$this->Attributes().'page='.$back.'" class="nav-link back-link"> '.$icon.' </a>';
		}
		else
		{
			return '';
		}
	}

	protected function CurrPageLink($page = 1, $max_page = 1)
	{
		return '<a href="'.$this->Attributes().'page='.$page.'" class="nav-link curr-link"> '.$page.' / '.$max_page.'</a>';
	}

	protected function PageLinkLeft($page = 0, $nr)
	{
		$l = '';
		for ($i = $nr; $i > 0; $i--)
		{
			$p = $page - $i;
			if($p >= 1)
			{
				$l .= '<a href="'.$this->Attributes().'page='.$p.'" class="nav-link left-link"> '.$p.' </a>';
			}
		}
		return $l;
	}

	protected function PageLinkRight($page = 0, $nr)
	{
		$l = '';
		for ($i = 1; $i < $nr + 1; $i++)
		{
			$p = $page + $i;
			if($p <= $this->MaxPage)
			{
				$l .= '<a href="'.$this->Attributes().'page='.$p.'" class="nav-link right-link"> '.$p.' </a>';
			}
		}
		return $l;
	}

	protected function Attributes()
	{
		$url = '?';
		foreach($this->Attributes as $k)
		{
			if(!empty($_GET[$k]) && $k != 'page')
			{
				$url .= $k.'='.$_GET[$k].'&';
			}
		}
		return $url;
	}

	static function Offset(int $page, int $perpage): int
	{
		$o = ($page - 1) * $perpage;
		if($o < 0) { $o = 0; }
		return $o;
	}

	static function Style()
	{
		return '
		<style>
			.pager{
				display: block;
				float: left;
				width: 100%;
				overflow: hidden;
				text-align: center;
				padding: 10px;
			}
			.nav-link{
				font-weight: 900;
				font-size: 14px;
				line-height: 25px;
				padding: 10px;
				background: #fff;
				border: 1px solid #63d600;
				color: #63d600;
				margin: 5px;
				border-radius: 5px;
				transition: all .6s;
			}
			.nav-link:hover{
				background: #52b100;
				color: #fff;
			}
			.next-link, .back-link, .curr-link
			{
				background: #fff;
				border: 1px solid #f60;
				color: #f60;
			}
			.next-link:hover, .back-link:hover, .curr-link:hover
			{
				background: #ff6600aa;
				color: #fff;
			}
		</style>
		';
	}

	/**
	 * Count max rows sample function
	 *
	 * @return int
	 */
	function GetMaxRows()
	{
		$arr = [];
		$sql = "SELECT COUNT(*) as cnt FROM orders ORDER BY id DESC";
		return Db::Query($sql,$arr)->FetchAll()[0]['cnt'];
	}

	/**
	 * Get page records sample function
	 *
	 * @return array
	 */
	function GetRows()
	{
		$page = 1;
		$offset = 0;
		$perpage = 8;

		if(!empty($_GET['page'])) { $page = (int)$_GET['page']; }
		if(!empty($_GET['perpage'])) { $perpage = (int)$_GET['perpage']; }
		if($perpage < $this->MinPerpage) { $perpage = $this->MinPerpage; }

		$arr = [
			':offset' => self::Offset($page,$perpage),
			':perpage' => $perpage
		];
		$sql = "SELECT * FROM orders ORDER BY id DESC LIMIT :offset,:perpage";
		return Db::Query($sql,$arr)->FetchAllObj();
	}
}
