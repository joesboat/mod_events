<?php
/**
* @package Author
* @author Joseph P. (Joe) Gibson
* @website www.joesboat.org
* @email joe@joesboat.org
* @copyright Copyright (C) 2018 Joseph P. Gibson. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('USPSaccess/dbUSPS');
//require_once(JPATH_LIBRARIES."/USPSaccess/dbUSPS.php");
jimport("usps/includes/routines");
jimport("usps/tableD5VHQAB");
require_once(JPATH_LIBRARIES."/usps/tableD5VHQAB.php");
require_once(JPATH_LIBRARIES."/usps/dbUSPSd5WebSites.php");
require_once(JPATH_LIBRARIES."/usps/tableAccess.php");
require_once(JPATH_LIBRARIES."/usps/dbUSPSjoomla.php");
class modeventsHelper
{
static $excludes = array(		
									'cert'=>'Certificate',
									'pic'=>'Photograph',
									'plk'=>'Plaque',
									'mem'=>'Memorial',
									'chr'=>'Charter'
					);

//**************************************************************************
static function add_or_update_location($dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource);
	switch (strtolower($_POST['command'])){
		case 'add':
			$_POST['squad_no'] = $_POST['org'];
			$WebSites->addLocation($_POST);
		case 'submit':
			$WebSites->updateLocation($_POST);
			break;
	}
	$WebSites->close();
	return ;
}
//**************************************************************************
static function add_historical_object($doc_type, &$award_id, $dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$awds = $WebSites->getAwardsObject();
	$_POST['doc_type'] = $doc_type;
	$rec = $awds->search_record('award_name = '.$_POST['award_name']."'' and award_year='".$_POST['award_name']."'")	;
	if ($rec) return "The Historical Object's Name must be unique for the award year.  Please choose another name" ; 	
	$rec = $awds->addBlankAwardRecord($_POST);
	$award_id = $_POST['award_id'] = $rec['award_id'];
	$_POST['squad_no'] = $_POST['org'];
	$return = modeventsHelper::update_award($dbSource);

	$WebSites->close();
	//$vhqab->close();
	return $return;
}
//****************************************************************
static function build_award_name($pst){
	// $pst is copy of $_POST array 
	// function finds Award_Name and Award_Place fields with content 
	// function builds and returns a consolidated award_name field 
	$cc = explode(' ', $pst['command'])[1];
	switch ( explode(' ', $pst['command'])[1]){
		case 'Educational':
			$pfx = "ed_";
			break;
		case 'Executive':
			$pfx = "ex_";
			break;
		case 'Secretaries':
			$pfx = "sec_";
			break;
		case "Administrative":
			$pfx = "adm_";
			break;
		case "Unique":
			return $pst['award_name'];
		default:
	}
	$str = $pfx."award_name";
	$name = $pst[$str] ; 
	$str = $pfx."award_place";
	$place = $pst[$str] ;
	return "$name $place";
}
//****************************************************************
static function build_register_modal($event){
$mod_folder = $GLOBALS['mod_folder'];
	$str = JURI::base()."modules/$mod_folder/assets/register_gen.php?ml=1&event_id=".$event['event_id'];
	$url = get_absolute_url($str);
	//$url = $event['register_url']."&ml=1";
	$str = "{modal ";
	$str .= $url;
	//$str .= " ";
	//$str .= 'class="button"';
	$str .= "}";
	//$str .= "Register";
	$str .= '<img src="'.JURI::base().'images/buttons/register-blue.jpg" />';
	$str .= "{/modal} ";
	return $str;
}
//****************************************************************
static function build_meal_setup_modal($event){
$mod_folder = $GLOBALS['mod_folder'];
	$str = JURI::base()."modules/$mod_folder/assets/meal_setup_gen.php?ml=1&event_id=".$event['event_id'];
	$url = get_absolute_url($str);
	//$url = $event['register_url']."&ml=1";
	$str = "{modal ";
	$str .= $url;
	//$str .= " ";
	//$str .= 'class="button"';
	$str .= "}";
	//$str .= "Register";
	$str .= '<img src="'.JURI::base().'images/buttons/meal_setup.jpg" />';
	$str .= "{/modal} ";
	return $str;
}
//***********************************************************************
static function build_date_str($start,$end){
	if ($start == $end)
		return date("j M, Y",strtotime($start));
	if (date("m",strtotime($start))==date("m",strtotime($end))){
		// same month
		$str = date("j",strtotime($start));
		if (date("j",strtotime($start))!=date("j",strtotime($end))){ 
			// different day
			$str .= "-".date("j",strtotime($end));	
		}
		$str .= " ".date("M, Y",strtotime($end));
		return $str;
	}
	// different month
	$str = date("j M - ",strtotime($start));
	$str .= date("j M, Y",strtotime($end));
	return $str; 
}
//****************************************************************
static function build_event_link($event){
	// Link to event_name_url if set
//	if ($event['event_name_url'] != ''){
		// Make sure url is absolute 
//		$url = get_absolute_url($event['event_name_url']);
//	if ($event['event_description'] == ''){
	$mod_folder = $GLOBALS['mod_folder'];
	$str = JURI::base()."modules/$mod_folder/assets/event_gen.php?ml=1&event_id=".$event['event_id'];
	$url = get_absolute_url($str);
	// Otherwise link to event_gen.php to display event data   
	$str = "<a href='$url' class='name' target='_blank' >";
	$str .= get_event_name($event,FALSE);
	$str .= "</a>";
	return $str;
}
//****************************************************************
static function build_event_modal($event,$pgm_name){
$mod_folder = $GLOBALS['mod_folder'];
	$str = JURI::base()."modules/$mod_folder/assets/$pgm_name?ml=1&event_id=".$event['event_id'];
	$url = get_absolute_url($str);
	$str = "{modal ";  
	$str .= $url;
	$str .= "}";
	$str .= get_event_name($event);
	$str .= "{/modal} ";
	return $str;
}
//**************************************************************************
static function delete_item($dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource);
	if (isset($_POST['event_id'])){
		$WebSites->deleteEvent($_POST['event_id']);
	}
	if (isset($_POST['location_id'])){
		$WebSites->deleteLocation($_POST['location_id']);
	}			//header("Location:setup_location.php");	
	if (isset($_POST['award_id'])){
		$WebSites->deleteAward($_POST['award_id']);
	}	
	$WebSites->close();
	return ;
}
//**************************************************************************
static function expand_event_record($evt,$dbSource='local'){
$mod_folder = $GLOBALS['mod_folder'];
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB",$dbSource);
	$evt_colors = $WebSites->getEventColors();
		$evt['poc_full_name'] = '';
		$evt['telephone'] = '';
		$evt['color'] = $evt_colors[$evt['event_type']];
		$evt['event_url'] = get_absolute_url(JURI::base()."modules/$mod_folder/assets/event_gen.php?event_id=".$evt['event_id']);
		$evt['register_url'] = get_absolute_url(JURI::base()."modules/$mod_folder/assets/register_gen.php&event_id=".$evt['event_id']);
		$evt['event_name_with_link'] = modeventsHelper::build_event_link($evt);
		$evt['event_name_with_modal'] = modeventsHelper::build_event_modal($evt,"event_gen.php");
		$evt['register_modal'] = modeventsHelper::build_register_modal($evt);
		if ($evt['poc_id'] != ''){
			$evt['poc_full_name'] = $vhqab->getMemberNameAndRank($evt['poc_id'], true);
			$evt['telephone'] = $vhqab->getMemberPhone($evt['poc_id']);
		}
		if ($evt['lead_squadron'] != ''){
			$evt['lead_squadron_short_name'] = 
				$vhqab->getSquadronShortName($evt['lead_squadron'],true);
		}
		$evt['date_obj'] = modeventsHelper::getDateObj($evt["start_date"],$dbSource);		
		$evt['date_str'] = modeventsHelper::build_date_str($evt["start_date"],$evt["end_date"]);
		$evt['date_rng'] = get_date_range($evt);
		$evt['date_2ln'] = getDateTime2($evt);
		$location = $WebSites->getLocation($evt['location_id']);
		$evt['location_name'] = $WebSites->getLocationName($location,true);
		$evt['squad_short_name'] =  $vhqab->getSquadronShortName($evt['squad_no'],true);
			// create a url parameter find this document 
		$evt['event_description'] =  $WebSites->getEventDescription($evt['event_id']);
		$evt['location'] = $WebSites->getLocationData($evt['location_id']);
		$evt['extras'] = $WebSites->getEventDocuments($evt['event_id']);
	$WebSites->close();
	$vhqab->close();
	return $evt;
}
//**************************************************************************
static function getAjax(){
	return 'It found the method.';
}
//**************************************************************************
function generateMealList($event_id, $file_in){
/*
 Insert Items - PHP program to create the html code to list conference purchase items 
 		An item may be a conference meal or other item the conference is selling 
 		Obtains an list of item attributes: 
 			The name of the item.  An example is 'Salmon Entre at Saturday Banquet'
 			The price of the item.  An exampls is 39 for $39 dollars. 
 			Any additional text to describe the item.  
 		The item list must be provided in the sequence to be displayed in form.  
 		Items will be numbered in the sequence found.
 		Each Item will create html <input> tags or open text as follows:
 			ItemDescriptionField<n> where n is the item number  
 				A Hidden field to provide the item name stored for each purchased
 					ItemCostField<n> where n is the item number
 				A Hidden field to provide the item cost to form coding and stored for each item purchased 
			Open text to describe the item to form user. 
				Text such as "Cost / person = $24&nbsp &nbsp&nbsp &nbsp Number Attending:"
			quantity<n> Text Field where n is the item number
				A Text field to allow for user to specify a purchase  
			subTotalField<n> Text Field where n is the item number 
				A Text field to allow form code to compute and store the $ value of the item purchase 
		Item data is supplied in & separated text format where each line provides:
			delimiter to specify type of input - can be 'item' or 'fieldset' 
			For fieldset, a string of characters to provide a heading on the form 
			For item: , The item name , The item price, The items additional text
		The Item data will be stored in the reg_events assets folder
		The Item data file will be named with <event_it>_items.csv
		At a later time a new feature will be added to mod_events to upload the csv file. 
*/
$eol = "\r\n" ;
//if (! isset($items)){
//	$builditems = true ;
//	$items = array();
//} else 
//	$builditems = false;
// Obtain and read the file 
$this_folder = __DIR__ ;
$a_dir = explode('mod_events',$this_folder);
copy($file_in['tmp_name'],__DIR__."/assets/".$event_id."items.txt");
$fIn = fopen($file_in['tmp_name'],"r") or 
	die("Unable to open?????");
