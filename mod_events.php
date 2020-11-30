<?php
/**
* @package Author
* @author Joseph P. (Joe) Gibson
* @website www.joesboat.org
* @email joe@joesboat.org
* @copyright Copyright (C) 2018 Joseph P. Gibson. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
* 
* General $_POST or $_GET value rules 
* 	- All values will be interpreted in lower case
* 	- The 'command' variable will direct module to:
* 		'add' will result in a new database record and may display a form to display record contents
* 		'new' wlll display a form to obtain values for a new record 
* 		'submit' will update an existing record 
* 		'update' will display a form containing a current record where it can be modified
* 
* 
* 
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once(dirname(__FILE__).'/helper.php');
$debug = $params->get('siteDump');
$GLOBALS['loging'] = $loging = $params->get('siteLog');
$GLOBALS['mod_folder'] = $mod_folder = explode('.',basename(__FILE__))[0];
$db_source 		= $params->get('dbsource');
$orgType 		= $params->get('orgType');
$modtype 		= $params->get('modtype');
$scope 			= $params->get("scope");
$layout_height 	= $params->get("layout_height");
$app       	= JFactory::getApplication(); // Access the Application Object
$menu      	= $app->getMenu(); // Load the JMenuSite Object
$active    	= $menu->getActive(); // Load the Active Menu Item as an stdClass Object	
$me 		= $GLOBALS['me'] = $active->alias;
$jinput 	= $app->input;
if ($loging) log_it(__FILE__,__LINE__);
if ($loging) log_it("The me value is: $me",__LINE__);
$year 		= modeventsHelper::get_display_year();
$year		= date("Y");
$issetup 	= $jinput->get('issetup');
$user 		= JFactory::getUser();
$username 	= $user->username; 

if (isset($issetup)){
	if ($loging) write_log_array($_SESSION,'$_SESSION',__LINE__);
	$org = $jinput->get('org');
	$stack = modeventsHelper::get_session_stack($_SERVER['REMOTE_ADDR'],$org);
	$_SESSION['stack'] = $stack;
	$setup = unserialize($stack[count($stack)-1]);	
} else {
	// we must initialize 
	$stack = $setup = array();
	switch ($orgType){
		case 'dist':
			$org = '6243'; 
			$squad_name = 'District 5';
			//$id = getGroupId('District Officer');		
			break;
		case 'squad':
			$org = $params->get('sqdcode');
			$squad_name = modeventsHelper::get_squadron_name($org);
			$id = getGroupId('Squadron Officer');
			break;
		case 'mbrsquad':
			$org = modeventsHelper::get_members_squadron_account($username);
			$squad_name = modeventsHelper::get_squadron_name($org);
			$id = getGroupId('Squadron Officer');
			break;
		case 'squad_no':
			$org = $jinput->get("squad_no");
			$squad_name = modeventsHelper::get_squadron_name($org);
			$id = getGroupId('Public');
			break;
		case 'award_no':
			$org = $jinput->get("squad_no");
			$squad_name = modeventsHelper::get_squadron_name($org);
			$id = getGroupId('Public');
			break;
		case "any":
			$org = '';
			$id = getGroupId('District Officer');		
			$squad_name = "Any Squadron";
			break;
	}
	$levels = JAccess::getAuthorisedViewLevels($user->id);
	$groups = $user->groups ;
	$groups = JAccess::getGroupsByUser($user->id);
// 	if (! in_array($id,$groups)){
//		echo "You are not authorized to execute this tool.  Please contact an officer for assistance.";
//		exit;
//	}
	$setup['orgType'] = $orgType;
	$setup['org'] = $org;
	$setup['org_name'] = $squad_name;
	$setup['state'] = modeventsHelper::get_squadron_state($org);
	$setup['user_id'] = $username; 
	switch($modtype){
		case "event":
		case "award":
		case "history":
			$setup['action'] = 'change' ;
			break;
		case "event_list":
		case "award_list":
			$setup['action'] = 'list' ;
			break;
		case "award_show":
		case "event_show":
			$setup['action'] = 'show';
			break;
		case "event_sort":
			$setup['action'] = 'sort';
			break;
		case 'event_documents':
			$setup['action'] = 'show';
			break;
		default:
	}
	$setup['mode'] =  $modtype ;
	$setup['header'] = $setup['org_name']." ".ucfirst($setup['mode'])." Maintenance."; 
	$setup['error'] = '';
	$setup['return_to'] = $_SERVER['PHP_SELF'];
	$stack[0] = serialize($setup); 
	//session_start();
	$_SESSION['stack']=$stack;
	modeventsHelper::setup_session_stack($org,$stack);
	$_GET = array();
	if ($debug) write_log_array($setup,"Initializing",__LINE__);
} 
//////////////////////////////////////////////////////////////////////////////
$datepicker = '   ';
if ($debug) write_log_array($setup,'$setup after check permissions.',__line__);
if ($debug) write_log_array($_POST,'$_POST before handle_command',__line__);
if (isset($_POST['delete'])){
	$setup = modeventsHelper::handle_file_delete($setup );
}
if (isset($_POST['command'])  ){ 	// or (isset($_FILES['extra'])) ){
	$setup = modeventsHelper::handle_command($setup ) ;
}
if ($debug) write_log_array($setup,'setup after handle_command.',__line__);
$states = array(
'AL'=>'AL','AK'=>'AK','AS'=>'AS','AZ'=>'AZ','AR'=>'AR','CA'=>'CA','CO'=>'CO','CT'=>'CT','DE'=>'DE','DC'=>'DC','FM'=>'FM','FL'=>'FL','GA'=>'GA','GU'=>'GU','HI'=>'HI','ID'=>'ID','IL'=>'IL','IN'=>'IN','IA'=>'IA','KS'=>'KS','KY'=>'KY','LA'=>'LA','ME'=>'ME','MH'=>'MH','MD'=>'MD','MA'=>'MA','MI'=>'MI','MN'=>'MN','MS'=>'MS','MO'=>'MO','MT'=>'MT','NE'=>'NE','NV'=>'NV','NH'=>'NH','NJ'=>'NJ','NM'=>'NM','NY'=>'NY','NC'=>'NC','ND'=>'ND','MP'=>'MP','OH'=>'OH','OK'=>'OK','OR'=>'OR','PW'=>'PW','PA'=>'PA','PR'=>'PR','RI'=>'RI','SC'=>'SC','SD'=>'SD','TN'=>'TN','TX'=>'TX','UT'=>'UT','VT'=>'VT','VI'=>'VI','VA'=>'VA','WA'=>'WA','WV'=>'WV','WI'=>'WI','WY'=>'WY');
//////////////////////////////////////////////////////////////////////////////
$next = $setup['action']." ".$setup['mode'];
switch(strtolower($setup['action']." ".$setup['mode'])){
	case 'add award':
		$awd_name_records = modeventsHelper::get_award_name_records($setup['org']);
		foreach($awd_name_records as $key=>$rec){
			$awd_names[$rec['award_name']] = $rec['award_name'];
		}		$awd_row = modeventsHelper::get_award_blank($setup);
		require(JModuleHelper::getLayoutPath('mod_events','newaward'));
		break;
	case 'add event':
		$evt_row = modeventsHelper::get_event_blank();
		$evt_row['event_name'] = "-- Enter the new event name here --";		
		$evt_row['event_type'] = "mtg" ;
		$evt_row['poc_id'] = $setup['user_id'];
		$evt_row['squad_no'] = $setup['org'];
		$evt_row['extras'] = array();		
		require(JModuleHelper::getLayoutPath('mod_events','newevent'));
		break;
	case 'add history';	 		
		//  $awd_row = modeventsHelper::get_award($setup['award_id']);
		require(JModuleHelper::getLayoutPath('mod_events','newobject'));
		break;
	case 'add location':
		require(JModuleHelper::getLayoutPath('mod_events','newlocation'));
		break;
	case 'add new_award':
		$awarded_by = modeventsHelper::get_award_sources();
		unset($awarded_by['national']);
		$awarded_to = modeventsHelper::get_award_types();
		unset($awarded_to['district']);
		if ($setup['org'] != ''){
			unset($awarded_by['district']);
			unset($awarded_to['squadron']);
		}
		$awd_name_records = modeventsHelper::get_award_name_records($setup['org']);
		foreach($awd_name_records as $key=>$rec){
			$awd_names[$rec['award_name']] = $rec['award_name'];
		}
		require(JModuleHelper::getLayoutPath('mod_events','awardnameform'));
		break;
	case 'change award':
		if ($orgType == 'any')
			$awards = modeventsHelper::get_awards("");
		else 
			$awards = modeventsHelper::get_awards($setup['org']);
		require(JModuleHelper::getLayoutPath('mod_events','listawards'));
		break; 
	case 'change event':
		$type = $params->get("type");
		if ($scope == 'future'){
			$events = modeventsHelper::get_some_events($setup['org'],array('all'));
		} else {
			$events = modeventsHelper::get_events($setup['org']);
		}	
		$layout = $params->get('layout', 'default');
		require(JModuleHelper::getLayoutPath('mod_events',$params->get('layout', 'default')));
		//listEvents($setup);
		break;
	case 'change history';
		$awards = modeventsHelper::get_objects($setup['org']);
		require(JModuleHelper::getLayoutPath('mod_events','listobjectsforupdate'));
		break;
	case 'change location':
		$locations = modeventsHelper::get_location_list($setup['org']);
		require(JModuleHelper::getLayoutPath('mod_events','listlocations'));
		break;
	case 'list award_list':
		$awards = modeventsHelper::get_awards($setup['org']);
		$alias = $params->get("award_display_alias"); 
		require(JModuleHelper::getLayoutPath('mod_events','listawardwlink'));
		break;
	case 'list event_list':
		if ($scope == 'future'){
			$type = $params->get("type");
			$events = modeventsHelper::get_some_events($setup['org'],$type);
			// $events = modeventsHelper::get_future_events($setup['org']);
		} else {
			$events = modeventsHelper::get_events($setup['org']);
		}	
		require(JModuleHelper::getLayoutPath('mod_events',$params->get('layout', 'default')));
		//updateEvent($setup);
		break;	
	case 'show award_show':
		$award = modeventsHelper::get_award($jinput->get('award_id'));
		require(JModuleHelper::getLayoutPath('mod_events','showaward'));
		break;
	case 'show event_documents':
		$type = $params->get("type");
		if ($scope == 'future'){
			$events = modeventsHelper::get_events_having_documents($setup['org'],array('all'));
		} else {
			$events = modeventsHelper::get_events_having_documents($setup['org']);
//			$events = modeventsHelper::get_conference_events($setup['org']);
		}	
		$nxt = $params->get('layout', 'default');
		require(JModuleHelper::getLayoutPath('mod_events',$params->get('layout', 'default')));
		break;
	case 'sort event_sort':
		if (isset($setup['display_by']))
			$display_by = $setup['display_by'];
		else 
			$display_by = 'date';
		$events = modeventsHelper::get_events_with_sort($display_by);
		require(JModuleHelper::getLayoutPath('mod_events','list_sorted_events'));
		break;
	case 'update award':
		$awd_name_records = modeventsHelper::get_award_name_records($setup['org']);
		foreach($awd_name_records as $key=>$rec){
			$awd_names[$rec['award_name']] = $rec['award_name'];
		}
		$awd_row = modeventsHelper::get_award($setup['award_id']);
		require(JModuleHelper::getLayoutPath('mod_events','updateaward'));
		break;
	case 'update event':
		$event_id = $setup['event_id'];
		$evt_row = modeventsHelper::get_event($event_id);
		require(JModuleHelper::getLayoutPath('mod_events','updateevent'));
		//updateEvent($setup);
		break;
	case 'update history':
		$awd_row = modeventsHelper::get_award($setup['award_id']);
		require(JModuleHelper::getLayoutPath('mod_events','updateobject'));
		break;
	case 'update location':
		$loc = modeventsHelper::get_location($setup['location_id']);
		require(JModuleHelper::getLayoutPath('mod_events','updatelocation'));
		break;
	case 'list event_show':
	default: die("No such action: "  );// .$_REQUEST['command']);
}



