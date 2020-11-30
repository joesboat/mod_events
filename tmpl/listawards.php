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
	<h5>Add a New Award
		<input type='submit' name='command' value='New' id='SubmitButton' /></h5>
<!--	<h5>List of Awards</h5>-->
	<p>Select the award and then press an 
	<input type='submit' name='command' value='Update' id='SubmitButton' />
	 or 
	<input type='submit' name='command' value='Delete' id='SubmitButton' />
	 button to continue.</p>
	<div style="width:700px;height:300px;overflow:scroll;"> 
	<?php
	foreach($awards as $e_row) {
		if ($e_row['award_year'] != $yr){
			$yr = $e_row['award_year'];
			echo "<center><strong>".$e_row['award_year']."</strong></center>";
		}		
	?>
		<input type='radio' name='award_id' value='<?php echo trim($e_row['award_id']); ?>' / > 
		<?php 
			//echo $e_row['award_date']; 
			echo $e_row['award_year']." ";
			switch($e_row['award_source']){
				case 'squadron':
					echo "Sqdn. ";
					break;
				case 'district':
					echo "D5 ";
					break; 
				case 'national':
					echo "USPS ";
					break;  
			}
		?>
		<strong>
			<?php echo $e_row['award_name'] . " " . $e_row['award_place']; ?>
		</strong>
			<?php
				echo "&nbsp;-&nbsp;" ;
				switch($e_row['award_type']){
					case "squadron":
						echo modeventsHelper::get_squadron_name($e_row['award_to_squadron']);
						break;
					case "personal":
						echo modeventsHelper::get_member_name($e_row['award_to_member']);
						break;
					case "district":
						break;
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