<?php
/**
 * @package		Display logic for mod_show_d5_events 
 * @subpackage	default.php  View module for displaying front page event list.  
 * @copyright		Copyright (C) 2017 Open Source Matters & Joseph Gibson - All rights reserved. 
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHTML::_('behavior.modal');
$year = 0;
?>
<script type="text/javascript">
function callModal(url){
	
}
</script>
<style>
	.cboxElement {
		color:#336666;
	}
	.location {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;		
		color:#52CF0E;
	}
	.date {
		font-size: 12px;
		color:#52CF0E;
	}
	a.button {
	    -webkit-appearance: button;
	    -moz-appearance: button;
	    appearance: button;
	    text-decoration: none;
	    color: initial;
	}	
#evt_list {
	/*position:absolute;
	left:600px;
	top:80px;
	
	*/
	height:400px;
	width:250px;
	overflow:scroll;
	z-index:8;
}

</style>
<div id='evt_list' <?php if (isset($layout_height)) echo "style='height:$layout_height;'";?> >
<table style="width: 100%; " border='1' cellpadding='0'>
<?php
	foreach($events as $key=>$evt){
		if (substr($evt['start_date'],0,4) > $year){
			$year = substr($evt['start_date'],0,4);
?>
		<tr>
			<td colspan='3'>
				<h3 class='text-center'> <?php echo $year; ?> Events </h3>		
			</td>
		</tr>
<?php
		}
?>
		<tr>
			<td class='heading_height' colspan='3' >
				<div align='center' >
					<span >
						<?php echo $evt['event_name_with_modal']; ?>
						<?php
							if ($evt['register_online'] == 1){
								echo "<br />"; 
								echo $evt['register_modal'];
							}
							else {
								echo "<br />";
							}
						?>
					</span>
				<!--<br>-->
					<span class="location">
						<?php echo $evt['location_name']; ?>
					</span>
				<br>
					<span class="date">
						<?php echo $evt['date_str'].", ".$evt['time_str']; ?>
					</span>
				</div>
			</td>
		</tr>
<?php 			
		foreach ($evt['extras'] as $row_name=>$row_data ){
?>
		<tr>
			<td width='204' height='15' >
				<div  align="center" class="date" >
				<?php echo $row_name ?>
				</div>
			</td>
			<td width='54' align='center' >
<?php 
			if (isset($row_data['application/msword'])){ 
?>
				<div align='center'>
					<a href="<?php echo $row_data['application/msword']; ?>" target='_blank' class="date">
						DOC
					</a>
				</div>
<?php
			}
?>
			</td>
			<td width='54' align='center' >
<?php 
			if (isset($row_data['application/pdf'])){ 
?>
				<div align='center'>
					<a href="<?php echo $row_data['application/pdf']; ?>" target='_blank' class="date">
						PDF
					</a>
				</div>
<?php
			}
?>
			</td>
		</tr>
<?php
	}
}	
?>
<!--</ul>-->
<!--</form>-->
</table>
</div>
