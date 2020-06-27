<?php
/**
* @package Author
* @author Joseph P. (Joe) Gibson
* @website www.joesboat.org
* @email joe@joesboat.org
* @copyright Copyright (C) 2018 Joseph P. Gibson. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
*
* ListEventsForUpdate.php - Called from members only modules.  Provides 
*                           cotrols to initiate a change to an event record. 
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
	showHeader($setup['header'],$me);
	$yr = 1965;
?>
<script>
//***************************************************************
function submit_it(btn){
	// Called from several types of buttons
	// Builds new <form> using 'action' attribute from form 'fh1'
	// Organizes data into a new form with std. set of fields
	//		action = action from current form
	//		input names:
	//			value - contents of button 'value' field
	//			command - contents of button name field
var newF = document.createElement("form");
	// stop
var pForms = document.getElementsByTagName("form"); 
var fh1 = document.getElementById("fh1");
var obj, nm, vl;
	newF.action = fh1.action ;
	newF.method = 'POST'; 
	btna = btn.attributes;
	for (var val in btna) {
  		obj = btna.item(val);
  		nm = obj.name;
  		vl = obj.value;
  		if (nm == 'type') continue;
  		if (nm == 'onclick') continue;
  		new_input(newF,nm,vl);
	}
	//new_input(newF,"value",btn.id);
	//new_input(newF,"command",btn.name);
	document.getElementsByTagName('body')[0].appendChild(newF);
	newF.submit();
}
//***************************************************************
function new_input(f,nm,v){
// Called from get_window_dimensions to create an input element 
var i = document.createElement("input");
	i.name = nm;
	i.type = 'hidden';
	i.value = v;
	f.appendChild(i);
}
</script>
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<h4>View and Update Location Details
	<input type='submit' name='command' value='Locations'> </h4> 
	<h4>Add a New Event
	<input type='submit' name='command' value='New' id='SubmitButton' /></h4>

	<center><h4>Known Events</h4></center>
	<?php
	foreach($events as $e_row) {
		if (date("Y", strtotime($e_row['start_date'])) != $yr){
			$yr = date("Y", strtotime($e_row['start_date']));
			echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$yr</b><br /><br />";
		}
	?>
		<button 	
					command 	=	'update' 
					type		=	'button' 
					name		=	'command' 
					value		=	'update' 
					event_id	=	"<?php echo $e_row['event_id']; ?>" 
					onclick		=	"submit_it(this);"
					class		=	"btn btn-primary btn-sm form-control"
		>
				Update
		</button> 
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
	<?php
	showTrailer();



?>