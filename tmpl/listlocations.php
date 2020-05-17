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
	showHeader($setup['header'],$me);
?>
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<h3>List of Locations</h3>
	<p>Select the Location Name and then press an 
	<input type='submit' name='command' value='Update' id='Submit1' />
	&nbsp;&nbsp; or &nbsp;&nbsp;
	<input type='submit' name='command' value='Delete' id='Submit2' />
	button to continue.</p>
<?php
	$ctr=0;
	foreach($locations as $location_id=>$location_name) {
?>
		<input type='radio' name='location_id' value='<?php echo $location_id; ?>' />&nbsp;
		<?php echo $location_name; ?>
		<br/>
<?php
	}
?>
	<br/><br/>
	<input type='submit' name='command' value='Update' id='submit3' />
	&nbsp;&nbsp; or &nbsp;&nbsp;
	<input type='submit' name='command' value='Delete' id='submit4' />
	<br/><br/>
<?php 
	showTrailer(true);
?>