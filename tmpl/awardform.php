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
$members = modeventsHelper::get_members($setup['org']);
$members[''] = "Select from List";
$events = modeventsHelper::get_dist_or_squad_conference_events($setup['org']);
$events_list = modeventsHelper::get_events_list($events);
$setup['doc_types'] = modeventsHelper::get_doc_types();

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
		<td title="Specify the Conference or Change of Watch where the award was presented. Use one of the district or squadron 'Events' tools if the event is not in this list.">
			Awarded at Conference or Change of Watch: 
		</td>
		<td>
			<select name='event_id' id='event_id' style="width:300px;" ">
<?php
				show_option_list($events_list,$awd_row['event_id']);
?>
			</select>	
		</td>
	</tr>
<!-- Award Name -->
	<tr>
		<td title="Select an award name from this list.  Use the 'New Name' button below to add a Standard Award name to this list. Use the Special Award field below to identify a unique (one time) award. " >
			Standard Award Name:
		</td>		
		<td>
			<select name='award_name' id='award_name' style="width:400px;" >
<?php			
				show_option_list($awd_names,$awd_row["award_name"]);
?>			
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<select name="award_place" id="award_place" style="width:120px;" title="Leave blank for 1st place awards." >
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
<?php 
	if ($next == 'add award'){
?>
	<tr>
		<td title="Suggest you only use this tools to identify awards presented each year.  Otherwise use the Special Award field below. ">
			New Standard Award		
		</td>
		<td>
			You may use the <input 	type="submit" 
									name=command 
									value="New Name"
									title="Suggest you only use this tools to identify awards presented each year.  Otherwise use the Special Award field below. "
									 /> tool.  
		</td>
	</tr>
<?php		
	}
?>
	<tr>
		<td title="Special awards are rare. This field will only be recognized when a Standard Award Name has not been selected.">Special Award:</td>		
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
		<td title="Most starndard awards are from the district.  Identify the organization level that presented the award. ">Award From: <br/>&nbsp;&nbsp;&nbsp;&nbsp;(Choose from list.)</td>
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
		<td title="Most district awards are presented to a squadron.  Most squadron awards are presented to a member.">
			Award Type: <br/>&nbsp;&nbsp;&nbsp;&nbsp;(Choose from list.)
		</td>
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
		<td title="List should have all members of the district or your squadron.  Missing names should be reported to the orginization's secretary. ">
			Member Award To:
		</td>
		<td>
			<select name="award_to_member" title="List should have all members of the district or your squadron.  Missing names should be reported to the orginization's secretary. ">
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
			<TEXTAREA name='award_citation' rows='3' cols='50' ><?php echo $awd_row['award_citation'];?></TEXTAREA><br/>
		</td>
	</tr>
<!--Award Documents -->
	<tr>
		<td title="This section displays documents associated with this award.   ">
			Award Documents:
<?php 
			if (count($awd_row['extras']) > 0){
?>		
				<br/>&nbsp;&nbsp;&nbsp;&nbsp;
				Select document and press
				<br/>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="delete" value="Delete" />
<?php 
			}  
?>
		</td>
		<td title="This section displays documents associated with this award."  >
			<table>
			<?php 
				$ct = 0;
				if (is_array($awd_row['extras'])) 
					foreach($awd_row['extras'] as $type=>$doc){
						$url = getSiteUrl()."/php/get_doc.php?item=".$doc['id'];
						$ct ++;
					?>
					<tr>
						<td>
							<input type="checkbox" 
									value="<?php echo $url;?>" 
									name="delete_<?php echo $ct; ?>" 
							>
						</td>
						<td>
							<?php echo $type; ?>
						</td>
						<td>&nbsp;&nbsp;&nbsp;</td>
						<td>
							<?php echo $url; ?>
							<br />
<?php
							switch($doc['type']){
								case "application/pdf":
									?><object 
												data='<?php echo $url; ?>' 
												type='application/pdf' 
												width='400px'
												height="360px"
											></object> 
<?php
									break;
								default: 
?>
									<img src='<?php echo $url; ?>' width='400'>
<?php 									
							}
?>
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
		<td>
			Upload Award Documents:
		</td>
		<td>
			Document Type: <br/>
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
