<?php
//****************************************************************************
// no direct access
defined('_JEXEC') or die('Restricted access');
	if ($loging) log_it("Starting - ",__FILE__);
	// Display results
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
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<input type="hidden" name = 'updated_by' value='<?php echo $username; ?>' />
	<input type="hidden" name = 'updated_date' value='<?php echo date("Y-m-d H:i:s") ?>' />

	<h3>Change Data on an Existing Award</h3>
	<input type='hidden' name='award_id' 
		value='<?php echo $awd_row['award_id']; ?>'/>
	<p><?php echo $setup['error']; ?></p>	
	<p>Use the fields below to modify the squadron award.</p>

<?php
	require(JModuleHelper::getLayoutPath('mod_events','awardform'));
?>
	<br/>
	<input type="submit" name="command" value="Submit" /><br/>
	<input type="submit" name="command" value="Return" /><br/>
	<?php 
	showTrailer();
?>