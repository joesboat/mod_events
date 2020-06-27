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
	$setup['contacts'] = modeventsHelper::get_officer_list($setup['org'],$year );
	$setup['options'] = modeventsHelper::get_event_types();
	$setup['doc_types'] = modeventsHelper::get_doc_types();	
	$locations = modeventsHelper::get_location_list($org);
	$members = modeventsHelper::get_members('');
	$type = $evt_row['event_type'];
	if ($evt_row['start_date']=="0000-00-00 00:00:00"){
		$start_date=date("Y/m/d");
		$start_time="19:00:00";
	} else {
		$start_date=date("Y/m/d",strtotime($evt_row['start_date']));
		$start_time=date("H:i:s",strtotime($evt_row['start_date']));
	}
	if ($evt_row['end_date']=="0000-00-00 00:00:00"){
		$end_date=$start_date;
		$end_time=$start_time;
	}else{
		$end_date=date("Y/m/d",strtotime($evt_row['end_date']));
		$end_time=date("H:i:s",strtotime($evt_row['end_date']));
	}	
	if ($evt_row['reg_deadline']=="0000-00-00"){
		$reg_deadline = $start_date;
	} else {
		$reg_deadline=date("Y/m/d",strtotime($evt_row['reg_deadline']));
	}
	if ($evt_row['location_rate_deadline']=="0000-00-00"){
		$location_rate_deadline = $start_date;
	} else {
		$location_rate_deadline=date("Y/m/d",strtotime($evt_row['location_rate_deadline']));
	}
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
function on_file(){
var form = (document.getElementById("fh1"));
var file = document.getElementById('in_file');
var gross_name = file.value;
var a_gross = gross_name.split("\\");
var file_name = a_gross[a_gross.length-1];
var subTotalField = document.getElementById("subTotalField1");

}
		</script>
	<table id='t8' class='table table-bordered' >
	<colgroup>	
	</colgroup>
	<tr>
		<td>Select a location:</td>
		<td>
	   		<select name='location_id' style="width:300px;">
<?php
				show_option_list($locations,$evt_row["location_id"]);
?>
			</select>
	<br/><br/>View and Update Location Details <input type='submit' name='command' value='Locations'> 
	<br/>Create a new location: <input type='submit' name='command' value='New Location'>
		</td>
	</tr>

	<tr>
		<td>Event:</td> 
		<td></td> 
	</tr>
	<tr>
		<td>Event Name:</td>
		<td>
			<input type='text' name='event_name' size='50' class='reqd' 
					value="<?php 
						$val = $evt_row["event_name"];
						$val = htmlspecialchars($val,ENT_QUOTES);
						echo  $val; 
					?>"
			/>
		</td>
	</tr>
<!--Event Type-->
	<tr>
		<td>Event Type: <br/>&nbsp;&nbsp;&nbsp;&nbsp;(Choose from list.)</td>
		<td><select name="event_type" >
			<?php 
				foreach($setup['options'] as $key=>$value){
				$str = '<option value="' . $key . '"' ; 
				if ($key == $type) 
				$str .= ' selected ' ; 
				$str .= ">" . $value . '</option>' ; 
				echo $str ;
				}
			?>
			</select>
		</td>
	</tr>
<!--Start Date & Time--> 	
	<tr>
		<td> Start Date & Time:
			<br/>&nbsp;&nbsp;&nbsp;&nbsp;(Start Time of Event - "yyyy/mm/dd")
		</td>
		<td>
		<!--data-provide="datepicker"-->
			<input 
				type="text" 
				value="<?php echo $start_date; ?>"
				name="event_st_dt"  
				class="datepicker"
				size='15'
			/>
			<input 
				type='time' 
				name='event_st_tm' 
				size='15' 
				class='reqd' 
				value='<?php echo $start_time;?>'
			/>
		</td>
	</tr>
<!--//Finish Date & Time--> 	
	<tr>
		<td> End Date & Time:<br/>&nbsp;&nbsp;&nbsp;&nbsp;(Finish Time of Event - "yyyy/mm/dd")</td>
		<td>
			<input 
				type="text" 
				value="<?php echo $end_date; ?>"
				name="event_sp_dt"  
				class="datepicker"
				size='15'
			/ >
			<input 
				type='time' 
				name='event_sp_tm' 
				size='15' 
				class='reqd' 
				value='<?php echo $end_time; ?>'
			/>
		</td>
	</tr>
<!-- Event Description -->
	<tr>
		<td>Event Description: </td>
		<td>
			<TEXTAREA name='event_description' rows='3' cols='50' ><?php echo $evt_row['event_description'];?>
				
			</TEXTAREA><br/>
		</td>
	</tr>
	<tr>
		<td>EXCOM Member Point of Contact:</td>
		<td>
			<select name="poc_id" >
				<?php show_option_list($setup['contacts'],$evt_row['poc_id']); ?> 
			</select>
		</td>
	</tr>