$fieldset = false;	
$item = 0;
//$a_source = explode('/',$source);
$fname = $event_id."items.php";
$file_out = $a_dir[0]."mod_register/tmpl/$fname";
$fo = fopen($file_out,"w");
fwrite($fo,'<?php'.$eol);
fwrite($fo,"defined('_JEXEC') or die('Restricted access');$eol");
fwrite($fo,'	if (! isset($items)){'.$eol);
fwrite($fo,'		$builditems = true ;'.$eol);
fwrite($fo,'		$items = array();'.$eol);
fwrite($fo,'	} else '.$eol);
fwrite($fo,'		$builditems = false; '.$eol);
fwrite($fo,'?>'.$eol);	
/////////////////////////////////////////////////////////////	
fwrite($fo,"<table style='width:100%;' >$eol"); 
		
while ($line = fgets($fIn)){
	$def_ary = explode("&",$line);
	switch ($def_ary[0]){
	case "fieldset":
		if ($fieldset){
			fwrite($fo,'</fieldset>'.$eol);
			fwrite($fo,"</td>$eol");
			fwrite($fo,"</tr>$eol");
			$fieldset = false;
		}
		$fieldset = true;
		fwrite($fo,		"<tr>$eol");
		fwrite($fo,			"<td colspan='3'>$eol");
		fwrite($fo, 			'<fieldset>'.$eol.'<legend>'.$def_ary[1].'</legend>'.$eol);
		fwrite($fo,			"</td>$eol");
		fwrite($fo,		"</tr>$eol");
		fwrite($fo,		"<tr>$eol");
		fwrite($fo,			"<td>$eol");
		fwrite($fo,			"</td>$eol");
		fwrite($fo,			"<td>$eol");
		fwrite($fo,				'Quanity:' .$eol);
		fwrite($fo,			"</td>$eol");
		fwrite($fo,			"<td>$eol");		
		fwrite($fo,				'SubTotal:' .$eol);
		fwrite($fo,			"</td>$eol");
		fwrite($fo,		"</tr>$eol");
		break;
	case "item":
		$item += 1;	
		fwrite($fo,"<tr>$eol"); 
		fwrite($fo,"	<td>$eol");
		fwrite($fo,"<!--************************  Begin Item #$item  ******************************-->$eol");
		// $ary[1] = name 
		$description = $def_ary[1];
		// $ary[2] = price 
		$price = $def_ary[2];
		// $ary[3] = text 
		$text = trim($def_ary[3]);
		fwrite($fo,'<?php'.$eol);
		fwrite($fo,'		if ($builditems){'.$eol);
		fwrite($fo,'			$items['.$item.']["quantity"] = "0";'.$eol);
		fwrite($fo,'			$items['.$item.']["Total"] = "0";'.$eol);
		fwrite($fo,'		}'.$eol);
		fwrite($fo,'?>'.$eol);		
		fwrite($fo,'		<input 	type="hidden"' .$eol); 
		fwrite($fo,'				name="ItemDescriptionField'.$item.'"' .$eol);
		fwrite($fo,'				id="ItemDescriptionField'.$item.'"' .$eol);
		fwrite($fo,'				value="'.$description.'"' .$eol);
		fwrite($fo,'		/>' .$eol); 
		fwrite($fo,'		<input 	type="hidden"' .$eol);  
		fwrite($fo,'				name="ItemCostField'.$item.'" ' .$eol); 
		fwrite($fo,'				id="ItemCostField'.$item.'"' .$eol);
		fwrite($fo,'				value="'.$price.'"'.$eol);
		fwrite($fo,'		/>' .$eol);
		fwrite($fo,			"<b>$description:</b>&nbsp;&nbsp;( $ $price )$eol"); 
		fwrite($fo,"	</td>$eol");
		//fwrite($fo,"	<td>$eol");
		//fwrite($fo,"		<b>$ $price</b>$eol");
		//fwrite($fo,"	</td>$eol");
		fwrite($fo,"	<td>$eol");
		fwrite($fo,'		<input 	type="text"' .$eol);
		fwrite($fo,'				name="quantity'.$item.'" ' .$eol);
		fwrite($fo,'				id="quantity'.$item.'" ' .$eol);
		fwrite($fo,'				maxlength="1"  ' .$eol);
		fwrite($fo,'				size="1"  ' .$eol);
		fwrite($fo,'				placeholder = "0" ' .$eol);
		fwrite($fo,'				onkeyup="calculate(this);"' .$eol);
		fwrite($fo,'				value="<?php echo $items['.$item.']["quantity"]; ?>" ' .$eol);
		fwrite($fo,'		/>' .$eol);
		fwrite($fo,"	</td>$eol");
		fwrite($fo,"	<td>$eol");
		fwrite($fo,'		<!--SubTotal = -->' .$eol);
		fwrite($fo,			'<input 	type="text" ' .$eol);
		fwrite($fo,				'name="subTotalField'.$item.'" ' .$eol);
		fwrite($fo,				'id="subTotalField'.$item.'"  ' .$eol);
		fwrite($fo,				'maxlength="6" ' .$eol);
		fwrite($fo,				'readonly ' .$eol);
		fwrite($fo,				'tabindex="-1" ' .$eol);
		fwrite($fo,				'size="5" ' .$eol);
		fwrite($fo,				'value="<?php echo $items['.$item.']["Total"]; ?>" ' .$eol);
		fwrite($fo,			'/>' .$eol);
		fwrite($fo,"	</td>$eol");
		fwrite($fo,"</tr>$eol");
		if ($text != ''){
			fwrite($fo,"<tr>$eol");
			fwrite($fo,"	<td> $eol");
			fwrite($fo,			"&nbsp;&nbsp;&nbsp;&nbsp;$text $eol");
			fwrite($fo,"	</td>$eol");
			fwrite($fo,"	<td colspan='2'>$eol");
			fwrite($fo,"	</td>$eol");
			fwrite($fo,"</tr>$eol"); 		
		}
		break;
	case "text":
		$text = trim($def_ary[1]);
		fwrite($fo,"<tr>$eol");
		fwrite($fo,"	<td> $eol");
		fwrite($fo,			"&nbsp;&nbsp;&nbsp;&nbsp;$text $eol");
		fwrite($fo,"	</td>$eol");
		fwrite($fo,"	<td colspan='2'> $eol");
		fwrite($fo,"	</td>$eol");
		fwrite($fo,"</tr>$eol");
		break;
	default:
	}
}
if ($fieldset){
	fwrite($fo,				"</fieldset>$eol");
	fwrite($fo,			"</td>$eol");
	fwrite($fo,		"</tr>$eol");
}
fwrite($fo,"</table>$eol"); 
fclose($fh);
fclose($fo);
}
//**************************************************************************
static function get_award($award_id,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$awds = $WebSites->getAwardsObject();
	$blobs = $WebSites->getBlobsObject();
	$array = $awds->get_record('award_id',$award_id);
	if (! $array) return false;
	$array['extras'] = array();
	$doc_list = $blobs->get_award_documents($award_id,$dbSource);
	foreach($doc_list as $doc){
		$array['extras'][$doc['b_info']][$doc['b_type']] = $doc['title'];
	}
	$WebSites->close();
	return $array;
}
//**************************************************************************
static function get_award_blank($setup,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$array = $WebSites->getAwardBlank();
	$array['award_name'] = "";
	$array['award_type'] = "squadron";
	$array['award_source'] = "district";
	$array['poc_id'] = $setup['user_id'];
	$array['squad_no'] = $setup['org'];
	$array['extras'] = array();
	$array['award_citation'] = '';
	return $array;
}
//**************************************************************************
static function get_award_sources($dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$awds = $WebSites->getAwardsObject();
	$sources = $awds->award_sources;
	$WebSites->close();
	return $sources;
}
//**************************************************************************
static function get_award_types($dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$awds = $WebSites->getAwardsObject();
	$types = $awds->award_types;
	$WebSites->close();
	return $types;
}
//**************************************************************************
static function get_awards($org,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$awards =  $WebSites->getAwards($org) ;
	$WebSites->close();
	return $awards;
}
//**************************************************************************
static function get_conference_events($org,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$select = "event_type = 'conf'";
	$events =  $WebSites->getEvents("squad_no='$org'",$select) ;
	$WebSites->close();
	return $events;
}
//****************************************************************
static function getDateObj($date = null, $allDay = null, $tz = null){
	$dateObj = JFactory::getDate($date, $tz);

		$timezone = JFactory::getApplication()->getCfg('offset');
		$user = JFactory::getUser();
		if ($user->get('id'))
		{
			$userTimezone = $user->getParam('timezone');
			if (! empty($userTimezone))
			{
				$timezone = $userTimezone;
			}
		}

		$timezone = JFactory::getSession()->get('user-timezone', $timezone, 'DPCalendar');

		if (! $allDay)
		{
			$dateObj->setTimezone(new DateTimeZone($timezone));
		}
		return $dateObj;
}
//**************************************************************************
static function get_display_year($squad_no, $dbSource='local'){
	require(JPATH_LIBRARIES."/USPSaccess/dbUSPS.php");
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB",$dbSource);
	$year = $vhqab->getSquadronDisplayYear($squad_no);
	return $year;
}
//**************************************************************************
static function get_dist_or_squad_conference_events($org,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource);
	$select = "event_type = 'conf' or event_type = 'mtg'";
	$orgs = "squad_no='$org' or squad_no ='6243'";
	$events =  $WebSites->getEvents($orgs,$select,'') ;
	$WebSites->close();
	return $events;	
}
//**************************************************************************
static function get_doc_types($dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$types = $WebSites->getDocTypes();
	$WebSites->close();
	return $types;
}
//**************************************************************************
static function get_ed_awds(){
	$awd_names = array(	
		"Kenneth Smith Seamanship Award"=>"Kenneth Smith Seamanship Award",
		"Prince Henry Award"=>"Prince Henry Award",
		"Caravelle Award"=>"Caravelle Award",
		"Henry E. Sweet Award"=>"Henry E. Sweet Excellence Award",
		"Commanders Trophy Advanced Grades Award"=>"Commanders Trophy Advanced Grades Award",
		"Commanders Trophy Electives Award"=>"Commanders Trophy Electives Award",
		"Workboat Award"=>"Workboat Award",
		""=>"Select a standard Educational Department award"
	);
	return $awd_names;
}
//**************************************************************************
static function get_event($event_id,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$evt = $WebSites->getEvent($event_id,FALSE);
	$evt['meal_setup_url'] = get_absolute_url(JURI::base()."modules/".$GLOBALS['mod_folder']."/assets/meal_setup_gen.php&event_id=".$evt['event_id']);
	$evt['meal_setup_modal'] = modeventsHelper::build_meal_setup_modal($evt);
	$WebSites->close();
	return $evt;
}
//**************************************************************************
static function get_event_blank($dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$blk = $WebSites->get_event_blank();
	$WebSites->close();
	return $blk;
}
//**************************************************************************
static function get_event_types($dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$typs = $WebSites->getEventTypes();
	$WebSites->close();
	return $typs;
}
//*********************************************************
static function get_events($org,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$events =  $WebSites->getEvents("squad_no='$org'","","desc") ;
	$WebSites->close();
	return $events;
}
//*********************************************************
static function get_events_list($events){
	// Returns an associative array where the indexes are the event_id s  
	foreach($events as $entry){
		$ary[$entry['event_id']] = date("Y",strtotime($entry['start_date']))." ".$entry['event_name'];
	}
	return $ary;
}
//*********************************************************
static function get_events_having_documents($org,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$evts = $WebSites->getEventsObject();
	$blob = $WebSites->getBlobsObject();
	$blb_name = $blob->table_name;
	$evt_name = $evts->table_name;
	$query = "$evt_name.squad_no=$org and ($blb_name.b_use LIKE 'b_event_document') " ;
	$join = "INNER JOIN d5_blobs ON events.event_id = $blb_name.item_part_no";
	$events = $evts->search_with_join($query,'start_date DESC'  , $join);	
	$id = '';
	foreach ($events as $event){
		if ($event['event_id'] != $id){
			$event['event_name_with_modal'] = modeventsHelper::build_event_modal($event,"document_gen.php");
			$list[] = $event;
			$id = $event['event_id'];
		} else 
			continue; 
		
	}
	
	
	return $list;
}
//*********************************************************
static function get_events_with_sort($display_by,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$evts =  $WebSites->getEventsObject() ;
	

	
	


	$query = $state = $event_name = $squad_no = '';
	$query .= "course_id != '' and start_date >= curdate() ";
	$this_year = 0;
	switch($display_by){
		case 'name':
			$events = $evts->get_avail_tng_events_by_name();
			break;
		case 'type':
			break;
		case 'location':
			$events = $evts->get_avail_tng_events_by_location();
			break;
		case 'squadron':
			$events = $evts->get_avail_tng_events_by_squad();
			break;
		case 'date':
			$events = $evts->get_tng_class_events_by_date();
			break;
		case 'seminars':
			$events = $evts->get_tng_seminar_events_by_date();
		case 'classes':
			$events = $evts->get_avail_tng_events_by_date();
			break;
	}
	return $events; 
}
//*********************************************************
static function get_ex_awds(){
	$array = array (
		"Vessel Safety Checks, Individual"=>"Vessel Safety Checks, Individual",
		"Vessel Safety Checks, Squadron"=>"Vessel Safety Checks, Squadron",
		"Doing It Right Award"=>"Doing It Right Award",
		"Distinguished Civic Service Award"=>"Distinguished Civic Service Award",
		"COMMUNITY OUTREACH AWARDS"=>"COMMUNITY OUTREACH AWARDS",
		""=>"Select a standard Executive Department award"	
	);
	return $array;
}
//*********************************************************
static function get_adm_awds(){
	$array = array(
		"Snyder Award"=>"Snyder Award",
		"Membership Growth Award"=>"Membership Growth Award",
		""=>"Select a standard Administrative Department award"	
	);
	return $array;
}
//*********************************************************
static function get_sec_awds(){
	$array = array(
		""=>"Select a standard Secretaries Department award"
	);
	return $array;
}
//**************************************************************************
static function get_future_events($org,$select='',$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$events = $WebSites->getFutureEvents($org,$select);
	$WebSites->close();
	return $events;
}
//**************************************************************************
static function get_location($loc_id,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$loc = $WebSites->getLocation($loc_id);
	$WebSites->close();
	return $loc;
}

