<?php
//****************************************************************************
// no direct access
defined('_JEXEC') or die('Restricted access');
	// We need an array with all of the expected data fields or we must rewrite showform()
	if ($loging) log_it("Starting - ",__FILE__);
	$awd_row = modeventsHelper::get_award_blank();
	$awd_row['award_name'] = "";
	$awd_row['award_type'] = "squadron";
	$awd_row['award_source'] = "district";
	$awd_row['poc_id'] = $setup['user_id'];
	$awd_row['squad_no'] = $setup['org'];
	$awd_row['extras'] = array();
	$awd_row['award_citation'] = '';
	showHeader($setup['header'],$me,'',$datepicker);
?>	
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<input type="hidden" name = 'entered_by' value='<?php echo $username;?>' />
	<input type="hidden" name = 'entered_date' value='<?php echo date("Y-m-d H:i:s")?>' />
	<h3>Enter Data about the Award</h3>	
<?php
	require(JModuleHelper::getLayoutPath('mod_events','awardform'));
?>
	<br/>
	<input type="submit" name=command value="Add" />
	<br />
	<input type="submit" name="command" value="Return" />
	<br/>
<?php 	
	showTrailer();
?>