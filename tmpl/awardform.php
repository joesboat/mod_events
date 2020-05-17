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
//***************************************************************************
$award_sources = modeventsHelper::get_award_sources();
$award_types = modeventsHelper::get_award_types();
$squadrons = modeventsHelper::get_squadron_list();
$officers = modeventsHelper::get_officer_list($setup['org'],$year );
if ($setup['org'] == 6243){
	$sqd = ""; 
} else {
	$sqd = $setup['org'];
}
$members = modeventsHelper::get_members($sqd);
$members[''] = "Select from List";
$events = modeventsHelper::get_conference_events(6243);
$events_list = modeventsHelper::get_events_list($events);
$setup['doc_types'] = modeventsHelper::get_doc_types();
$awd_names = array(	"Kenneth Smith Seamanship Award"=>"Kenneth Smith Seamanship Award",
					"Prince Henry Award"=>"Prince Henry Award",
					"Caravelle Award"=>"Caravelle Award",
					"Henry E. Sweet Award"=>"Henry E. Sweet Excellence Award",
					"Commanders Trophy Advanced Grades Award"=>"Commanders Trophy Advanced Grades Award",
					"Commanders Trophy Electives Award"=>"Commanders Trophy Electives Award",
					"Workboat Award"=>"Workboat Award",
					""=>"Select a standard award of enter new in textbox!");
$awd_place = array(	""=>"",
					"- 2nd Place"=>"- 2nd Place",
					"- 3rd Place"=>"- 3rd Place" );
?>
		<script>
			$(function(){
		   $(".datepicker").datepicker({
			format: "yyyy/mm/dd",
			orientation: "bottom auto",
			autoclose:"TRUE",
			todayHighlight: true
    			});
			});
		</script>
	<table id='t8' class='table table-bordered' >
	<colgroup>	
<!--		<col id='t8c1' />
		<col id='t8c2' />-->
	</colgroup>

	<tr>
		<td>Award:</td> 
		<td></td> 
	</tr>
<!-- Award Year --> 	
	<tr>
		<td> 
			Award Year :
		</td>
		<td>
		<!--data-provide="datepicker"-->
			<select name="award_year" >
			<?php
				$dt = $year;
				while ($dt > ($year - 20)){
						echo "<option value='$dt'";
					if ($dt == $awd_row['award_year']){
						echo " selected=$dt" ;
					}
					echo ">$dt</option>";
					$dt -= 1; 					
				}
			?>
			</select>
		</td>
	</tr>
<!--Event Name-->
	<tr>
		<td>Awarded at Conference: </td>
		<td>
			<select name='event_id' id='event_id' style="width:300px;">
<?php
				show_option_list($events_list,$awd_row['event_id']);
?>
			</select>	
		</td>
	</tr>
<!-- Award Name -->
	<tr>
		<td>Standard Award Name:</td>		
		<td>
			<select name='award_name' id='award_name' style="width:400px;">
<?php			
				show_option_list($awd_names,$awd_row["award_name"]);
?>			
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<select name="award_place" id="award_place" style="width:120px;">
<?php				
				show_option_list($awd_place,$awd_row['award_place']);
?>
			</select>
<?php
			$awd_nm = "";
			if  (! in_array($awd_row["award_name"],$awd_names))
				$awd_nm = $awd_row["award_name"];
?>
		</td>
	</tr>
	<tr>
		<td>Special Award:</td>		
		<td>
			<input 	type="text" 
					name="special_award_name" 
					value="<?php echo $awd_nm; ?>" 
					style="width:400px;" 
					title="This field will only be recognized when a Standard Award Name has not been selected."
			/>
		</td>
	</tr>
<!--Award From-->
	<tr>
		<td>Award From: <br/>&nbsp;&nbsp;&nbsp;&nbsp;(Choose from list.)</td>
		<td>
			<select name="award_source" >
			<?php 
				foreach($award_sources as $key=>$value){
				$str = '<option value="' . $key . '"' ; 
				if ($key == $awd_row['award_source']) $str .= " selected=$key " ; 
				$str .= ">" . $value . '</option>' ; 
				echo $str ;
				}
			?>				
			</select>
		</td>
	</tr>
<!--Award Type-->
	<tr>
		<td>Award Type: <br/>&nbsp;&nbsp;&nbsp;&nbsp;(Choose from list.)</td>
		<td>
			<select name="award_type" >
			<?php 
				foreach($award_types as $key=>$value){
				$str = '<option value="' . $key . '"' ; 
				if ($key == $awd_row['award_type']) $str .= " selected=$key " ; 
				$str .= ">" . $value . '</option>' ; 
				echo $str ;
				}
			?>
			</select>
		</td>
	</tr>
<?php
	if ($setup['org'] == 6243 or $setup['org'] == 0){
?>
<!--Award to Squadron -->
	<tr>
		<td>
			Squadron Award to:
		</td>
		<td>
			<select name='award_to_squadron' id='lead_squadron' style="width:300px;">
<?php			
				show_option_list($squadrons,$awd_row["award_to_squadron"]);
?>			
			</select>
		</td>
	</tr>
<?php
	}
?>		
<!-- Award to Member -->
	<tr>
		<td>Member Award To:</td>
		<td>
			<select name="poc_id" >
				<?php 
					show_option_list($members, $awd_row['award_to_member']);
				?>
			</select>
		</td>
	</tr>
<!-- Award Citation -->
	<tr>
		<td>Award Citation: </td>
		<td>
			<TEXTAREA name='award_citation' rows='3' cols='50' ><?php echo $awd_row['award_citation'];?>
			</TEXTAREA><br/>
		</td>
	</tr>
<!--Award Documents -->
	<tr>
		<td>Award Documents:
			<?php if (count($awd_row['extras']) > 0){ ?>		
			<br/>&nbsp;&nbsp;&nbsp;&nbsp;
			Select document and press
			<br/>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="delete" value="Delete" />
			<?php }  ?>
		</td>
		<td>
			<table>
			<?php 
				$ct = 0;
				if (is_array($awd_row['extras'])) 
					foreach($awd_row['extras'] as $type=>$docs)
						foreach ($docs as $doc_typ=>$rel_file_name){
						$ct ++;
					?>
					<tr>
						<td>
							<input type="checkbox" 
									value="<?php echo $rel_file_name;?>" 
									name="delete_<?php echo $ct; ?>" 
							/>
						</td>
						<td>
							<?php echo $type; ?>
						</td>
						<td>&nbsp;&nbsp;&nbsp;</td>
						<td>
							<?php echo $rel_file_name; ?>
							<br />
							<img src='<?php echo $rel_file_name; ?>' width='400'>
						</td>
					</tr>	
					<?php
					}	 
			?>
			</table>
		</td>
	</tr>
<!-- Upload Award Documents -->
	<tr>
		<td>Upload Award Documents:</td>
		<td>Document Type: <br/>
			<?php foreach($setup['doc_types'] as $key=>$type){  
				if ($key == 'spc') continue;
				?>
				<input type='radio' name='doc_type' value='<?php echo $key; ?>' >
					<?php echo $type; ?> 
				</input>
			<?php 						
			} ?>
			<br/>
			<input type='radio' name='doc_type' value='spc' >
				Special 
			</input>
			Type: <input type='text' name='doc_special' /> 
			<br/><br/>
			<input type='file' name='extra' />
			<br/><br/>
		</td>
	</tr>
	</table>
<?php
