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
	$loc = modeventsHelper::get_location_blank();
	$loc['squad_no'] = $setup['org'];
	$loc['location_name'] = "- - Enter Location Name Here - -";
	showHeader($setup['header'],$me);
?>
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<h3>Create a New Location</h3>
	<p>To add a new location fill in the fields below and select - Add. </p>
<?php
	require(JModuleHelper::getLayoutPath('mod_events','locationform'));	
?>
	<p>
	<input type='submit' name='command' value='New' />
	</p>
<?php
	showTrailer();




