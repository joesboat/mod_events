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
	// We need an array with all of the expected data fields or we must rewrite showform()
	$evt_row = modeventsHelper::get_event_blank();
	$evt_row['event_name'] = "-- Enter the new event name here --";		
	$evt_row['event_type'] = "mtg" ;
	$evt_row['poc_id'] = $setup['user_id'];
	$evt_row['squad_no'] = $setup['org'];
	$evt_row['extras'] = array();
	showHeader($setup['header'],$me,'',$datepicker);
?>	
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<h3>Create a New Event</h3>	
<?php 
	require(JModuleHelper::getLayoutPath('mod_events','eventform'));	
?>
	<br/>
	<input type="submit" name=command value="Add" />
	<br />
	<input type="submit" name="command" value="Return" />
	<br/>
<?php 	
	showTrailer();



