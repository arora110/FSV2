<!DOCTYPE html>
<html>

  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <meta name="author" content="Akash & Dono">



    <title>Film Stripes</title>
    <!-- palette icon -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- bootstrap Core CSS -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="main.css" rel="stylesheet">
	<link href="sideBar.css" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Playfair+Display+SC" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Fugaz+One" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Karma" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Taviraj:500" rel="stylesheet">

	<!-- jquery -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<style>

		

		body

		{
			background-color: black;
   			padding-top:0px;
   			margin-top: 0px;

		}

		.container-fluid

		{
			padding-top:0px;
   			margin-top: 0px;
			padding: 5px;

		}

		.col-md-4

		{

			padding-bottom: 5px;

			padding-left: 5px;

			padding-right: 5px;

		}

		.col-padding:hover
		{
			-webkit-filter: brightness(50%);
   			-moz-filter: brightness(50%);
  			 filter: brightness(50%);
		}

		.col-padding
		{
			background-color: white;
			<!--margin: 2.5px;-->
			margin-top: 0px;
			margin-bottom: 5px;
			padding-left: 25px;
			padding-right: 25px;	
			-webkit-filter: brightness(100%);
  			-moz-filter: brightness(100%);
   			filter: brightness(100%);
   			transition: all 0.3s ease;
		}

		.title
		{
			font-family: 'Karma', serif;
			font-size: 30px;
		}

		a:link, a:visited 
		{
			text-decoration:none;
			color: black;
		}
		#NoResults
		{
			color: white;
		}
		.info
		{
			position: absolute; 
			text-align: center;
			top: 15.5vh; 
			left: 0; 
			width: 100%; 
			color: white;
			visibility: hidden;
			font-size: 200%;
		}
		@media(max-width: 991px)
		{
			.info
			{
				font-size: 150%;
			}
			@media(max-width: 767px)
			{
				.info
				{
					font-size: 130%;
				}
			}
		}
		.info-holder
		{
			position: relative;
			font-family: 'Playfair Display SC', serif;
		}
		
		.col-padding:hover .info, .col-padding.hover .info
		{ 
			visibility: visible;
		}
		
		@media(max-width: 767px)
		{
			.pageHeader
			{
				font-size: 90%;
			}
		}
	

	<?php

		echo ".sidebar-nav li:first-child a {
			color: #fff;
			background-color: #";
		echo dechex(mt_rand(4337923, 16777215));
		echo "}";
		$i = 2;
		foreach(glob("./libs/AP/*") as $thing)
		{
			for($j = 0;$j < 2;++$j)
			{
				echo ".sidebar-nav li:nth-child($i):before {
						background-color: #";
				echo dechex(mt_rand(4337923, 16777215));   
				echo "}";
				++$i;
			}
		}
	?>

	</style>
	<h1 class="pageHeader" style="color:white; text-align:center; font-family: 'Taviraj', serif; font-size:4vmax;">Film Stripes</h1>
	<?php	

		function createImage($filePath)
		{
			//get an array of hexidecimal values representing the color per sampled frames
			$imageData = file_get_contents($filePath."/results.txt");
			$hexValues = explode('#', $imageData);
			$height = 100/count($hexValues);
			
			$creatorInfo = file_get_contents($filePath.'/names.txt');
			$creatorInfo = explode(PHP_EOL, $creatorInfo);
			
			echo "<div class=\"info-holder\"><div class=\"info\"><span class=\"glyphicon glyphicon-zoom-in\" style=\"font-size:1em;\"></span><h3>Director</h3><h4>$creatorInfo[0]</h4><h3>Cinematographer</h3> <h4>$creatorInfo[1]</h4>
			<h3>Click to inspect</h3><i class=\"material-icons\" style=\"font-size:36px;color:white\">palette</i></div>";
			echo "<ul class=\"list-unstyled image-container\">";
			for($i = 1;$i < count($hexValues);++$i)
			{
				$curID = preg_replace('/\s+/', '', $filePath).(string)($i);
				$curColor = '#' . $hexValues[$i];

				echo "<li id=\"$curID\" style=\"width:100%;height:$height%;background-color:$curColor\">
					</li>";
			}
			echo "</ul>";
			echo "</div>";
		}

		function createTable()
		{
			//$dirHandle = opendir('./libs/');
			$columnCount = 0;
			echo "<div class=\"container-fluid\" style=\"padding:0 !important;\">";

			$year = (empty($_GET["year"])) ? "All" : urldecode($_GET["year"]);
			$schoolYear = (empty($_GET["school_year"])) ? "All" : urldecode($_GET["school_year"]);

			echo "<div class=\"row\">";

			foreach(glob("./libs/$schoolYear/$year/*") as $filePath)//get the name of every directory in libs as file
			{
				$file = substr($filePath, 9+strlen($year)+strlen($schoolYear));
				$filmURL = str_replace('&', '%26', $file);

				echo "<div class=\"col-md-4 col-sm-6\">

						<a href=\"./details.php/?year=$year&school_year=$schoolYear&film=$filmURL\"><!--pass the film's directory name to index.php-->

						<div class=\"col-padding\">";

						

				echo "<br /><br />";

				//create the color spectrum image for the film:
				createImage($filePath);

				//echo $file;
				echo "<p class=\"title\" align=\"center\">$file</p><br />";
				echo "</div>
					</a>
					</div>";
			}
			echo "</div>";
			echo "</div>";
		}

		function getSearchResults()
		{
			$noResult = true;
			echo "<div class=\"container-fluid\">";
			echo "<div class=\"row\">";
			foreach(glob("./libs/*") as $schoolYearDir)
			{
				if(substr($schoolYearDir, 7) == "All")
				{
					continue;
				}
				foreach(glob($schoolYearDir."/*") as $yearDir)
				{
					foreach(glob($yearDir."/*") as $file)
					{
						$film = substr($file, 1+strlen($yearDir));
						$year = substr($yearDir, 1+strlen($schoolYearDir));
						$schoolYear = substr($schoolYearDir,7);

						if(fnmatch("*".preg_replace('/\s+/', '', urldecode($_GET['film']))."*", preg_replace('/\s+/', '', $film), FNM_CASEFOLD))
						{
							$noResult = false;
							$filmURL = str_replace('&', '%26', $film);
							echo "<div class=\"col-md-4 col-sm-6\">

									<a href=\"./details.php/?year=$year&school_year=$schoolYear&film=$filmURL\"><!--pass the film's directory name to index.php-->
									<div class=\"col-padding\">";

							echo "<br /><br />";

							//create the color spectrum image for the film:
							createImage($file);

							//echo $file;
							echo "<p class=\"title\" align=\"center\">$film</p><br />";
							echo "</div>
								</a>
								</div>";
						}
					}

				}
			}
			echo "</div>";
			echo "</div>";
			if($noResult)
			{
				echo "<center><p id=\"NoResults\">No films were found matching your search.</p></center>";
			}
		}
		function createSideBar()
		{
			echo "<li class=\"sidebar-brand sideBarElement0\">
					<a href=\".\" style=\"padding:15px 16px 10px 10px;\">
					   <i class=\"fa fa-home\" aria-hidden=\"true\"></i>
					</a>
				</li>";

			//create search bar
			echo "<form name=\"film\" method=\"get\" action=\"index.php\" id=\"film\">
				<input type=\"text\" placeholder=\"Find film by name...\" name=\"film\" size=19 style=\"margin:1vmin 1vmin 1.5vmin 1vmin;\">
				<a href=\"#\" onclick=\"document.getElementById('film').submit()\">
				  <i class=\"fa fa-search\"></i>
				</a>
			</form>";
				
			foreach(glob("./libs/*") as $schoolYearDirect)
			{
				$schoolYearDirect = substr($schoolYearDirect,7);
				if($schoolYearDirect == "All")
				{
					continue;
				}
				echo "<li class=\"dropdown\">
					  <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">$schoolYearDirect Films<span class=\"caret\"></span></a>
					  <ul class=\"dropdown-menu\" role=\"menu\">
						<li class=\"dropdown-header\">Year:</li>";
				foreach(glob("./libs/".$schoolYearDirect."/*") as $yearDirect)
				{
					$yearDirect = substr($yearDirect, 8 + strlen($schoolYearDirect));
					if($yearDirect == "All")
					{
						continue;
					}
					
						echo "<li><a href=\"?year=$yearDirect&school_year=$schoolYearDirect\">$yearDirect</a></li>";
				}
				echo "</ul>
					</li>";
			}
			
		}
	?>
	
	<script>
        function preventDefault(e) {
          e = e || window.event;
          if (e.preventDefault)
              e.preventDefault();
          e.returnValue = false;  
        }

        function preventDefaultForScrollKeys(e) {
            if (keys[e.keyCode]) {
                preventDefault(e);
                return false;
            }
        }

        function disableScroll() {
          if (window.addEventListener) // older FF
              window.addEventListener('DOMMouseScroll', preventDefault, false);
          window.onwheel = preventDefault; // modern standard
          window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
          window.ontouchmove  = preventDefault; // mobile
          document.onkeydown  = preventDefaultForScrollKeys;
        }

        function enableScroll() {
            if (window.removeEventListener)
                window.removeEventListener('DOMMouseScroll', preventDefault, false);
            window.onmousewheel = document.onmousewheel = null; 
            window.onwheel = null; 
            window.ontouchmove = null;  
            document.onkeydown = null;  
        }
    </script>

    <script>
	function openNav() {
	    document.getElementById("myNav").style.width = "100%";

		setTimeout(function() {
			 document.getElementById("Xoverlay-content").style.opacity = "1"
		}, 200);
	    disableScroll();
	}
	
	function closeNav() {

document.getElementById("Xoverlay-content").style.opacity = "0"
		setTimeout(function() {
			 document.getElementById("myNav").style.width = "0%";
		}, 200);
	    enableScroll();
	}
    </script>
