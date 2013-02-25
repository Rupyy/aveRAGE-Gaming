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
#   Copyright 2005-2009 by webspell.org                                  #
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
##########################################################################
#                                                                        #
#   Copyright 2009 by Stefan Giesecke                                    #
#                                                                        #
#   - Script runs under the GNU GENERAL PUBLIC LICENSE                   #
#   - It's NOT allowed to remove this copyright-tag                      #
#   -- http://www.fsf.org/licensing/licenses/gpl.html                    #
#                                                                        #
##########################################################################
*/
//which of the includes to show, have a look below at the boxes array for the available numbers
$show=array(3,1,2,5);

//config of the default include to show on page load & to define the style of the switchbox navigation
$config=array();
$config['default']=3; //enter one of the numbers of the show array above to be shown as default on page load
$config['buttonstyle']='links'; //available settings: numbers, names, arrows, dropdown

//do not edit anything below here if you are not sure what you are doing there
$boxes=array();
$boxes[0]=array('sc_articles.php', 'articles', 'short_articles');
$boxes[1]=array('sc_files.php', 'files', 'short_files');
$boxes[2]=array('latesttopics.php', 'latesttopics', 'short_latesttopics');
$boxes[3]=array('sc_results.php', 'results', 'short_results');
$boxes[4]=array('sc_demos.php', 'demo', 'short_demo');
$boxes[5]=array('sc_headlines.php', 'headlines', 'short_headlines');
$boxes[6]=array('sc_upcoming.php', 'upcoming', 'short_upcoming');
$boxes[7]=array('sc_lastregistered.php', 'lastregistered', 'short_lastregistered');
$boxes[8]=array('sc_servers.php', 'servers', 'short_servers');
$boxes[9]=array('sc_squads.php', 'squads', 'short_squads');

if(isset($_GET['action'])){
	$action=$_GET['action'];
}

if($action=='switch'){
	
	include("_mysql.php");
	include("_settings.php");
	include("_functions.php");

	$_switchboxlanguage = new Language;
	$_switchboxlanguage->set_language($_language->language);
	$_switchboxlanguage->read_module('sc_switchbox');
	
	if(isset($_GET['target'])){
		$target=$_GET['target'];
	}
	else{
		$target=$config['default'];
	}
	
	$buttons='<div style="width:100%; text-align: center; padding-bottom: 12px; padding-left: 38px;">';
	
	switch ($config['buttonstyle']) {
    
		case 'numbers':
			$i=1;
			foreach($show AS $key){
			  $buttons.='<input type="button" value="'.$i.'" onclick="fetch(\'sc_switchbox.php?action=switch&target='.$key.'\',\'switchbox\',\'replace\',\'event\');">';
			  $i++;
			}
			echo $buttons.'</div>';  
      break;
    
    case 'names':
      foreach($show AS $key){
			  $buttons.='<input type="button" value="'.$_switchboxlanguage->module[$boxes[$key][2]].'" onclick="fetch(\'sc_switchbox.php?action=switch&target='.$key.'\',\'switchbox\',\'replace\',\'event\');">';
			}
			echo $buttons.'</div>';
      break;
    
    case 'arrows':
		$currentposition=array_search($target, $show);
		$current=$show[$currentposition];
			$showlength=count($show);
			if($currentposition==0){
				$previous=$show[$showlength-1];
			}
			else{
				$previous=$show[$currentposition-1];
			}
			if($currentposition==($showlength-1)){
				$next=$show[0];
			}
			else{
				$next=$show[$currentposition+1];
			}
			$buttons.='<a href="#" onclick="fetch(\'sc_switchbox.php?action=switch&target='.$previous.'\',\'switchbox\',\'replace\',\'event\');">&lt;&lt;</a>';
			$buttons.='&nbsp;&nbsp;&nbsp;'.$_switchboxlanguage->module[$boxes[$current][1]].'&nbsp;&nbsp;&nbsp;';
			$buttons.='<a href="#" onclick="fetch(\'sc_switchbox.php?action=switch&target='.$next.'\',\'switchbox\',\'replace\',\'event\');">&gt;&gt;</a>';
			echo $buttons.'</div>';
      break;
    
    case 'dropdown':
		$buttons='<select onchange="fetch(\'sc_switchbox.php?action=switch&target=\' + this.options[selectedIndex].value,\'switchbox\',\'replace\',\'event\');">';
			foreach($show AS $key){
			  $buttons.='<option value="'.$key.'">'.$_switchboxlanguage->module[$boxes[$key][1]].'</option>';
			}
			echo $buttons.'</select></div>';
      break;
	  
	case 'links':
		foreach($show AS $key){
			$buttons.='<a href="#" style="padding-right: 10px;" onclick="fetch(\'sc_switchbox.php?action=switch&target='.$key.'\',\'switchbox\',\'replace\',\'event\');">'.$_switchboxlanguage->module[$boxes[$key][1]].'</a>&nbsp;';
		}
		echo $buttons.'</div>';
	break;
  }
	
	include($boxes[$target][0]);
	
}
else{
	echo '<div id="switchbox"></div>';
	echo '<script type="text/javascript">
					<!-- 
						fetch(\'sc_switchbox.php?action=switch\',\'switchbox\',\'replace\',\'event\'); 
					-->
				</script>';
}
?>