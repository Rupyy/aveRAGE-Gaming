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

$ergebnis=safe_query("SELECT * FROM ".PREFIX."clanwars ORDER BY date DESC LIMIT 0, ".$maxresults);
if(mysql_num_rows($ergebnis)){
	//echo'<table width="100%" cellspacing="0" cellpadding="2">';
	$n=1;
	while($ds=mysql_fetch_array($ergebnis)) {

		$date=date("d.m.Y", $ds['date']);
		$time=date("H:i Uhr", $ds['date']);
		$homescr=array_sum(unserialize($ds['homescore']));
		$oppscr=array_sum(unserialize($ds['oppscore']));

		if($n%2) {
			$bg1=BG_1;
			$bg2=BG_2;
		}
		else {
			$bg1=BG_3;
			$bg2=BG_4;
		}

		if($homescr>$oppscr) $result='<font color="#319e14;">'.$homescr.'</font> - <font color="#ae2323">'.$oppscr.'</font>';
		elseif($homescr<$oppscr) $result='<font color="#ae2323">'.$homescr.'</font> - <font color="#319e14">'.$oppscr.'</font>';
		else $result='<font color="'.$drawcolor.'">'.$homescr.' - '.$oppscr.'</font>';

		$resultID=$ds['cwID'];
		$gameicon="images/games/";
		if(file_exists($gameicon.$ds['game'].".png")) $gameicon = $gameicon.$ds['game'].".png";

		eval ("\$results = \"".gettemplate("results")."\";");
		echo $results;
		$n++;
	}
}
?>