//**************************************************************************
static function get_location_blank($dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$blk = $WebSites->get_location_blank();
	$WebSites->close();
	return $blk;
}
//**************************************************************************
static function get_location_list($squad_no,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$locs = $WebSites->getLocationList($squad_no);
	$WebSites->close();
	return $locs;
}
//**************************************************************************
static function get_members($squad_no,$dbSource='local'){
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB",$dbSource);
	$mbrs = $vhqab->getD5MembersObject();
	$members = $mbrs->get_d5_or_squad_member_list($squad_no);
	$vhqab->close();
	return $members;
}
//**************************************************************************
static function get_members_squadron_account($certno,$dbSource='local'){
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB",$dbSource);
	$sq = $vhqab->getSquadNumber($certno);
	$vhqab->close();
	return $sq;
}
//**************************************************************************
static function get_objects($org,$dbSource='local'){
/**
*		An object is an award entered to capture a picture of an 'object' (a plaque, a
*  		certificate, a memorial, or the charger document) where it is not essential 
* 		that the 'object' be retained. 
* 		These types of awards were created with this tool!  .    
* 		
*/
//	Initial search will find an organization's events have an associated record in blobs. 
//	The types of 
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource);
	$events = $WebSites->getEventsObject();
	$blobs = $WebSites->getBlobsObject();
	$awards = $WebSites->getAwardsObject();
	//  first find all Plaques, certificates, Memorials, or Charters  records in blobs
	$st = implode("','",$awards->object_types);
	$query = "b_use = 'b_award_document' and b_info IN ( '$st' ) and ".
					"(award_to_squadron = '$org' or d5_awards.squad_no = '$org')";
	$list = "d5_awards.*, d5_blobs.* ";
	$join = "INNER JOIN d5_awards ON d5_awards.award_id = d5_blobs.item_part_no";
	$order = "d5_awards.award_year DESC";
	$awds = $blobs->search_partial_with_join($list,$query,$order,$join);
	//  Use the award_id to obtain the award record and event_record  
	return $awds ;
	$list = "d5_blobs.*, EVENTS. *";
	$join = "INNER JOIN d5_blobs ON events.event_id = d5_blobs.item_part_no";
	$query = "events.squad_no = '$org' and (d5_blobs.b_use = 'b_event_document' OR d5_blobs.b_use = 'b_award_document')";
	$evts = $events->search_partial_with_join($list,$query,"events.start_date DESC",$join); 
	$WebSites->close();	
	return $evts;
}
//**************************************************************************
static function get_officer_list($squad_no, $year, $dbSource='local'){
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB",$dbSource);
	$lst = $vhqab->getSquadronOfficerList($squad_no,$year);
	$vhqab->close();
	return $lst;
}
//**************************************************************************
static function get_session_stack($ip,$squad_no,$dbSource='local'){
$me = $GLOBALS['me'];
	require(JPATH_LIBRARIES."/USPSaccess/dbUSPS.php");
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource);
	$blob = $WebSites->getBlobsObject();
	$stack = $blob->get_session_stack($ip,$squad_no,$me);
	$blob->close();
	return $stack;
}
//*********************************************************
static function get_some_events($source,$types='',$dbSource='local'){
$mod_folder = $GLOBALS['mod_folder'];
$loging = $GLOBALS['loging'] ;
	if ($loging) log_it(__FUNCTION__ , __LINE__);
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB",$dbSource);
	$evts = $WebSites->getEventsObject();
	$evt_colors = $WebSites->getEventColors();
	$select = '';
	$typs = array();
	if ( in_array('all',$types)){
		//  It's simple.  We just get them all
	} else {
		if ( in_array('allmtg',$types)){
			$typs = $evts->mtg_types;
		}
		elseif ( in_array('alltng',$types)){
			$typs = $evts->tng_types;
		}
		else{
			// Ok, this is a specialized display.  Must build a select list of event types
			$all = $evts->evt_types;
			foreach($all as $key => $typ){
				if (in_array($key,$types)){
					$typs[$key] = $typ;
				}			
			}
		}
		$cnt = count($typs);
		foreach($typs as $typ=>$type){
			$select .= "event_type='$typ'";
			$cnt --;
			if ($cnt > 0) $select .= ' or ';
		}	
	}
	// if ($source != '') $source = "squad_no = '$source'";
	if ($loging) log_it("Before getfutureEvents",__LINE__);
	$events = $WebSites->getFutureEvents($source, $select);	
	if ($loging) log_it("After getfutureEvents",__LINE__);
	foreach($events as &$evt){
		$evt['extras'] = $WebSites->getEventDocuments($evt['event_id']);
			$evt['poc_full_name'] = '';
		$evt['telephone'] = '';
		$evt['color'] = $evt_colors[$evt['event_type']];
		$evt['event_name_with_modal'] = modeventsHelper::build_event_modal($evt,"event_gen.php");
		$evt['register_modal'] = modeventsHelper::build_register_modal($evt);
		if ($evt['poc_id'] != ''){
			$evt['poc_full_name'] = $vhqab->getMemberNameAndRank($evt['poc_id'], true);
			$evt['telephone'] = $vhqab->getMemberPhone($evt['poc_id']);
		}
		if ($evt['lead_squadron'] != ''){
			$evt['lead_squadron_short_name'] = 
				$vhqab->getSquadronShortName($evt['lead_squadron'],true);
		}
		$evt['date_obj'] = modeventsHelper::getDateObj($evt["start_date"],$dbSource);		
		$evt['date_str'] = modeventsHelper::build_date_str($evt["start_date"],$evt["end_date"]);
		$evt['date_rng'] = get_date_range($evt);
		$evt['date_2ln'] = getDateTime2($evt);
		$evt['location_name'] = $WebSites->getLocationName($evt['location'],true);
		$evt['squad_short_name'] =  $vhqab->getSquadronShortName($evt['squad_no'],true);
			// create a url parameter find this document 
	}
	$WebSites->close();
	$vhqab->close();
	if ($loging) log_it("Before return",__LINE__);
	return $events;
}
//**************************************************************************
static function get_squadron_list($dbSource='local'){
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB",$dbSource);
	$sqds = $vhqab->getSquadronObject();
	$squadrons = $sqds->get_squadron_list();
	return $squadrons;
}
//**************************************************************************
static function get_squadron_name($org,$dbSource='local'){
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB",$dbSource);
	$nm = $vhqab->getSquadronShortName($org);
	return $nm;
}
//**************************************************************************
static function get_squadron_state($org,$dbSource='local'){
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB",$dbSource);
	$state = $vhqab->getSquadronState($org);
	return $state;
}
//**************************************************************************
static function handle_award_name($pst,$setup,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$blob = $WebSites->getBlobsObject();
	switch( strtolower($pst['command']) ){
		case 'add':
			$blob->store_award_name($pst['award_name'],$pst['award_org'],$pst['award_type']);
			break;
		case 'delete':
			break;
		case 'update':
			break;
	}

	
	return ;
	
	
	
}
//**************************************************************************
static function handle_file_delete($setup,$dbSource='local'){
$me = $GLOBALS['me'];
	// Delete 1 or more extra event files 
	// Each file to be deleted will be in $_POST delete_(n) element 
	// where n is not relivant 
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	foreach ($_POST as $key=>$name){
		if (substr($key,0,7) != 'delete_') continue;
		$WebSites->deleteExtraFile($name);
	}
	$WebSites->close();
	$link = "$me?org=".$setup['org'];
	header("Location:$link");	
}
//**************************************************************************
static function setup_session_stack($org,$stack,$dbSource='local'){
$me = $GLOBALS['me'];
	require(JPATH_LIBRARIES."/USPSaccess/dbUSPS.php");
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource);
	$blob = $WebSites->getBlobsObject();
	$blob->delete_session_stack($org,$_SERVER['REMOTE_ADDR'],$me);
	$blob->add_session_stack($org,$_SERVER['REMOTE_ADDR'],$stack,$me,$dbSource);
