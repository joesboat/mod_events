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
	<h4>Change Data on an Existing Event</h4>
	<input type='hidden' name='event_id' 
		value='<?php echo $evt_row['event_id']; ?>'/>
	<p><?php echo $setup['error']; ?></p>	
	<p>Use the fields below to modify the squadron event.</p>

<?php
	require(JModuleHelper::getLayoutPath('mod_events','eventform'));
?>
	<br/>
	<input type="submit" name="command" value="Submit" /><br/>
	<input type="submit" name="command" value="Return" /><br/>
	<?php
	showTrailer();

?>