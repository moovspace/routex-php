<?php
namespace App\Core\Router;

class ErrorPage
{
    static function Error()
    {
		header("HTTP/1.1 404 Not Found");
		?>

		<div id="box">
			<img src="/media/img/error.png" width="200" height="200">
			<h1>Error 404! Page not found!</h1>
			<p> <a href="/" title="Homepage" class="err-link"> Back to homepage </a> </p>
		</div>

		<style>
			@import url('https://fonts.googleapis.com/css?family=Quicksand:300,400,700&display=swap&subset=latin-ext');
			#box{font-family: 'Quicksand', Arial, sans-serif; margin-top: 50px; float: left; width: 100%; overflow: hidden; display: flex; flex-direction: column; align-items: center; color: #111}

			h1{margin: 30px 0px 50px 0px; text-align: center}

			.err-link{
				color: #fff; background: #111;
				padding: 10px 20px;
				border-radius: 10px;
				text-decoration: none;
				font-weight: 700;
				font-size: 17px;
				transition: all .6s;
			}
			.err-link:hover{background: #555}
		</style>

		<?php
	}
}
?>