</head>

  

<body>
 	
	<!--About Page Text -->
		<div id="myNav" class="Xoverlay">
		  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		  <div id="Xoverlay-content">
			  <h1 style = "font-family: 'Karma', serif;"><big>Film Stripes - A Digital Art Gallery</big></h1>
                          <p style= "font-family: 'Karma', serif; font-size: 14px;"> Featuring over 200 Chapman films</p>
			  <br>
				  <p align = left style = "padding-left: 13vw; padding-right: 13vw;font-family: 'Karma', serif;"> Film Stripes was created to give filmmakers a unique way to look at and analyze the color palette of their short films. </p>
				  <br \>
			  <p align = left style = "padding-left: 13vw; padding-right: 13vw;font-family: 'Karma', serif;"> How it Works: The stripes are stacked in a chronological order - the film starts at the top of the painting, and ends down at the bottom. Each stripe represents the average color of a single frame. Depending on the film's length, anywhere from 50 to 250 frames are extracted for each painting. </p>
			  <br \>
			  <img src="FinalHumEx.jpg" style='height: 60%; width: 60%; object-fit: contain;' class = "border">
                          <p align = left style = "padding-left: 13vw; padding-right: 13vw;font-family: 'Karma', serif;"> Created by Akash Arora, Donovan Matsui, and William Cortes </p>
                          <p align = center style = "padding-left: 13vw; padding-right: 13vw;font-family: 'Karma', serif;"> Contact Us - arora110@mail.chapman.edu </p>
		  </div>
		</div> 
	
	<!--Titlle & About Button Alignment -->
	<div id="header" style="position:relative;text-align:center;">
	    <div class="outer">
	        <div class="inner">
	            <button class="buttonAbout" style = " z-index:2; top:8px; right:12px;float:right;" onClick = "openNav()">?</button>
	        </div>
	    </div>
	</div>  


  
	<div id="wrapper">
		<div class="overlay"></div>

		<!-- Sidebar -->
		<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
			<ul class="nav sidebar-nav">
				<?php createSideBar(); ?>
			</ul>
		</nav>





		<!-- Page Content -->

		<div id="page-content-wrapper" style="padding-top:5vh;">

			<button type="button" class="hamburger is-closed" data-toggle="offcanvas">
				<span class="hamb-top"></span>
				<span class="hamb-middle"></span>
				<span class="hamb-bottom"></span>
			</button>
			
			<?php 
				if(empty($_GET['film']))
				{
					createTable(); 
				}
				else
				{
					getSearchResults();
				}
			?>
		</div>

	</div>

	<!-- /#wrapper -->

	<script>
		$(document).ready(function () {
		  var trigger = $('.hamburger'),
			  overlay = $('.overlay'),
			isClosed = false;
			trigger.click(function () {
			  hamburger_cross();      
			});
			
			function hamburger_cross() {
			  if (isClosed == true) {          
				overlay.hide();
				trigger.removeClass('is-open');
				trigger.addClass('is-closed');
				isClosed = false;
			  } else {   
				overlay.show();
				trigger.removeClass('is-closed');
				trigger.addClass('is-open');
				isClosed = true;
			  }
		  }

		  $('[data-toggle="offcanvas"]').click(function () {
				$('#wrapper').toggleClass('toggled');
		  });  
		});		

		$('.image-container').css('height', $(window).height()*(7.5/10)  + 'px');

		$( window ).resize(function() {
		  $('.image-container').css('height', $(window).height()*(7.5/10)  + 'px');
		});
	</script>
  </body>
</html>