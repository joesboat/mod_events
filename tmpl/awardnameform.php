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
// Defines or displays a standard award 
$award_sources = modeventsHelper::get_award_sources($dbSource);
$award_types = modeventsHelper::get_award_types($dbSource);
$squadrons = modeventsHelper::get_squadron_list($dbSource);
$squadrons[6243] = "District 5";
// $officers = modeventsHelper::get_officer_list($setup['org'],$year );
if ($setup['org'] == 6243){
	$sqd = ""; 
} else {
	$sqd = $setup['org'];
}
//$members = modeventsHelper::get_members($sqd);
//$members[''] = "Select from List";
//$events = modeventsHelper::get_conference_events(6243);
//$events_list = modeventsHelper::get_events_list($events);
$setup['doc_types'] = modeventsHelper::get_doc_types($dbSource);
$awd_names = array(	"Kenneth Smith Seamanship Award"=>"Kenneth Smith Seamanship Award",
					"Prince Henry Award"=>"Prince Henry Award",
					"Caravelle Award"=>"Caravelle Award",
					"Henry E. Sweet Excellence Award"=>"Henry E. Sweet Excellence Award",
					"Commanders Trophy Advanced Grades Award"=>"Commanders Trophy Advanced Grades Award",
					"Commanders Trophy Electives Award"=>"Commanders Trophy Electives Award",
					"Workboat Award"=>"Workboat Award",
					""=>"Select a standard award of enter new in textbox!");
showHeader("Maintain Award List",$me);
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
<!-- Award Name -->
	<tr>
		<td>Special Award:</td>		
		<td>
			<input 	type="text" 
					name="award_name" 
					value="<?php echo ''; ?>" 
					style="width:400px;" 
					title="This field will only be recognized when a Standard Award Name has not been selected."
			/>
		</td>
	</tr>
	<tr>
		<td>Standard Award Name:</td>		
		<td>
			<select name='award_name' id='award_name' style="width:400px;">
<?php			
				show_option_list($awd_names,'');
?>			
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
<?php
			$awd_nm = "";
//			if  (! in_array($awd_row["award_name"],$awd_names))
//				$awd_nm = $awd_row["award_name"];
?>
		</td>
	</tr>
<!-- Award Citation -->
	<tr>
		<td>Award Citation: </td>
		<td>
			<TEXTAREA name='award_citation' rows='3' cols='50' ><?php echo '';?>
			</TEXTAREA><br/>
		</td>
	</tr>
<!--Awarded By-->
	<tr>
		<td>Award By: <br/>&nbsp;&nbsp;&nbsp;&nbsp;(Choose from list.)</td>
		<td>
			<select name="award_by" >
			<?php 
				foreach($award_sources as $key=>$value){
				$str = '<option value="' . $key . '"' ; 
//				if ($key == $awd_row['award_source']) $str .= " selected=$key " ; 
				$str .= ">" . $value . '</option>' ; 
				echo $str ;
				}
			?>				
			</select>
		</td>
	</tr>
<!--Awarded to-->
	<tr>
		<td>Award To: <br/>&nbsp;&nbsp;&nbsp;&nbsp;(Choose from list.)</td>
		<td>
			<select name="award_type" >
			<?php 
				foreach($award_types as $key=>$value){
				$str = '<option value="' . $key . '"' ; 
//				if ($key == $awd_row['award_type']) $str .= " selected=$key " ; 
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
			Organization:
		</td>
		<td>
			<select name='award_org' id='award_org' style="width:300px;">
<?php			
				show_option_list($squadrons,'6243');
?>			
			</select>
		</td>
	</tr>
<?php
	}
?>		
	</table>
	
	<input type='submit' name='command' value='Add' />
	<input type='submit' name='command' value='Modify' />
	<input type='submit' name='command' value='Delete' />
	
<?php
showTrailer();
