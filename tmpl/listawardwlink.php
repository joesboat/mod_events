<?php
/**
* @package Author
* @author Joseph P. Gibson
* @website www.joesboat.org
* @email joe@joesboat.org
* @copyright Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
* @license GNU General Public License version 2 or laer; see LICENSE.txt
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
$yr = '1965';
$app = JFactory::getApplication(); // Access the Application Object
$mm = $app->getMenu(); // Load the JMenuSite Object
$act = $mm->getActive(); // Load the Active Menu Item as an stdClass Object
//if ($org != 'dist') echo "<input type='hidden' name='squad_no' value='$setup['squad_no']>"; 
if (count($awards) > 0 ){
?>
	<h3>List of Awards</h3>
<?php
}
	foreach($awards as $e_row) {
		//$link = "index.php?itemid=1351";
		$link = getSiteUrl()."/index.php/squadron-award";
		$link .= "?squad_no=".$e_row['award_to_squadron']; 
		$link .= "&award_id=".$e_row['award_id'];
		//$link .= "&command=show";
		if ($e_row['award_year'] != $yr){
			$yr = $e_row['award_year'];
			echo "<center>".$e_row['award_year']."</center>";
		}
	?>
		<a href="<?php echo $link; ?>">
		<strong>
			<?php echo $e_row['award_name'] . " " . $e_row['award_place']; ?>
		</strong>
		</a>
		<br/> 
	<?php 
	}
	?>
	</br>



