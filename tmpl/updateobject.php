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
	// $awd_row = modeventsHelper::get_award_blank();
	$awd_nm = $awd_row['award_name'];
	if ($awd_row['event_id'] == 0){
		$evt_row = modeventsHelper::get_event_blank();
		$evt_row['event_name'] = "-- Enter the new event name here --";		
		$evt_row['event_type'] = "mtg" ;
		$evt_row['poc_id'] = $setup['user_id'];
		$evt_row['squad_no'] = $setup['org'];
		$evt_row['extras'] = array();
	} else {
		$evt_row = modeventsHelper::get_event($awd_row['event_id']);
	}
	
	showHeader($setup['header'],$me,'',$datepicker);
?>	
	<input type="hidden" name="award_id" value="<?php echo $awd_row['award_id'];?>" />
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<h3><?php if (isset($setup['object'])) echo $setup['object'];?></h3>	
<?php 
	require(JModuleHelper::getLayoutPath('mod_events','objectform'));	
?>
	<br/>
	<input type="submit" name=command value="Submit" class="btn btn-primary btn-sm" title="This action will update the permanant record and return the form for additional changed. "/>
	<input type="submit" name="command" value="Return" class="btn btn-primary btn-sm" title="This action display the prior form.  No updates will be made. "/>
<br/>
<?php 	
	showTrailer();



