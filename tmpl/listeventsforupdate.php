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
	showHeader($setup['header'],$me);
	$yr = 1965;
?>
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<h4>View and Update Location Details
	<input type='submit' name='command' value='Locations'> </h4> 
	<h4>Add a New Event
	<input type='submit' name='command' value='New' id='SubmitButton' /></h4>

	<center><h4>Known Events</h4></center>
	<p>Select the event and then press an 
	<input type='submit' name='command' value='Update' id='SubmitButton' />
	 or 
	<input type='submit' name='command' value='Delete' id='SubmitButton' />
	 button to continue.</p>
	<?php
	foreach($events as $e_row) {
		if (date("Y", strtotime($e_row['start_date'])) != $yr){
			$yr = date("Y", strtotime($e_row['start_date']));
			echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$yr</b><br /><br />";
		}
	?>
		<input type='radio' name='event_id' value='<?php echo $e_row['event_id']; ?>' / > 
		<?php echo date("Y/m/d", strtotime($e_row['start_date'])); ?>
		<strong>
			<?php echo $e_row['event_name']; ?>
		</strong>
			<?php echo "   ".$e_row['event_type']; ?>
<!--		<?php if ($e_row['register_online']) { 
			$event_id =$e_row['event_id']; ?>
			<a href='<?php echo "http://127.0.0.1/uspsd5/index.php/reg-maint?event_id=$event_id"?>'
				target="_top" class="button">
				Register						
			</a>
			<?php } ?>-->
		<br/> 
	<?php 
	}
	?>
	</br>
	<input type='submit' name='command' value='Update' id='SubmitButton' /> 
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='submit' name='command' value='Delete' id='SubmitButton' />
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='submit' name='command' value='Registrations' id='SubmitRegistrations' />
	<?php
	showTrailer();



?>