<?php
/**
 * @package		Display logic for mod_show_d5_events 
 * @subpackage	singleline.php - Optional view to simply display date and event name.  
 * @copyright	Copyright (C) 2017 Open Source Matters & Joseph Gibson - All rights reserved. 
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_events/tmpl/vertical-1.css');
$year = 0;
?>
<style>
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
<!--Rank, Name, Grade-->
<h4 class='text-center'><?php echo $params->get('heading'); ?></h4>
<div id='evt_list' <?php if (isset($layout_height)) echo "style='height:$layout_height;'";?> >
	<?php
	foreach($events as $event){
			$s_date = $event['start_date'];
			if (substr($s_date,0,4) > $year){
				$year = substr($s_date,0,4);
				echo "<div align='center'><span>$year</span></div>";
			}
			$startDate = $event['date_obj'];
			$date = $event['date_rng'];
			// $name = $event['event_name_with_link'];
			$color = $event['color'];
			$squad = $event['squad_short_name'];
			$name = $event['event_name_with_modal'];
?>

<div itemscope itemtype="http://schema.org/Event">
	<div style="clear: both;" ></div>
	<div class="dp-upcoming-calendar" style="border-color:<?php echo $color; ?>">
		<div class="dp-upcoming-calendar-background" style="background-color:<?php echo $color; ?>">
		</div>
		<div class="dp-upcoming-text-month">
			<?php echo $startDate->format('M', true);?>
		</div>
		<div class="dp-upcoming-text-day" style="color: #<?php echo $color; ?>">
			<?php echo $startDate->format('j', true);?>
		</div>
	</div> 
	
	<p itemprop="startDate" content="<?php echo $startDate->format('c');?>">
    	<?php echo $date; ?>&nbsp;&nbsp;&nbsp;<?php echo $squad; ?>	
    	<br/>
       	<span itemprop="name"><?php echo $name ?></span>
	</p>
</div>	
	
<?php 
		} 
?>
</div>
<div align="right" >
	<span style="color:#ff0000;">Training Classes</span>
	<span style="color:#00ff00;">Meetings</span>
	<span style="color:#0000ff;">Cruises</span>

</div>
