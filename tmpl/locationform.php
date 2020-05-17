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
//****************************************************************************
	$extra_order = array('reg','sch','spc');
?>
<p>Locatons are saved for future use! Suggest you review existing locations and reuse where possible.
</p>
<p>Please complete all fields.  Provide additional data to common locaton names.  As an example, use 'West Marine Rockville' instead of just 'West Marine'.  Assume those who want to attend will need assistance!  In addition to the address provide a telephone number and URL.   
</p>
	<table>
	<colgroup>
	<col width='125'><col width='400'><col width='125'><col width='400'>
	</colgroup>
	
	<tr><td>Event Location:</td>
	<td>
	<input type='text' name='location_name' size='40' maxlength='75' 
		value='<?php echo $loc['location_name']; ?>' />
	</td>
	<td>Location URL:</td>
	<td>
	<input type='text' name='location_url' size='40' maxlength='400' 
		value='<?php echo $loc['location_url']; ?>'/>
	</td></tr>
	<tr><td>Street Address:</td>
	<td>
	<input type='text' name='location_street' size='40' maxlength='75' 
		value='<?php echo $loc['location_street']; ?>' />
	</td>
	<td>City:</td>
	<td>
	<input type='text' name='location_city' size='40' maxlength='50' 
		value='<?php echo $loc['location_city']; ?>'/>
	</td>
	</tr>
	<tr>
	<td>Location State:</td>
	<td>
	<select name='location_state' name='<?php echo $loc['location_state']; ?> '  >
		<?php show_option_list($states,$setup['state']); ?>
	</select>
	&nbsp;&nbsp;&nbsp;&nbsp;
	Location ZIP Code:
	<input type='text' name='location_zip' size='10' 
		value='<?php echo $loc['location_zip']; ?>' />
	</td>
	<td>
	Telephone:
	</td>
	<td>
	<input type='text' name='location_phone' 
		value= '<?php echo $loc['location_phone'];?>' />
	</td>	
	</tr>
	<tr>		
	<td>Maximum Students:</td>
	<td>
	<input type='text' name='location_max_students' size='4' class='reqd' 
		value='<?php echo $loc['location_max_students']; ?>'/>
	</td></tr>
</table>         
<?php



?>