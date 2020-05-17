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
	$yr = 1965;
?>
	<center><h4>Events with Documents</h4></center>
	<?php
	foreach($events as $e_row) {
		$name = $e_row['event_name_with_modal'];
		if (date("Y", strtotime($e_row['start_date'])) != $yr){
			$yr = date("Y", strtotime($e_row['start_date']));
			echo "<br>";
			//echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$yr</b><br /><br />";
		}
	?>
		<?php echo date("Y/m/d", strtotime($e_row['start_date'])); ?>
		<strong>
			<?php echo $name; ?>
		</strong>
			<?php echo "   ".$e_row['event_type']; ?>
		<br/> 
	<?php 
	}
	?>
	<?php



?>