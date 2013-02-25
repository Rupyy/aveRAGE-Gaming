<!DOCTYPE html>

<?php
/*
##########################################################################
#                                                                        #
#           Version 4       /                        /   /               #
#          -----------__---/__---__------__----__---/---/-               #
#           | /| /  /___) /   ) (_ `   /   ) /___) /   /                 #
#          _|/_|/__(___ _(___/_(__)___/___/_(___ _/___/___               #
#                       Free Content / Management System                 #
#                                   /                                    #
#                                                                        #
#                                                                        #
#   Copyright 2005-2011 by webspell.org                                  #
#                                                                        #
#   visit webSPELL.org, webspell.info to get webSPELL for free           #
#   - Script runs under the GNU GENERAL PUBLIC LICENSE                   #
#   - It's NOT allowed to remove this copyright-tag                      #
#   -- http://www.fsf.org/licensing/licenses/gpl.html                    #
#                                                                        #
#   Code based on WebSPELL Clanpackage (Michael Gruber - webspell.at),   #
#   Far Development by Development Team - webspell.org                   #
#                                                                        #
#   visit webspell.org                                                   #
#                                                                        #
##########################################################################
*/
include("_mysql.php");
include("_settings.php");
include("_functions.php");

$_language->read_module('index');
$index_language = $_language->module;
?>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title><?php echo PAGETITLE; ?></title>
        <link rel="stylesheet" type="text/css" href="css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/slider.css" />
		<link href="tmp/rss.xml" rel="alternate" type="application/rss+xml" title="<?php echo getinput($myclanname); ?> - RSS Feed" />
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        <script src="js/bbcode.js" type="text/javascript"></script>
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://html5form.googlecode.com/svn/trunk/jquery.html5form-1.5-min.js"></script>    
		<script>
			$(document).ready(function(){
				$('#myform').html5form();    
			});
		</script>
    </head>
    
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		
	<!-- Advertising Banner left and right
	<div class="advert_left"><a href="http://4pl.4players.de/index.php/de/News:bericht/2376/Gewinnspiel_Ein_guter_Tag_zum_Sterben.html"><img src="img/bruce_left.png" /></a></div>
	<div class="advert_right"><a href="http://4pl.4players.de/index.php/de/News:bericht/2376/Gewinnspiel_Ein_guter_Tag_zum_Sterben.html"><img src="img/bruce_right.png" /></a></div>
	Advertising Banner left and right -->
		
        <header>
			<nav>
				<div class="navi">
					<a href="index.php?site=news" class="nav_home"></a>
					<a href="index.php?site=squads" class="nav_teams"></a>
					<a href="index.php?site=clanwars" class="nav_matches"></a>
					<a href="index.php?site=forum" class="nav_board"></a>
					<a href="index.php?site=movies" class="nav_media"></a>
					<a href="index.php?site=server" class="nav_server"></a>
					<a href="index.php?site=files" class="nav_downloads"></a>
					<a href="index.php?site=imprint" class="nav_imprint"></a>
					<a href="index.php?site=contact" class="nav_contact"></a>	
				</div>
			</nav>
            <div class="ticker">
				<div class="ticker_box">
					<div class="ticker_box_content">
						<?php include("sc_switchbox.php"); ?>
					</div>
				</div>
			</div>
            <div class="member_box">
				<div class="member_box_banner">
					<div class="container">
						<div id="slider">
						<div id="mask">
							<ul>
								<li>
									<a href="#" title="View my first image link"><img src="img/member_box/banner_test.png" alt="Member Banner Dummy" /></a>
								</li>
								<li>
									<a href="#" title="View my second image link"><img src="img/member_box/banner_test.png" alt="Member Banner Dummy" /></a>
								</li>
								<li>
									<a href="#" title="View my first image link"><img src="img/member_box/banner_test.png" alt="Member Banner Dummy" /></a>
								</li>
								<li>			
									<a href="#" title="View my third image link"><img src="img/member_box/banner_test.png" alt="Member Banner Dummy" /></a>
								</li>
							</ul>
						</div>
						<div id="progress"></div>				
						</div>
					</div>
				</div>
			</div>			
        </header>        
        <div class="content_header">&nbsp;</div> 
		<section class="content">
			<?php
				switch ($site) {
				case "forum":
			?>
				<article class="forum_index">
					<?php
					if(!isset($site)) $site="news";
					$invalide = array('\\','/','/\/',':','.');
					$site = str_replace($invalide,' ',$site);
					if(!file_exists($site.".php")) $site = "news";
					include($site.".php");
					?>
				</article>
			<?php ;
					break;
				case "profile":
			?>
				<article class="profile">
					<?php
					if(!isset($site)) $site="news";
					$invalide = array('\\','/','/\/',':','.');
					$site = str_replace($invalide,' ',$site);
					if(!file_exists($site.".php")) $site = "news";
					include($site.".php");
					?>
				</article>
				<aside class="side_content">
					<div class="login_area"><?php include("login.php"); ?></div>
					<span><?php include("sc_sponsors.php"); ?></span>
				</aside>
			<?php ;
					break;
				case "forum_topic":
			?>
				<article class="forum_index">
					<?php
					if(!isset($site)) $site="news";
					$invalide = array('\\','/','/\/',':','.');
					$site = str_replace($invalide,' ',$site);
					if(!file_exists($site.".php")) $site = "news";
					include($site.".php");
					?>
				</article>
			<?php ;
					break;
				default:
			?>
				<article class="news">
					<?php
					if(!isset($site)) $site="news";
					$invalide = array('\\','/','/\/',':','.');
					$site = str_replace($invalide,' ',$site);
					if(!file_exists($site.".php")) $site = "news";
					include($site.".php");
					?>
				</article>			
				<aside class="side_content">
					<div class="login_area"><?php include("login.php"); ?></div>
					<span><?php include("sc_sponsors.php"); ?></span>
				</aside>
			<?php
			}
			?>
			<aside class="video_area">
				<div class="video1"><iframe width="296" height="167" src="http://www.youtube.com/embed/GpbBZ8uCMbQ?rel=0" style="border: 0;"></iframe></div>
				<div class="video2"><iframe width="296" height="167" src="http://www.youtube.com/embed/GpbBZ8uCMbQ?rel=0" style="border: 0;"></iframe></div>
				<div class="video3"><iframe width="296" height="167" src="http://www.youtube.com/embed/GpbBZ8uCMbQ?rel=0" style="border: 0;"></iframe></div>
			</aside>
			<footer class="content_footer">
				<div class="footer_imprint">
					<p style="color: #ca5a0c;"><b>http:// average-gaming.de · gaming community since 2012<br />
					Copyright ©2001 - 2013,  average-gaming.de</b></p>
					<p style="color: #5b5a5a;"><b>Alle Rechte vorbehalten<br />
					Powered by webSPELL (<a href="http://www.webspell.org">www.webspell.org</a>)</b></p>					
				</div>
			</footer>			
		</section>
    </body>
</html>