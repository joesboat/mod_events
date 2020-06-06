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
$document = JFactory::getDocument();
$document->addStyleSheet(getSiteUrl()."/plugins/system/t3/base/bootstrap/css/bootstrap-responsive.css");
$document->addStyleSheet(getSiteUrl()."/templates/usps-site/css/bootstrap-datepicker3.css");
$document->addStyleSheet(getSiteUrl()."/templates/usps-site/css/bootstrap.css");
$document->addScript(getSiteUrl()."/plugins/system/t3/base/js/jquery-1.11.2.js");
$document->addScript(getSiteUrl()."/plugins/system/t3/base-bs3/bootstrap/js/bootstrap.js");
$document->addScript(getSiteUrl()."/templates/usps-site/js/bootstrap-datepicker.js");
?>
<style type="text/css">
.datepicker {
	background-color: #fff ;
	color: #333 ;
}
</style>
<?php	// We need an array with all of the expected data fields or we must rewrite showform()
	showHeader($setup['header'],$me,'',$datepicker);
?>	
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<h3>Create a New Event</h3>	
<?php 
	require(JModuleHelper::getLayoutPath('mod_events','eventform'));	
?>
	<br/>
	<input type="submit" name=command value="Add" />
	<br />
	<input type="submit" name="command" value="Return" />
	<br/>
<?php 	
	showTrailer();



