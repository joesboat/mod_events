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
// $events = modeventsHelper::get_dist_or_squad_conference_events($setup['org']);
// $events_list = modeventsHelper::get_events_list($events);
	$year = modeventsHelper::get_display_year($setup['org']);
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
		$start_time=date("G:i:s",strtotime($evt_row['start_date']));
	}
	if ($evt_row['end_date']=="0000-00-00 00:00:00"){
		$end_date=$start_date;
		$end_time=$start_time;
	}else{
		$end_date=date("Y/m/d",strtotime($evt_row['end_date']));
		$end_time=date("G:i:s",strtotime($evt_row['end_date']));
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
	if ($setup['error'] != ''){
?>
		<h3 style="color:red;font-size:14pt;">	
			<?php echo $setup['error']; ?>
		</h3>
<?php
		$setup['error'] = '';
	}
?>
	<input type='hidden' name='squad_no' value="<?php echo $setup['org'];?>">
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
<!-- Extra Event Documents -->
	<tr>
		<td colspan="2">
			This form provides data about the <?php echo $setup['object'];?> shown in the picture.  It is a known Historical Object.  The provided picture can be replaced but not deleted.  Please make sure it is the best picture available to identify the <?php echo $setup['object'];?>.  A field is provided where you can add additional information about the <?php echo $setup['object'];?>, and the responsible members.  Also, controls are provided below where you can upload additional pictures you wish associated with this <?php echo $setup['object'];?>.  Note that you must give each picture a unique name.<br>  <br>
			Many <?php echo $setup['object'];?>s, Historical Objects, or other awards are associated with a Squadron Event where it was presented.  A field below identifies that event.  If blank you may select an event from the list of known events.  If the Squadron Event is not listed you may add the Event Name, date and type in a special fields below.  This will create the event record with minimum data and establish the relationship with this <?php echo $setup['object'];?>.  Other tools are available to refine data about an event.
			
		</td>
	</tr>
<!-- Award Year --> 	
	<tr>						<!--Award Year -->
		<td> 
			Award Year :
		</td>
		<td>
		<!--data-provide="datepicker"-->
			<select name="award_year" >
			<?php
				$dt = $year;
				while ($dt > ($year - 100)){
						echo "<option value='$dt' ";
					if ($dt == $awd_row['award_year']){
						echo " selected $dt " ;
					}
					echo ">$dt</option>";
					$dt -= 1; 					
				}
			?>
			</select>
		</td>
	</tr>			<!--Award Year -->
<!-- Object (Plaque or Certificate Name -->
	<tr>
		<td>Plaque or <br>Certificate Name:</td>		
		<td>
			<input type="text" name="special_award_name" value="<?php echo $awd_nm; ?>" style="width:400px;" title="Suggest a simple descriptive name be used.  An example would be '1957 Memorial'.  Then use the 'Description Field' to provide any needed background or identity. "/>
		</td>
	</tr>			<!-- Object (Plaque or Certificate Name -->
<!--Object's' Picture -->
	<tr>
		<td>Picture of <?php if (isset($setup['object'])) echo $setup['object'];?>: </td>
		<td>
			<?php 
				$obj = $setup['object'];
				if (! isset($awd_row['extras'][$obj])){
//				if (! isset($awd_row['extras'][$setup['object']])){
					echo "There's an error.  Please report to WEBMASTER";
				}
				$pic = $awd_row['extras'][$setup['object']];	
//				list($tp,$path) = each($pic);
				foreach($pic as $tp=>$path){
					echo "<img src='".$path."' width='400'>";
				}
				?>	
				<!--<img src='<?php echo $path; ?>' width='400'>-->
		</td>
	</tr>
<!-- Object's Description -->
	<tr>
		<td>Object's Description: </td>
		<td>
			<TEXTAREA name='award_citation' rows='3' cols='50' ><?php echo $awd_row['award_citation'];?>
			</TEXTAREA><br/>
		</td>
	</tr>			<!-- Object's Description -->
<!--Update the picture of this object -->
	<tr>
		<td title="Provide a picture of this object.  ">You may update <br>the <?php if (isset($setup['object'])) echo $setup['object'];?>'s picture:</td>
		<td>Document Type: <br/>
			<?php 
			$typ = array_search($setup['object'],$setup['doc_types'] ); 
			?>
			<input type='radio' name='doc_type' value='<?php echo $typ; ?>' checked >
				<?php echo $setup['doc_types'][$typ]; ?> 
			</input>
			<br/>
			<input type='file' name='extra' class="btn btn-primary btn-sm form-control" />
			<input type="submit" name="command" value="Submit" class="btn btn-primary btn-sm form-control"  />
			<br/><br/>
		</td>
	</tr>			<!--Update the picture of this object -->
<!-- Additional Pictures - Guidance -->
	<tr>
		<td colspan="2">
			Other items (pictures, documents or other objects) may be associated with the <?php echo $setup['object'];?>.  As an example there may be pictures of a member accepting the <?php echo $setup['object'];?> or a group of members with the <?php echo $setup['object'];?>.  Use the following controls to upload items.  <br><br>
		</td>
	</tr>			<!-- Guidance -->
<!--Additional Pictures of Object -->
<?php 
	if (count($awd_row['extras']) > 1)
		foreach($awd_row['extras'] as $nm=>$pic){
			if (strtolower($nm) == strtolower($setup['object'])) continue;
?>		
			<tr>
				<td>Picture of <?php echo $nm; ?>: </td>
				<td>
					<?php 
						// $pic = $awd_row['extras'][$setup['object']];	
						// list($tp,$path) = each($pic);
						foreach($pic as $tp=>$path){
							echo "<img src='".$path."' width='400'>";
						}						
					?>	
					<!--<img src='<?php echo $path; ?>' width='400'>-->
				</td>
			</tr>
<?php 
	}
?>
<!--Upload additional documents -->
	<tr>
		<td>Upload Award Documents:</td>
		<td>Document Type: <br/>
			<?php 
			$excludes = array('Schedule','Registration',$setup['object']);
			foreach($setup['doc_types'] as $key=>$type){  
				if ($key == 'spc') continue;
				if (in_array($type,$excludes)) continue;
				?>
				<input type='radio' name='doc_type' value='<?php echo $key; ?>'  >
					<?php echo $type; ?> 
				</input>
			<?php 						
			} ?>
			<br/>
			<input type='radio' name='doc_type' value='spc' class="form-control" >
				Special 
			</input>
			Type: <input type='text' name='doc_special' class="form-control" title="A special item name is entered here.  Make sure the special type is selected and enter the name of the additional item.  The name entered will appear in the left column by the uploaded picture.  Note that the name cannot include the '/' character.  Suggest minimum use of special characters. " /> 
			<br/><br/>
			<input type='file' name='add_pic' class="btn btn-primary btn-sm form-control" />&nbsp;
			<input type="submit" name=command value="Submit" class="btn btn-primary btn-sm form-control"  /> 
			<br/><br/>
		</td>
	</tr>
		
	</tr>			<!--Upload additional documents -->
<!-- Guidance -->
	<tr>
		<td colspan="2">
			This <?php echo $setup['object'];?> may be associated with a previously identified district or squadron event.  The list provided is a combination of your squadron's and District 5 events.  If this <?php echo $setup['object'];?> is associated with an event that event will be selected.  If not and the event is available just select it from this list of known events and leave the other Event Name field blank.  <br><br>
			If the event is not in this list leave the list set to 'Select from list.' and identify a new 'Event Name', 'Event Start Date' and 'Event Type' in fields provide.  This will create a new 'Squdron Event'.  You cannot create a new District 5 event.  We suggest that you name it as if it were a district event and notify a district officer to have it become a D5 event.  Note: You must enter all three fields.  Otherwise the submittal will be rejected.   	
		</td>
	</tr>			<!-- Guidance -->
<!--Optional Link to an Event -->
	<tr>
		<td>Object received at: </td>
		<td>
			Known Events:&nbsp;&nbsp;
			<select name='event_id' id='event_id' style="width:300px;" title="This list is a combination or district and your squadron's Conference events. Just select an existing event and press the 'Submit Button to create the association.">
				<?php  show_option_list($events_list,$evt_row['event_id']); ?>
			</select>
			<br />	
			Event Name:&nbsp;&nbsp;
			<input 	type='text' 
					name='new_event_name' 
					size='30' 
					class='reqd'
					title="Any data in this field will cause a selection in the list of events to be ignored.  This name will trigger creation of a new event if both the start date and event type are provided.  Otherwisw the submittal will be rejected and an error message returned. "
			/>
			Event Start Date:&nbsp;&nbsp;
			<input 
				type="text" 
				name="new_start_date"  
				class="datepicker"
				size='15'
				title="This field must be supplied if you are creating a new event.  Otherwise it is ignored. "
			/>
			Event Type:&nbsp;&nbsp;
			<select name="new_event_type" 
				title="This field must be supplied if you are creating a new event.  Otherwise it is ignored."
			
			>
			<?php
				$setup['options'][''] = "None Selected"; 
				foreach($setup['options'] as $key=>$value){
					if ($value == $setup['object']) continue;
					$str = '<option value="' . $key . '"' ; 
					if ($key == '') 
						$str .= ' selected ';	
					$str .= ">" . $value . '</option>' ; 
					echo $str ;
				}
			?>
			</select>
		</td>
	</tr>			<!--Optional Link to an Event -->
<!--Other Uploaded Documents-->
	<tr>
		<td><?php echo $setup['object'];?> Documents:
			<?php if (count($awd_row['extras'])-1 > 0){ ?>		
			<br/>&nbsp;&nbsp;&nbsp;&nbsp;
			Select document and press
			<br/>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="delete" value="Delete" title="This action will delete any documents (files) you have selected." class="btn btn-primary btn-sm form-control" />
			<?php }  ?>
		</td>
		<td>
			<table>
			<?php 
				$ct = 0;
				if (is_array($awd_row['extras'])) 
					foreach($awd_row['extras'] as $type=>$docs){
						// We do not show or allow the object's picture to be shown or removed
						if ($type == $setup['object']) continue ;
						
						foreach ($docs as $doc_typ=>$rel_file_name){
						$ct ++;
					?>
					<tr>
						<td>
							<input type="checkbox" 
									value="<?php echo $rel_file_name;?>" 
									name="delete_<?php echo $ct; ?>" 
									title="Select the file(s) you wish to remove and press the delete button. "
							/>&nbsp;&nbsp;&nbsp;
						</td>
						<td>
							<?php echo $type; ?>
						</td>
						<td>&nbsp;&nbsp;&nbsp;</td>
						<td>
							<a href="<?php echo $rel_file_name; ?>" target='_blank' ><?php echo $rel_file_name; ?></a>
						</td>
					</tr>	
					<?php
						}
					}	 
			?>
			</table>
		</td>
	</tr>			<!--Other Uploaded Documents-->
	</table>
<?php
