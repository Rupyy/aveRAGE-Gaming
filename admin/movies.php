<?php

//**************************************
//* Movie-Addon v2.0 by FIRSTBORN e.V. *
//**************************************

if(!isfileadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die("access denied");

$_language->read_module('movies');
$filepath = "../images/movies/";

if($_GET["action"]=="add") {

	$movcatselect=safe_query("SELECT * FROM ".PREFIX."movie_categories ORDER BY movcatname");
 		while($ds=mysql_fetch_array($movcatselect)) {
		 $movcat.='<option value="'.$ds[movcatID].'">'.$ds[movcatname].'</option>';
		}

	echo '<h2>'.$_language->module['movies'].'</h2>
		<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movies\');return document.MM_returnValue" value="'.$_language->module['exist_movs'].'"> <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movcat\');return document.MM_returnValue" value="'.$_language->module['categories'].'">
		<h2>'.$_language->module['new_vid'].'</h2>';
	echo'
		<form method="post" action="admincenter.php?site=movies" enctype="multipart/form-data">
		<table cellpadding="4" cellspacing="0">
			<tr>
				<td>'.$_language->module['catselect'].':</td>
				<td><select name="movcatID">'.$movcat.'</select></td>
			</tr>
			<tr>
				<td>'.$_language->module['headline'].':</td>
				<td><input type="text" name="movheadline" size="60" maxlength="255" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
			</tr>
			<tr>
				<td>'.$_language->module['screen'].':</td>
				<td><input name="movscreenshot" type="file"></td>
			</tr>
			<tr>
				<td>'.$_language->module['description'].':</td>
				<td><input type="text" name="movdescription" size="60" maxlength="255" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
			</tr>
			<tr>
				<td>'.$_language->module['path_url'].': ('.$_language->module['o_no_embed'].')</td>
				<td><input type="text" name="movfile" size="60" maxlength="255" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
			</tr>
			<tr>
				<td>'.$_language->module['embed'].':</td>
				<td><textarea type="text" name="embed" rows="3" cols="60" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></textarea></td>
			</tr>
			<tr>
				<td><input type="hidden" name="uploader" value="'.$userID.'"></td>
				<td><input type="submit" name="save" value="'.$_language->module['add_video'].'"></td>
			</tr>
		</table>
		</form>';
}
elseif($_GET["action"]=="edit") {
	$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."movies WHERE movID='".$_GET["movID"]."'"));
	if(file_exists($filepath.$ds['movID'].'.gif'))	$pic='<img src="../images/movies/'.$ds['movID'].'.gif" width="200" height="115" border="0" alt="'.$ds['movheadline'].'">';
	elseif(file_exists($filepath.$ds['movID'].'.jpg'))	$pic='<img src="../images/movies/'.$ds['movID'].'.jpg" width="200" height="115" border="0" alt="'.$ds['movheadline'].'">';
	elseif(file_exists($filepath.$ds['movID'].'.png'))	$pic='<img src="../images/movies/'.$ds['movID'].'.png" width="200" height="115" border="0" alt="'.$ds['movheadline'].'">';
	else $pic='no image uploaded';
	
	$movcatselect=safe_query("SELECT * FROM ".PREFIX."movie_categories ORDER BY movcatname");
 		while($dv=mysql_fetch_array($movcatselect)) {
		 $movcat.='<option value="'.$dv[movcatID].'">'.$dv[movcatname].'</option>';
		}
	
	$movcat=str_replace('value="'.$ds[movcatID].'"', 'value="'.$ds[movcatID].'" selected', $movcat);
	
	
	echo'
		<h2>'.$_language->module['movies'].'</h2>
		<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movies\');return document.MM_returnValue" value="'.$_language->module['exist_movs'].'">
		<h2>'.$_language->module['edit'].' '.$_language->module['movie'].'</h2>';
	echo'
		<form method="post" action="admincenter.php?site=movies" enctype="multipart/form-data">
		<input type="hidden" name="movID" value="'.$ds['movID'].'">
		<table cellpadding="4" cellspacing="0">
			<tr>
				<td>'.$_language->module['catselect'].':</td>
				<td><select name="movcatID">'.$movcat.'</select></td>
			</tr>
		    <tr>
				<td>'.$_language->module['headline'].':</td>
				<td><input type="text" name="movheadline" size="60" maxlength="255" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" value="'.$ds['movheadline'].'"></td>
			</tr>
			<tr>
				<td>'.$_language->module['pscreen'].':</td>
				<td>'.$pic.'</td>
			</tr>		
			<tr>
				<td>'.$_language->module['img_up'].':</td>
				<td><input name="movscreenshot" type="file"></td>
			</tr>
			<tr>
				<td>'.$_language->module['description'].':</td>
				<td><input type="text" name="movdescription" size="60" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" value="'.$ds['movdescription'].'"></td>
			</tr>
			<tr>
				<td>'.$_language->module['path_url'].':</td>
				<td><input type="text" name="movfile" size="60" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" value="'.$ds['movfile'].'"></td>
			</tr>
			<tr>
				<td>'.$_language->module['embed'].':</td>
				<td><textarea type="text" name="embed" rows="3" cols="60" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'">'.$ds['embed'].'</textarea></td>
			</tr>
			<tr>
				<td><input type="hidden" name="uploader" value="'.$ds['uploader'].'"></td>
				<td><input type="submit" name="saveedit" value="edit movie"></td>
			</tr>
		</table>
		</form>';
}
elseif($_POST["save"]) {
	$movscreenshot=$_FILES["movscreenshot"];
	$movheadline=$_POST["movheadline"];
	$movfile=$_POST["movfile"];
	$movdescription=$_POST["movdescription"];
	$movcatID=$_POST["movcatID"];
	$uploader=$_POST["uploader"];
	$embed=$_POST["embed"];
	
	echo'
		<h2>'.$_language->module['movies'].'</h2>
		<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movies&action=add\');return document.MM_returnValue" value="'.$_language->module['new_vid'].'">
		<h2>'.$_language->module['new_vid'].'</h2>';
	
	if($movheadline AND ($movfile OR $embed)) {
		if(eregi('http://', $movfile)) $movfile=$movfile;
		else $movfile='http://'.$movfile;
		
		safe_query("INSERT INTO ".PREFIX."movies (movID, activated, embed, uploader, movheadline, movfile, movdescription, date, movcatID) values('', '2', '".$embed."', '".$uploader."', '".$movheadline."', '".$movfile."', '".$movdescription."', '".time()."', '".$movcatID."')");
		$id=mysql_insert_id();
		
		if($movscreenshot[name]!=""){
		$file_ext=strtolower(substr($movscreenshot[name], strrpos($movscreenshot[name], ".")));
		if($file_ext==".gif" OR $file_ext==".jpg" OR $file_ext==".png") {
			if($movscreenshot[name] != "") {
				move_uploaded_file($movscreenshot[tmp_name], $filepath.$movscreenshot[name]);
				@chmod($filepath.$movscreenshot[name], 0755);
				$file=$id.$file_ext;
				rename($filepath.$movscreenshot[name], $filepath.$file);
				if(safe_query("UPDATE ".PREFIX."movies SET movscreenshot='".$file."' WHERE movID='".$id."'")) {
					redirect("admincenter.php?site=movies", "".$_language->module['screen_created'].".", "3");
				} else {
					redirect("admincenter.php?site=movies", "".$_language->module['screen_error']."!", "3");
				}
			}
		} else echo'<b>'.$_language->module['screen_error1'].'.</b><br><br><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
		}
		redirect("admincenter.php?site=movies", "".$_language->module['mov_added']."!", "3");
	} else echo'<b>'.$_language->module['formerror'].'.</b><br><br><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
}
elseif($_POST["saveedit"]) {
	$movscreenshot=$_FILES["movscreenshot"];
	$movheadline=$_POST["movheadline"];
	$movfile=$_POST["movfile"];
	$movdescription=$_POST["movdescription"];
	$movcatID=$_POST["movcatID"];
	$uploader=$_POST["uploader"];
	$embed=$_POST["embed"];

	echo'<h2>'.$_language->module['movie'].'</h2>
	<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movies\');return document.MM_returnValue" value="'.$_language->module['exist_movs'].'">
	<h2>'.$_language->module['edit'].' '.$_language->module['movie'].'</h2>';	
	
	if($movscreenshot AND $movheadline AND $movfile) {
		if(eregi('http://', $movfile)) $movfile=$movfile;
		else $movfile='http://'.$movfile;
		
		if($movscreenshot[name]=="") {
			if(safe_query("UPDATE ".PREFIX."movies SET embed='".$embed."', uploader='".$uploader."', movheadline='".$movheadline."', movfile='".$movfile."', movdescription='".$movdescription."', movcatID='".$movcatID."' WHERE movID='".$_POST["movID"]."'"))
				redirect("admincenter.php?site=movies", "".$_language->module['mov_updated'].".", "3");
		} else {
			$file_ext=strtolower(substr($movscreenshot[name], strrpos($movscreenshot[name], ".")));
			if($file_ext==".gif" OR $file_ext==".jpg" OR $file_ext==".png") {
				move_uploaded_file($movscreenshot[tmp_name], $filepath.$movscreenshot[name]);
				@chmod($filepath.$movscreenshot[name], 0755);
				$file=$_POST['movID'].$file_ext;
				rename($filepath.$movscreenshot[name], $filepath.$file);

				if(safe_query("UPDATE ".PREFIX."movies SET embed='".$embed."', uploader='".$uploader."', movscreenshot='".$file."', movheadline='".$movheadline."', movfile='".$movfile."', movdescription='".$movdescription."' WHERE movID='".$_POST["movID"]."'")) {
					header("Location: admincenter.php?site=movies");
				}
			} else echo'<b>'.$_language->module['screen_error1'].'.</b><br><br><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
		}
	} else echo'<b>'.$_language->module['formerror'].'.</b><br><br><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
}
elseif($_GET["delete"]) {
	if(safe_query("DELETE FROM ".PREFIX."movies WHERE movID='".$_GET["movID"]."'")) {
		if(file_exists($filepath.$_GET["movID"].'.jpg')) unlink($filepath.$_GET["movID"].'.jpg');
		if(file_exists($filepath.$_GET["movID"].'.gif')) unlink($filepath.$_GET["movID"].'.gif');
		if(file_exists($filepath.$_GET["movID"].'.png')) unlink($filepath.$_GET["movID"].'.png');
		redirect("admincenter.php?site=movies", "".$_language->module['mov_del'].".", "3");
	} else {
		redirect("admincenter.php?site=movies", "".$_language->module['no_mov_del']."!", "3");
	}
}
else {
	
	echo'<h2>movies</h2>
		<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movies&action=add\');return document.MM_returnValue" value="'.$_language->module['new_vid'].'">';
	$qry1=safe_query("SELECT * FROM ".PREFIX."movies WHERE activated='1' ORDER BY movheadline");
	$anz1=mysql_num_rows($qry1);
	if($anz1){
	echo ' <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movactivation\');return document.MM_returnValue" value="'.$anz1.' '.$_language->module['unact_vids'].'">';
	}
	echo ' <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movcat\');return document.MM_returnValue" value="'.$_language->module['categories'].'">
		<h2>'.$_language->module['exist_movs'].'</h2>
		<form method="post" action="admincenter.php?site=features">
		<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#999999">
			<tr bgcolor="#CCCCCC">
				<td class="title">'.$_language->module['headline'].':</td>
				<td class="title">'.$_language->module['category'].':</td>
				<td class="title">'.$_language->module['uploader'].':</td>
				<td class="title">'.$_language->module['screen'].':</td>
				<td class="title">'.$_language->module['description'].':</td>
				<td class="title">'.$_language->module['actions'].':</td>
			</tr>
			<tr bgcolor="#EEEEEE">
				<td colspan="6"></td>
			</tr>';
	$qry=safe_query("SELECT * FROM ".PREFIX."movies WHERE activated='2' ORDER BY movheadline");
	$anz=mysql_num_rows($qry);
	if($anz) {
		while($ds = mysql_fetch_array($qry)) {
		
		if(file_exists($filepath.$ds[movID].'.jpg'))	$pic='<img src="../images/movies/'.$ds[movID].'.jpg" width="200" height="115" border="0" alt="'.$ds['movheadline'].'">';
	elseif(file_exists($filepath.$ds[movID].'.gif'))	$pic='<img src="../images/movies/'.$ds[movID].'.gif" width="200" height="115" border="0" alt="'.$ds['movheadline'].'">';
	elseif(file_exists($filepath.$ds[movID].'.png'))	$pic='<img src="../images/movies/'.$ds[movID].'.png" width="200" height="115" border="0" alt="'.$ds['movheadline'].'">';
	else $pic='no image uploaded';
			

			echo'
				<tr bgcolor="#FFFFFF">
					<td>'.$ds[movheadline].'</td>
					<td>'.getmovcat($ds[movcatID]).'</td>
					<td>'.getnickname($ds[uploader]).'</td>
					<td>'.$pic.'</td>
					<td>'.$ds[movdescription].'</td>
					<td>
				   <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movies&action=edit&movID='.$ds[movID].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'">
				   <input type="button" class="button" onClick="MM_confirm(\'really delete this country?\', \'admincenter.php?site=movies&delete=true&movID='.$ds[movID].'\')" value="'.$_language->module['del'].'"></td>
					</td>
				</tr>
			';
		}
	} else echo'<tr><td colspan="4">'.$_language->module['no_entries'].'</td></tr>';
	echo '</table>';
}

?>