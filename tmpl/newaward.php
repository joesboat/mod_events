<?php
//****************************************************************************
// no direct access
defined('_JEXEC') or die('Restricted access');
	if ($loging) log_it("Starting - ",__FILE__);
	showHeader($setup['header'],$me,'',$datepicker);
	if ($setup['error'] != ''){
?>
		<h3 style="color:red;font-size:14pt;">	
			<?php echo $setup['error']; ?>
		</h3>
<?php
		$setup['error'] = '';
	}
?>
<style type="text/css">
.datepicker {
	background-color: #fff ;
	color: #333 ;
}
</style>
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