<?php
	if ($setup['org'] == 6243){
	$squadrons = modeventsHelper::get_squadron_list();
	$squadrons['6243'] = "M&R Committee";
?>
<!--// Point of Contact-->

<!--Responsible Squadron -->
	<tr>
		<td>
			Lead Squadron:
		</td>
		<td>
			<select name='lead_squadron' id='lead_squadron' style="width:300px;">
<?php			
				show_option_list($squadrons,$evt_row["lead_squadron"]);
?>			
			</select>
		</td>
	</tr>

<!-- On Line Conference Registration -->	
	<tr>
		<td>
			Provide On-line Registration:
		</td>
		<td>
			Activate On-line Registration:&nbsp;&nbsp;&nbsp;
			<select name='register_online' id='register_online' style="width:200px;">
				<?php 
					$lst = array(0=>"No",1=>"Yes");
					show_option_list($lst,$evt_row['register_online']);
				?>
			</select><br>
			Identify Registrar:&nbsp;&nbsp;&nbsp;
			<select name="registrar" id='registrar' style="width:300px;">
				<?php 
					show_option_list($members ,$evt_row['registrar']);
				?>
			</select><br>
			Registration Deadline:&nbsp;&nbsp;&nbsp;
			<input 
				type="text" 
				value="<?php echo $reg_deadline; ?>"
				name="reg_deadline"  
				class="datepicker"
				size='15'
			/ >
			<br>
			Check Payable To:&nbsp;&nbsp;&nbsp;
			<input 	type="text" 
					name="reg_check_to" 
					value="<?php echo $evt_row['reg_check_to'];?>" /><br />
			Hotel Room Rate:&nbsp;&nbsp;&nbsp;$
			<input  type="text"
					name="location_room_rate"
					value="<?php echo $evt_row['location_room_rate']; ?>" 
					style="width:75px;" /><br />
			Hotel Reservation Code:&nbsp;&nbsp;&nbsp;
			<input 	type='text'
					name="location_event_code"
					value="<?php echo $evt_row['location_event_code']; ?>" 
					style="width:75px;" /><br/>
			Hotel Reservation Link:&nbsp;&nbsp;&nbsp;
			<input	type="text"
					name="location_event_url"
					value="<?php echo $evt_row['location_event_url']; ?> "
					style="width:500px;" /><br/>			
			Hotel Reservation Deadline:&nbsp;&nbsp;&nbsp;
			<input 
				type="text" 
				value="<?php echo $location_rate_deadline; ?>"
				name="location_rate_deadline"  
				class="datepicker"
				size='15'
			/ >	
			<br /> 
			<?php 
				if ($evt_row['event_name'] != "-- Enter the new event name here --"){
			?>
					<br />
					Select file containing meal list:  <input type='file' name='meal_list' oninput="on_file()" id="in_file" />			
					<br />
			<?php	
					// echo $evt_row['meal_setup_modal'];
				} 
			?>
		</td>
	</tr>	
<?php
	}
?>
<!-- Extra Event Documents -->
	<tr>
		<td>Upload Event Documents:</td>
		<td>Document Type: <br/>
			<?php 
			foreach($setup['doc_types'] as $key=>$type){  
			//$xxx = modeventsHelper::doc_types;
			//foreach($xxx as $key=>$type){  
				if ($key == 'spc') continue;
			?>
				<input type='radio' name='doc_type' value='<?php echo $key; ?>' >
					<?php echo $type; ?> 
				</input>
			<?php 						
			} 
			?>
			<br/>
			<input type='radio' name='doc_type' value='spc' >
				Special 
			</input>
			Type: <input type='text' name='doc_special' /> 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			This document is private!&nbsp;&nbsp;
			<input 	type="checkbox" name='doc_private' 
					title="Private documents will not be displayed on public pages! ">
			<br/><br/>
			<input type='file' name='extra' />
			<br/><br/>
		</td>
	</tr>
<!--Uploaded Documents-->
	<tr>
		<td>Event Documents:
			<?php if (count($evt_row['extras']) > 0){ ?>		
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
				if (is_array($evt_row['extras'])) foreach($evt_row['extras'] as $type=>$docs)
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
							<a target="_blank" href="<?php echo $rel_file_name; ?>">
							<?php echo $rel_file_name; ?>
							</a>
						</td>
					</tr>	
					<?php
					}	 
			?>
			</table>
		</td>
	</tr>
	</table>
<?php
