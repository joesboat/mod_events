<?php
//**************************************************************************
// no direct access
defined('_JEXEC') or die('Restricted access');
	$yr = 1965;
	if ($loging) log_it("Starting - ",__FILE__);
	showHeader($setup['header'],$me);
?>
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<h3>Add a New Award
	<input type='submit' name='command' value='New' id='SubmitButton' /></h3>

	<h3>List of Awards</h3>
	<p>Select the award and then press an 
	<input type='submit' name='command' value='Update' id='SubmitButton' />
	 or 
	<input type='submit' name='command' value='Delete' id='SubmitButton' />
	 button to continue.</p>
	<div style="width:400px;"> 
	<?php
	foreach($awards as $e_row) {
		if ($e_row['award_year'] != $yr){
			$yr = $e_row['award_year'];
			echo "<br/><center>".$e_row['award_year']."</center><br/>";
		}		
	?>
		<input type='radio' name='award_id' value='<?php echo trim($e_row['award_id']); ?>' / > 
		<?php 
			//echo $e_row['award_date']; 
			echo $e_row['award_year'];
		?>
		<strong>
			<?php echo $e_row['award_name'] . " " . $e_row['award_place']; ?>
		</strong>
			<?php 
				if ($setup['org'] == ''){
					echo "&nbsp;-&nbsp;" ;
					echo modeventsHelper::get_squadron_name($e_row['award_to_squadron']);
				}
			?>
		<br/> 
	<?php 
	}
	?>
	</br>
	</div>
	<input type='submit' name='command' value='Update' id='SubmitButton' /> 
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='submit' name='command' value='Delete' id='SubmitButton' />
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='submit' name='command' value='Registrations' id='SubmitRegistrations' />
	<?php
	showTrailer();

?>