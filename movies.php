<?php

//**************************************
//* Movie-Addon v2.0 by FIRSTBORN e.V. *
//**************************************

$movies_per_row=3;

// Do not edit below this line! ***************************************************************************************

$_language->read_module('movies');

$filepath = "../images/movies/";

echo'<span style="color: #fb6801; font-weight: bold; padding-left: 10px;">MEDIA DATABASE</span>
<div style="background-image: url(\'/img/squads/squads_hr.png\'); background-repeat: no-repeat; width: 673px; height: 1px; padding-top: 46px;"></div>';

if($_GET['action']=="category") {


    $movcatID = $_GET['movcatID'];
	$page = $_GET['page'];
	$sort = $_GET['sort'];
	$type = $_GET['type'];
	
	echo ' » <a href="index.php?site=movies"><b>'.$_language->module['movies'].'</b></a> » '.getmovcat($movcatID).'';
	
	$gesamt = mysql_num_rows(safe_query("SELECT movID FROM ".PREFIX."movies WHERE movcatID='".$movcatID."' AND activated='2'"));
	$pages=1;
	if(!isset($page)) $page = 1;
	if(!isset($sort)) $sort = "date";
	if(!isset($type)) $type = "DESC";
	
	$max=10;
		
    for($n=$max; $n<=$gesamt; $n+=$max) {
		if($gesamt>$n) $pages++;
	}
		 	
	if($pages>1) $page_link = makepagelink("index.php?site=movies&action=category&movcatID=$movcatID&sort=$sort&type=$type", $page, $pages);
		
	if ($page == "1") {
        $ergebnis = safe_query("SELECT * FROM ".PREFIX."movies WHERE movcatID='".$movcatID."' AND activated='2' ORDER BY $sort $type LIMIT 0,$max");
	    if($type=="DESC") $n=$gesamt;
		else $n=1;
	}
	else {
	    $start=$page*$max-$max;
	    $ergebnis = safe_query("SELECT * FROM ".PREFIX."movies WHERE movcatID='".$movcatID."' AND activated='2' ORDER BY $sort $type LIMIT $start,$max");
	    if($type=="DESC") $n = ($gesamt)-$page*$max+$max;
		else $n = ($gesamt+1)-$page*$max+$max;
	}
	if($gesamt) {
	if($type=="ASC") $seiten='<a href="index.php?site=movies&action=category&movcatID='.$movcatID.'&page='.$page.'&sort='.$sort.'&type=DESC">'.$_language->module['sort'].':</a> <img src="images/icons/asc.gif" width="9" height="7" border="0"> '.$page_link.'<br><br>';
	else $seiten='<a href="index.php?site=movies&action=category&movcatID='.$movcatID.'&page='.$page.'&sort='.$sort.'&type=ASC">'.$_language->module['sort'].':</a> <img src="images/icons/desc.gif" width="9" height="7" border="0"> '.$page_link.'<br><br>';
						
	
    echo '<table width="100%" border="0" cellspacing="0" cellpadding="2"><tr><td>'.$seiten.'</td></tr></table>';
	
	
	eval ("\$movies_head = \"".gettemplate("movies_head")."\";");
	echo $movies_head;
				
	$i=1;
	while($ar=mysql_fetch_array($ergebnis)) {
				if($i%2) {
				$bg1=BG_1;
				$bg2=BG_2;
			}
			else {
				$bg1=BG_3;
				$bg2=BG_4;
			}
			
			if($i%$movies_per_row) echo '</tr><tr>';
			
			$com=getanzcomments($ar[movID],"mo");
			$hits=$ar[hits];
			$movheadline=$ar[movheadline];
			$movID=$ar[movID];
			$uploader=getnickname($ar[uploader]);
			
			if($ar[rating])	$ratingpic='<img src="images/rating'.$ar[rating].'.png" width="103" height="31" title="'.$ar[rating].' of 10; '.$ar[votes].' votes" />';
			else $ratingpic='<img src="images/rating0.png" width="103" height="31" title="no votes yet" />';
			
			$pic='<img src="../images/movies/'.$ar[movscreenshot].'" width="200" height="115" alt="'.$movheadline.'">';
			
			
	eval ("\$movies_content = \"".gettemplate("movies_content")."\";");
	echo $movies_content;
$i++;
}
eval ("\$movies_foot = \"".gettemplate("movies_foot")."\";");
	echo $movies_foot;
	}
	else{
	echo'no entries!';
	}
	
} elseif($_GET['action'] == "show") {
	$id=$_GET['id'];
	
	$movcat=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."movies WHERE movID=".$id.""));
	$movcatID = $movcat[movcatID];
	$linkpageheadline = $movcat[movheadline];
	
	echo ' » <a href="index.php?site=movies"><b>Movies</b></a> » <a href="index.php?site=movies&action=category&movcatID='.$movcatID.'"><b>'.getmovcat($movcatID).'</b></a> » '.$movcat[movheadline].'<br><br>';

	if(isset($id)){
		$res=safe_query("SELECT * FROM ".PREFIX."movies WHERE movID=$id");
		if(mysql_num_rows($res)){
			$ar=mysql_fetch_array($res);
				safe_query("UPDATE ".PREFIX."movies SET hits=hits+1 WHERE movID=$id");
				$bg1=BG_1;
				$bg2=BG_2;
				$bg3=BG_3;

				$movcatID=$ar[movcatID];
				$movcat=getmovcat($ar[movcatID]);
				$uploader=getnickname($ar[uploader]);
				
		$hpselect=mysql_fetch_array(safe_query("SELECT hpurl FROM ".PREFIX."settings"));
		
		if(eregi('http://', $hpselect[hpurl])) $page_link="".$hpselect[hpurl]."/index.php?site=movies&action=show&id=".$id."";
		else $video_page_link='http://'.$hpselect[hpurl].'/index.php?site=movies&action=show&id='.$id.'';
				

		if($ar[movdescription]) $des=$ar[movdescription];
		else $des='No Description';
		
		if(isfileadmin($userID)) {
	    	$adminaction.=' <input type="button" class="button" onClick="MM_confirm(\''.$_language->module['realywanttodelete'].'?\', \'index.php?site=myvideos&delete=true&movID='.$ds[movID].'\')" value="delete">';
		}
		else $adminaction.='';
		
		if($ar[rating])	$ratingpic='<img src="images/rating'.$ar[rating].'.png" width="103" height="31" title="'.$ar[rating].' of 10; '.$ar[votes].' '.$_language->module['votes'].'" />';
		else $ratingpic='<img src="images/rating0.png" width="103" height="31" title="'.$_language->module['no_votes'].'" />';
		
		if($loggedin) {
			$getmovies=safe_query("SELECT movies FROM ".PREFIX."user WHERE userID='$userID'");
			$found=false;
			if(mysql_num_rows($getmovies)) {
				$ga=mysql_fetch_array($getmovies);
				if($ga[movies]!="") {
	    			$string=$ga[movies];
					$array=explode(":", $string);
    				$anzarray=count($array);
	    				for($i=0; $i<$anzarray; $i++) {
        				if($array[$i]==$id) $found=true;
    				}
				}
			}
			if($found) $rateform="<b>".$_language->module['allready_voted']."</b>";	
			else $rateform='<form method="post" action="rating.php">
							  <select name="rating">
								  <option value="0">0 - '.$_language->module['poor'].'</option>
								  <option value="1">1</option>
								  <option value="2">2</option>
								  <option value="3">3</option>
								  <option value="4">4</option>
								  <option value="5">5</option>
								  <option value="6">6</option>
								  <option value="7">7</option>
								  <option value="8">8</option>
								  <option value="9">9</option>
								  <option value="10">10 - '.$_language->module['perfect'].'</option>
								</select>
								<input type="hidden" name="userID" value="'.$userID.'">
								<input type="hidden" name="type" value="mov">
								<input type="hidden" name="id" value="'.$ar[movID].'">
       							<input type="submit" name="Submit" value="rate"> 
							</form>
 							';
		}
		else $rateform="<b>".$_language->module['unlogged_vote']."</b>";
		

		if($ar[embed]){
			eval ("\$detailsembed = \"".gettemplate("movies_details_embed")."\";");
			echo $detailsembed;
		}
		else{
			eval ("\$details = \"".gettemplate("movies_details")."\";");
			echo $details;
		}
			$parentID = $id;
			$type = "mo";
			$referer = "index.php?site=movies&action=show&id=$id";
			$comments_allowed = 2;
			include("comments.php");
		
	}
	else echo'No Movie with ID '.$id.' aviable.';
}
}
else {

	$latestmovqry= safe_query("SELECT * FROM ".PREFIX."movies WHERE activated='2' ORDER BY date DESC LIMIT 0,1");
	
		$lastmov='<table width="100%" cellspacing="1" cellpadding="5" bgcolor="'.BORDER.'" border="0" align="right">
					<tr> 
						<td class="title">&nbsp; &#8226; '.$_language->module['latest_movie'].'</td>
					</tr>';
						
		while($mov=mysql_fetch_array($latestmovqry)) {
			$movname=$mov[movheadline];
			if($mov[movscreenshot]) $lastpic=$mov[movscreenshot];
			else $lastpic='nopic.png';
			
			$lastmov.= '<tr>
					<td bgcolor="'.BG_1.'" align="center"><a href="index.php?site=movies&action=show&id='.$mov[movID].'"><b>'.$movname.'</b></a></td>
				  </tr>
				  <tr>
				  	<td bgcolor="'.BG_2.'" align="center"><a href="index.php?site=movies&action=show&id='.$mov[movID].'"><img src="images/movies/'.$lastpic.'" width="200" height="115" border="0"></a></td>
				  </tr>';
		
		}
		$lastmov.= '</table>';
	

	$top5qry=safe_query("SELECT * FROM ".PREFIX."movies WHERE activated='2' ORDER BY hits DESC LIMIT 0,5");
		$top5='
			<table width="100%" cellspacing="1" cellpadding="5" bgcolor="'.BORDER.'" border="0" align="right">
				<tr> 
					<td colspan="2" class="title">&nbsp; &#8226; TOP 5 '.$_language->module['movies'].'</td>
					<td class="title" align="center">'.$_language->module['hits'].'</td>
				</tr>';
		$n=1;
		while($movie=mysql_fetch_array($top5qry)) {
			$n%2 ? $bg=BG_1 : $bg=BG_2;
			
			$movname=$movie['movheadline'];
			if(strlen($movename) > 12) {
				$movname =substr($movname, 0, 12);
				$movname.='...';
			}
			$moviename='<a href="index.php?site=movies&action=show&id='.$movie[movID].'"><b>'.$movname.'</b></a>';
			if($movie['hits'] != '0') {
				$top5.='
					<tr>
						<td bgcolor="'.$bg.'" width="20" align="center"><b>'.$n.'.</b></td>
						<td bgcolor="'.$bg.'">'.$moviename.'</td>
						<td bgcolor="'.$bg.'" width="70" align="center">'.$movie[hits].'</td>
					</tr>';
			}
			$n++;
		}
		$top5.='</table>';
	
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."movie_categories ORDER BY movcatname");
	
	$border=BORDER;

	$i=1;
		
	while($ds=mysql_fetch_array($ergebnis)) {
	
		if($i%2) {
			$bg1=BG_1;
			$bg2=BG_3;
		}
		else {
			$bg1=BG_2;
			$bg2=BG_3;
		}
	
		$movcatID=$ds[movcatID];
		$movcatheadline=$ds[movcatname];
		$videocount = mysql_num_rows(safe_query("SELECT movID FROM ".PREFIX."movies WHERE movcatID='".$movcatID."'"));
		
		// Get category names and their videos only when the video count is greater than zero
		if($videocount > 0) {				
			$getallmovies = safe_query("SELECT embed FROM ".PREFIX."movies WHERE movcatID = ".$movcatID."");
			$getcatpicture = mysql_fetch_array(safe_query("SELECT movcatpicture FROM ".PREFIX."movie_categories WHERE movcatID = ".$movcatID.""));
			$x=1;
			echo '<img onclick="toggle_visibility(\'foo\');" src="../images/movies/'.$getcatpicture[0].'" /><br />';
	?>
			<div id="foo" style="float: left; display: none;">			
	<?php
			
			echo '<br />'.$movcatheadline.' ('.$videocount.' Videos) <br />';			
			
			while($row = mysql_fetch_array($getallmovies)){	
				if($x<4) {
					echo '<div style="float: left; padding-right: 10px;">';
					echo $row[0];
					$x++;
				}
				else
				{
					echo '<div style="padding-top: 10px;">';
					echo $row[0];
					echo '</div>';
					$x=0;
				}
			}			
	?>
			</div>
			</div>
	<?php	
		}
	}
}

?>