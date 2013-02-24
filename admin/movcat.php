<?php

//**************************************
//* Movie-Addon v2.0 by FIRSTBORN e.V. *
//**************************************

if(!isfileadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die("access denied");

$_language->read_module('movies');

if($_GET["action"]=="add") {
	
	echo '<h2>'.$_language->module['add_video'].' '.$_language->module['category'].'</h2>
		  <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movcat\');return document.MM_returnValue" value="'.$_language->module['exist_cats'].'"><br /><br />
		  <form method="post" action="admincenter.php?site=movcat" enctype="multipart/form-data">
		  <table cellpadding="4" cellspacing="0">
			<tr>
				<td>'.$_language->module['category'].' '.$_language->module['name'].':</td>
				<td><input type="text" name="movcatname" size="60" maxlength="255" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="save" value="'.$_language->module['add_category'].'"></td>
			</tr>
		  </table>
		  </form>';
}
elseif($_GET["action"]=="edit") {

	$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."movie_categories WHERE movcatID='".$_GET["movcatID"]."'"));
	
	echo '<h2>'.$_language->module['edit'].' '.$_language->module['category'].'</h2>
		  <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movcat\');return document.MM_returnValue" value="'.$_language->module['exist_cats'].'"><br /><br />
		  <form method="post" action="admincenter.php?site=movcat" enctype="multipart/form-data">
		  <table cellpadding="4" cellspacing="0">
			<tr>
				<td>'.$_language->module['category'].' '.$_language->module['name'].':</td>
				<td><input type="text" name="movcatname" size="60" maxlength="255" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" value="'.$ds[movcatname].'"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="movcatID" value="'.$ds[movcatID].'"></td>
				<td><input type="submit" name="saveedit" value="'.$_language->module['edit'].' '.$_language->module['category'].'"></td>
			</tr>
		  </table>
		  </form>';

}
elseif($_POST["saveedit"]) {
	
	$movcatname=$_POST["movcatname"];
	
	if(safe_query("UPDATE ".PREFIX."movie_categories SET movcatname='".$movcatname."'WHERE movcatID='".$_POST["movcatID"]."'")) {
			redirect("admincenter.php?site=movcat", "Category edited.", "3");
	}
	else echo'<b>'.$_language->module['edit_cat_erorr'].'!</b><br><br><a href="javascript:history.back()">&laquo; '.$_language->module['back'].'</a>';
	
	
	
}
elseif($_POST["save"]) {
	
	$movcatname=$_POST["movcatname"];

	safe_query("INSERT INTO ".PREFIX."movie_categories (movcatID, movcatname) values('', '".$movcatname."')");
	redirect("admincenter.php?site=movcat", "".$_language->module['cat_created'].".", "3");

}
elseif($_GET["delete"]) {
	if(safe_query("DELETE FROM ".PREFIX."movie_categories WHERE movcatID='".$_GET["movcatID"]."'")) {
		redirect("admincenter.php?site=movcat", "".$_language->module['cat_deleted'].".", "3");
	} else {
		redirect("admincenter.php?site=movcat", "".$_language->module['cat_deleted_error']."", "3");
	}
}
else {
	echo '<h2>'.$_language->module['movie'].' '.$_language->module['categories'].'</h2>
			<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movcat&action=add\');return document.MM_returnValue" value="'.$_language->module['new'].' '.$_language->module['category'].'"><br /><br />
			<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#999999">
				<tr bgcolor="#CCCCCC">
					<td class="title">movcatID:</td>
					<td class="title">'.$_language->module['category'].' '.$_language->module['name'].':</td>
					<td class="title">'.$_language->module['actions'].':</td>
				</tr>
				<tr bgcolor="#EEEEEE">
					<td colspan="5"></td>
				</tr>';
				
	
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."movie_categories ORDER BY movcatname");
	while($ds = mysql_fetch_array($ergebnis)) {
		
		echo '<tr bgcolor="#FFFFFF">
			  		<td>'.$ds[movcatID].'</td>
					<td>'.$ds[movcatname].'</td>
					<td><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=movcat&action=edit&movcatID='.$ds[movcatID].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'">
				   <input type="button" class="button" onClick="MM_confirm(\'really delete this category?\', \'admincenter.php?site=movcat&delete=true&movcatID='.$ds[movcatID].'\')" value="'.$_language->module['del'].'"></td>
			  </tr>';
	}
	
	echo '</tr></table>';
	
	
}

?>