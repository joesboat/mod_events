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

$squadrons[6243] = "District 5";
if ($setup['org'] == 6243){
	$sqd = ""; 
} else {
	$sqd = $setup['org'];
}
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
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<input type="hidden" name = 'updated_by' value='<?php echo $username; ?>' />
	<input type="hidden" name = 'updated_date' value='<?php echo date("Y-m-d H:i:s") ?>' />
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
		<td>New Award Name:</td>		
		<td>
			<input 	type="text" 
					name="award_name" 
					value="<?php echo ''; ?>" 
					style="width:400px;" 
					title="This will be the new award name."
			/>
		</td>
	</tr>
	<tr>
		<td>Existing Award Names:</td>		
		<td>
			<select name='existing_names' id='existing_names' style="width:400px;" size='8' disabled>
<?php			
				show_option_list($awd_names,'',false);
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
		<td>Awarded By: <br/>&nbsp;&nbsp;&nbsp;&nbsp;(Choose from list.)</td>
		<td>
			<select name="awarded_by" >
			<?php 
//				foreach($awarded_by as $key=>$value){
//				$str = '<option value="' . $key . '"' ; 
//				if ($key == $awd_row['award_source']) $str .= " selected=$key " ; 
//				$str .= ">" . $value . '</option>' ; 
//				echo $str ;
//				}
				show_option_list($awarded_by,'',false);
			?>				
			</select>
		</td>
	</tr>
<!--Awarded to-->
	<tr>
		<td>Awarded To: <br/>&nbsp;&nbsp;&nbsp;&nbsp;(Choose from list.)</td>
		<td>
			<select name="awarded_to" size='2' >
			<?php 
//				foreach($awarded_to as $key=>$value){
//					$str = '<option value="' . $key . '"' ; 
//				if ($key == $awd_row['award_type']) $str .= " selected=$key " ; 
//					$str .= ">" . $value . '</option>' ; 
//					echo $str ;
//				}
				show_option_list($awarded_to,'squadron',false);
			?>
			</select>
		</td>
	</tr>
	</table>
	
	<input type='submit' name='command' value='Add' />
	<input type='submit' name='command' value='Return' />
	
<?php
showTrailer();
