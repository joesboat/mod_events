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
	$yr = 1965;
?>
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>"  />

	<center><h4>Known Events</h4></center>

	<?php
	foreach($events as $e_row) {
		if (date("Y", strtotime($e_row['start_date'])) != $yr){
			$yr = date("Y", strtotime($e_row['start_date']));
			echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$yr</b><br /><br />";
		}
		$url = "index.php/".$params->get("display_alias")."?event_id=".$e_row['event_id'];
	?>
		<a href="<?php echo $url;?>">
		<?php echo date("Y/m/d", strtotime($e_row['start_date'])); ?>
		<strong>
			<?php echo $e_row['event_name']; ?>
		</strong>
		</a>
		<br/> 
	<?php 
	}
	?>
	</br>
	<?php
	showTrailer();



?>