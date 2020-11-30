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
	$awd_row = modeventsHelper::get_award_blank($setup);
	showHeader($setup['header'],$me);
	$setup['doc_types'] = modeventsHelper::get_doc_types();	
	$yr = 1965;
//	$doc = JFactory::getDocument();
//	$doc->addScript(JURI::base().'/scripts/JoesSlideShow.js');	
?>
<!--Uploaded Documents-->
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
		<center>
			<h3 title="">Add a new Historical Object</h3>
		</center>
<?php 
	if ($setup['error'] != ''){
?>
		<h3 style="color:red;font-size:14pt;">	
			<?php echo $setup['error']; ?>
		</h3>
<?php
		$setup['error'] = '';
	}
?>
	<table id='t8' class='table table-bordered' >
	<colgroup>
<!--		<col id='t8c1' />
		<col id='t8c2' />-->
	</colgroup>	
	<tr>
		<td colspan="2">
			Identify the <b>Name</b> and <b>Picture</b> of the item (object) you want entered into the historical section of the Awards Database.  The Picture will be uploaded and catalogued.  It will then be displayed on a page where you may add additional data about the item.  You may also then add additional pictures or documents that will be associated with this item.   
		</td>
	</tr>
	<tr>
		<td title="You must enter an estimate of the age of the item. " > 
			Award Year :
		</td>
		<td>
		<!--data-provide="datepicker"-->
			<input type="text" name="award_year" style="width:80px;" >
		</td>
	</tr>
	<tr>
		<td title="Suggest a simple descriptive name be used.  An example would be '1957 Memorials'.  This name must be unique for the award year.  If not a suffix will be added to make it unique.  You may add additional data in the next page displayed. ">Name of the new item: <br>&nbsp;&nbsp;(Plaque or Certificate)</td>		
		<td>
			<input type="text" name="award_name" style="width:400px;" title="Suggest a simple descriptive name be used.  An example would be '1957 Memorial'.  This name must be unique and if not a suffix will be added to make it unique.  You may add additional data in the next page displayed. " />
		</td>
	</tr>			
	<tr>
		<td title="You must provide a picture of this item (object). ">Picture of Item:</td>
		<td>
			<input type='file' name='extra' title="A picture is required.  It should be in JPG or PNG format sized as high definition (1024 x 768 pixls.).  However some other formats will be accepted.  Please contact webmaster if your format is rejected. " class="btn btn-primary btn-sm" />
			<br/>&nbsp;&nbsp;
		</td>
	</tr>

	</table>
	<h5>Add a Plaque
	<input type='submit' name='command' value='Add Plaque' id='SubmitButton' class="btn btn-primary btn-sm" title="Upload a picture of the Plaque.  A plaque is tyically a hard object or statue.  Suggest you select the best available picture.  You may add other pictures in the page dedicated to this Plaque."  /></h5>
	<h5>Add a Certificate
	<input type='submit' name='command' value='Add Certificate' id='SubmitButton' class="btn btn-primary btn-sm" title="Upload a picture of the Certificate.  A certificate is typically a printed document and is often framed for display.  You may add other pictures in the page dedicated to this Certificate." /></h5>
	<h5>Add an Event Picture
	<input type='submit' name='command' value='Add Photograph' id='SubmitButton' class="btn btn-primary btn-sm" title="Upload a picture.  You may add other pictures in the page dedicated to this Picture."/></h5>
	<h5>Add a Memorial Certificate
	<input type='submit' name='command' value='Add Memorial' id='SubmitButton' class="btn btn-primary btn-sm" title="Upload a picture of the Memorial Object.  A memorial is typically an object dedicated to a member or group of members who have passed the bar.  You may add other pictures in the page dedicated to this Memorial."/></h5>
	<h5>Add a Charter Document
	<input type='submit' name='command' value='Add Charter' id='SubmitButton' class="btn btn-primary btn-sm" title="A Charter is typically a nice certificate printed when the squadron was formed.  It will often be the oldest item in the list.  You may add other pictures in the page dedicated to the Charter."/></h5>

	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />

	<center><h3>Known Historical Objects</h3></center>
	<br>
	<p>Select the object and press the Update or Delete button below.</p>
	<?php
	foreach($awards as $a_row) {
		//if (date("Y", strtotime($a_row['award_date'])) != $yr){
		//	$yr = date("Y", strtotime($e_row['start_date']));
		//	echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$yr</b><br /><br />";
		//}
	?>
		<button 	
					command =	'update' 
					type	=	'button' 
					name	=	'command' 
					value	=	"update" 
					award_id=	"<?php echo $a_row['award_id']; ?>" 
					object = 	"<?php echo $a_row['b_info']; ?>"
					onclick	=	"submit_it(this);"
					class="btn btn-primary btn-sm form-control"
				>
				Update
		</button> 
		<?php echo $a_row['award_year']; ?>
		&nbsp;&nbsp;
		<strong>
			<?php echo $a_row['award_name']; ?>
		</strong>
			<?php echo "&nbsp;&nbsp;&nbsp;".$a_row['award_type']; ?>
			<?php echo "&nbsp;&nbsp;&nbsp;".$a_row['b_use'];?>
			<?php echo "&nbsp;&nbsp;&nbsp;".$a_row['b_info'];?>
			<?php echo "&nbsp;&nbsp;&nbsp;".$a_row['b_type'];?>
		<br/> 
	<?php 
	}
	?>
	</br>
	<input type='submit' name='command' value='Update' id='SubmitUpdate'class="btn btn-primary btn-sm"  /> 
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='submit' name='command' value='Delete' id='SubmitDelete' class="btn btn-primary btn-sm" />
	&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	showTrailer();
?>