//	$blob->close();
}
//**************************************************************************
static function store_session_stack($ip, $org, $stack, $me='',$dbSource='local'){
$me = $GLOBALS['me'];
	require(JPATH_LIBRARIES."/USPSaccess/dbUSPS.php");
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource);
	$blob = $WebSites->getBlobsObject();
	$stack = $blob->store_session_stack($org,$ip,$stack,$me);
	$blob->close();
	return $stack;
}
//**************************************************************************
static function update_award($setup, $dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$awds = $WebSites->getAwardsObject();
	$blobs = $WebSites->getBlobsObject();

	switch($_POST['award_type']){
		case 'squadron':
			$_POST['award_to_squadron'] = $_POST['org'];
			break;
		default:
	}
	if ($_POST['award_name'] == ''){
			$_POST['award_name'] = $_POST['special_award_name'];
	}
	if ($_POST['award_name'] == ''){
		return "You must provide an Award Name";
	}
	if ($_POST['event_id'] == 0 and $_POST['award_source'] == 'district'){
		return "You must identify the conference for a district award.";
	}
	$awds->update_record_changes('award_id',$_POST);

	if (isset($_POST['award_extra'])){
		if ($_POST['doc_type'] == ''){
			return 'You must choose a document type!';
		}
		if ($_POST['doc_type'] == 'spc' and $_POST['doc_special'] == ''){
			return 'You must specify a special document type!';
		}
	// Call File System Routine to store file 
	$doc_types = $WebSites->getDocTypes(); 
	if ($_POST['doc_type'] == 'spc'){
		$type = $_POST['doc_special'];
	} else {
		$type = $doc_types[$_POST['doc_type']];
	}
	$rel_file_name = storeExtraFile(			
		$_POST['award_id'],
		$_POST['award_extra'],	// The $_FILE array
		$type,
		$_POST['award_year'],
		"awards") ;
	if ($_POST['award_extra']['type'] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
		$_POST['award_extra']['type'] = "application/msword";
			
	// Call Blobs Routine to associate file name with award 	
	$return = $blobs->store_award_document(
			$_POST['award_id'],
			$rel_file_name,
			$_POST['award_extra']['type'], //$mime
			$type,
			$_POST['award_year'],
			$_POST['award_extra']);				// Used for file prefix 
	$WebSites->close();
	// $vhqab->close();
	return $return;
}
	}
//**************************************************************************
static function update_event($dbSource='local'){
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB",$dbSource);
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	if (isset($_FILES['extra'])){
		if ($_FILES['extra']['error'] == 0 and $_FILES['extra']['name'] != '' )
			$_POST["event_extra"] = $_FILES['extra'];
	}
	if (isset($_FILES['meal_list'])){
		if ($_FILES['meal_list']['error'] == 0 and $_FILES['meal_list']['name'] != '')
			$xxx = modeventsHelper::generateMealList($_POST['event_id'], $_FILES['meal_list'] );		
	}
	$start_date = strtotime($_POST['event_st_dt']." ".$_POST['event_st_tm']);
	$end_date = strtotime($_POST['event_sp_dt']." ".$_POST['event_sp_tm']);
	if ($end_date < $start_date){
		$end_date = $start_date;
	}
	if ($_POST['org'] == '6243'){
		$reg_deadline = strtotime($_POST['reg_deadline']);
		$rate_deadline = strtotime($_POST['location_rate_deadline']);
		if ($_POST['register_online'] == '' ) 
			$_POST['register_online'] = 0;
		$_POST['reg_deadline'] = date("Y-m-d", $reg_deadline);
		$_POST['location_rate_deadline'] = date("Y-m-d", $rate_deadline);
	}
	$_POST['poc_name'] = $vhqab->getMemberNameAndRank($_POST['poc_id']);
	$_POST['poc_email'] = $vhqab->getMemberEmail($_POST['poc_id']);
	$_POST['poc_phone'] = $vhqab->getMemberPhone($_POST['poc_id']);
	$_POST['start_date'] = date("Y-m-d H:i:s",$start_date);
	$_POST['end_date'] = date("Y-m-d H:i:s",$end_date);
	$_POST['squad_no'] = $_POST['org'];
	if (strtolower($_POST['command']) == 'add'){
		$_POST = $WebSites->addEvent($_POST);  //  The basics are now safe
	} else{
		$return = $WebSites->updateEvent($_POST);
	}
	$WebSites->close();
	$vhqab->close();
	return $return ;
}
//**************************************************************************
static function update_stack($setup,$dbSource='local'){
$me = $GLOBALS['me'];
	require(JPATH_LIBRARIES."/USPSaccess/dbUSPS.php");
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource);
	$blob = $WebSites->getBlobsObject();
	$stack = $_SESSION['stack'];
	$stack[count($stack)-1] = serialize($setup);
	$_SESSION['stack'] = $stack;	
	$blob->store_session_stack($setup['org'],$_SERVER['REMOTE_ADDR'],$stack,$me);	
	$blob->close();
}
//****************************************************************************
static function handle_command(&$setup,$dbSource='local'){
	$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",$dbSource); 
	$awds = $WebSites->getAwardsObject();
$loging = $GLOBALS['loging'];
$me = $GLOBALS['me'];
	$pst = $_POST;
	$cmd = strtolower($_POST['command'])." ".$setup['mode'];
	if ($loging) log_it("Handling $cmd", __LINE__);
	switch($cmd){
		case 'add award_name':
			modeventsHelper::handle_award_name($pst,$setup,$dbSource);
			break;
		case 'update award_name':
			modeventsHelper::handle_award_name($pst,$setup,$dbSource);
			break;
		case 'delete award_name':
			modeventsHelper::handle_award_name($pst,$setup,$dbSource);
			break;
		case 'return award':
		case 'return history':

			pop($setup); 
		case 'meeting award':
			update_stack($setup);
			return $setup;
			break;
		case 'return event':
			pop($setup); 
		case 'meeting event':
			modeventsHelper::update_stack($setup);
			return $setup;
			break;
		case 'locations event':
			push('location','change',$setup);
			break;
		case 'new location event':
		case 'new location';
			push('location','add',$setup);
			break;
		case 'new event':
			push('event','add',$setup);
			break;
		case 'add event':
		case 'submit event':
			$return = modeventsHelper::update_event($dbSource);		// $_POST carries data on event 
			if ($return != '')
				$setup['error'] = $return;
			break;
		case 'submit history':
			// Update the historical event and optionally add a new event 
			// Determine if a new event is to be added 
			if ($_POST['new_event_name'] != '' and (	$_POST['new_start_date'] == '' or 
														$_POST['new_event_type'] == '' )){
				$setup['error'] = "You must provide name, start date and event type to add a new Squadron Event.";
				break;	
			}
			if (	$_POST['new_event_name'] != '' ){
				// Create the event
				$_POST["event_st_dt"] = $_POST['new_start_date'];
				$_POST['event_type'] = $_POST['new_event_type'];
				$_POST['event_name'] = $_POST['new_event_name'];
				$_POST['command'] = 'add';
				$return = modeventsHelper::update_event($event_id,$dbSource);		// $_POST carries data on event 			
				$_POST['event_id'] = $event_id;
				if ($return != '')
					$setup['error'] = $return;
				$_POST['command'] = 'submit';	
			}
			if (count($_FILES) > 0)
				foreach($_FILES as $file){
					if ($file['error'] == 0 and $file['name'] != '' ){
						$_POST["award_extra"] = $file;
						break ;
					}
				}
			// Store the new event_id in the award record 
			// Update the award
			$return = modeventsHelper::update_award($setup,$dbSource);
			if ($return != ''){
				$setup['error'] = $return;
				// OK - we must setup to repeat the 
				
			}
			// pop($setup);
			break;				
		case 'new award':
			push('award','add',$setup);
			break;
		case 'add award':
			$rec = $awds->addBlankAwardRecord($_POST);
			$_POST['award_id'] = $rec['award_id'];
			// $_POST['squad_no'] = $_POST['org'];
		case 'submit award':
			if (count($_FILES) > 0)
				foreach($_FILES as $file){
					if ($file['error'] == 0 and $file['name'] != '' ){
						$_POST["award_extra"] = $file;
						break ;
					}
				}			
			$return = modeventsHelper::update_award($dbSource);
			if ($return != ''){
				$WebSites->deleteAward($_POST['award_id']);
				$setup['error'] = $return;		
			} else 
				pop($setup);
			break;
		case 'add location':
		case 'submit location':
			modeventsHelper::add_or_update_location($dbSource);
			pop($setup);
			break;
		case 'update event':
			$setup['event_id'] = $_POST['event_id'];
			push($setup['mode'],'update',$setup);
			break;
		case 'update award':
		case 'update history':
			$setup['award_id'] = $_POST['award_id'];
			if ($setup['mode'] == 'history'){
				$setup['object'] = $_POST['object'];
			}

			push($setup['mode'],'update',$setup);
			pop($setup);
			break;
		case 'update location':
			$setup['location_id'] = $_POST['location_id'];
			push($setup['mode'],'update',$setup);
			break;
		case 'delete event':
		case 'delete location':
		case 'delete award':
		case 'delete history':
			modeventsHelper::delete_item($dbSource);
			break;
		case 'cancel event':
		case 'cancel award':
		case 'cancel location':
			pop($setup);
		case 'exit event';
			unset($_SESSION['stack']);
			$blob->delete_session_stack($org,$_SERVER['REMOTE_ADDR'],$me);
			echo("We are done!  Use a menu to select the next page. ");
			exit;
		case 'add plaque history':
		case 'add certificate history':
		case 'add memorial history':
		case 'add photograph history':
		case 'add charter history':
			if (count($_FILES) > 0){
				foreach($_FILES as $file){
					if ($file['error'] == 0 and $file['name'] != '' ){			
						$_POST["award_extra"] = $file;
						switch( strtolower( explode(' ',$_POST['command'])[1] ) ){
							case 'plaque': $typ = 'plk'; break;
							case 'certificate':	$typ = 'cert'; break;
							case 'photograph': $typ = 'pic'; break;
							case 'memorial': $typ='mem'; break;
							case 'charter': $typ = 'ctr'; break;
						}			
						if ($setup['error']=modeventsHelper::add_historical_object($typ,$award_id,$dbSource) == ''){
							$setup['object'] = explode(' ',$_POST['command'])[1];
							$setup['award_id'] = $award_id;
							push($setup['mode'],'update',$setup);
						}
					}
				}
			}
			$setup['error'] = "You must supply a Picture (or Document) describing the item! ";
			break;
		case 'exit award';
			unset($_SESSION['stack']);
			$blob->delete_session_stack($org,$_SERVER['REMOTE_ADDR'],$me);
			echo("We are done!  Use a menu to select the next page. ");
			// header("Location:index.php/d5-members-only");
			exit;
		case 'display_by event_sort':
			//if (isset($_GET['command'])){
			//	$display_by = $_GET['command'];
			//} else{
			//	$display_by = 'date';
			//}
			if (isset($_POST['command'])){
				$display_by = $_POST['value'];
			}
			$setup['display_by'] = $_POST['value'];
			break;
	}
	modeventsHelper::update_stack($setup);
	$link = "$me?org=".$setup['org']."&issetup=0";
	header("Location:$link");
	exit(0);		
}
//**************************************************************************

} // End of modeventsHelper
//****************************************************************************
function pop($setup){
require_once(dirname(__FILE__).'/helper.php');
$me = $GLOBALS['me'];
	$stack = $_SESSION['stack'];
	if (count($stack)>1){
		unset($stack[count($stack)-1]); 
		$_SESSION['stack'] = $stack;
		modeventsHelper::store_session_stack($_SERVER['REMOTE_ADDR'],$setup['org'],$stack);
	}
	$link = "$me?org=".$setup['org']."&issetup=0";
	header("Location:$link");
	exit(0);
}
//****************************************************************************
function push($mode,$action,$setup){
require_once(dirname(__FILE__).'/helper.php');
$me = $GLOBALS['me'];
	$setup['mode'] = $mode;
	$setup['action'] = $action;
	$stack = $_SESSION['stack'];
	$stack[] = serialize($setup);
	$_SESSION['stack'] = $stack;
	modeventsHelper::store_session_stack($_SERVER['REMOTE_ADDR'],$setup['org'],$stack);
	$link = "$me?org=".$setup['org']."&issetup=0";
	header("Location:$link");
	exit(0);
}

