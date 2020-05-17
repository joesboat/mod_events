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
	showHeader($setup['header'],$me);
?>	
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<input type='hidden' name='location_id' 
		value='<?php echo $loc['location_id']; ?>' />
	<h3>Change Data on an Existing Location</h3>
	<?php 
	require(JModuleHelper::getLayoutPath('mod_events','locationform'));	
	?>
	<p>
	<input type='submit' name='command' value='Submit' />
	</p>
	<?php 
	showTrailer(true);
