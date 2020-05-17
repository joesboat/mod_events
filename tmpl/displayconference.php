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
	$setup['doc_types'] = modeventsHelper::get_doc_types(); 
	// Display results
	showHeader($params->get('heading'),$me,'',$datepicker);
	$setup['contacts'] = modeventsHelper::get_officer_list($setup['org'],$year );
	$locations = modeventsHelper::get_location_list($org);
	if ($evt_row['start_date']==""){
		$start_date=date("Y/m/d");
		$start_time="19:00:00";
	}else{
		$start_date=date("Y/m/d",strtotime($evt_row['start_date']));
		$start_time=date("G:i:s",strtotime($evt_row['start_date']));
	}
	if ($evt_row['end_date']==""){
		$end_date=date("Y/m/d");
		$end_time="19:00:00";
	}else{
		$end_date=date("Y/m/d",strtotime($evt_row['end_date']));
		$end_time=date("G:i:s",strtotime($evt_row['end_date']));
	}	
	// modeventsHelper::get_event_types()[$evt_row['event_type']]
	if ($setup['org'] == 6243){
		$squadrons = modeventsHelper::get_squadron_list();
		$squadrons['6243'] = "M&R Committee";
	}
?>
		<script>
			$(function(){
		   $(".datepicker").datepicker({
			format: "yyyy/mm/dd",
			orientation: "bottom auto",
			autoclose:"TRUE",
			todayHighlight: true
    			});
			});
		</script>
	<input type="hidden" name="issetup" value="0" />
	<input type="hidden" name="org" value="<?php echo $org;?>" />
	<input type='hidden' name='event_id' value='<?php echo $evt_row['event_id']; ?>'/>
	<h4>
		<?php echo $evt_row["event_name"]; ?>
		<small>
			<?php echo modeventsHelper::get_event_types()[$evt_row['event_type']];?> held at <?php echo $locations[$evt_row["location_id"]] ?> <?php echo $start_date; ?>, through <?php echo $end_date; ?> 
		</small>
	</h4>
	<p>
		<?php echo $evt_row['event_description'];?>
		hosted by <?php echo $squadrons[$evt_row["lead_squadron"]]; ?>
	</p>
	<p>EXCOM Member Point of Contact: <?php echo modeventsHelper::get_member_name($evt_row['poc_id']);?></p>
	<p>
		Conference Minutes:
		<ul>
			<li> Submitted by:  Link to File</li>
		</ul>
		Resolutions:
		<ul>
			<li>Resolution Name: Link to File, Submitted By, Seconded By. </li>
		</ul>
		Presentations/Papers:
		<ul>
			<li>Name - 1st, 2nd, 3rd </li>
		</ul>		Pre-conference documents:
		<ul>
			<?php 
				$ct = 0;
				$tp = $li = '';
				if (is_array($evt_row['extras'])) 
					foreach($evt_row['extras'] as $type=>$docs)
						foreach ($docs as $doc_type=>$rel_file_name){
							$ct ++;
							if ($tp != $type ){
								$tp = $type;
								if ($li != '') echo "$li</li>" ;  
								$li = "<li>$tp: $rel_file_name";
							} else {
								$li .= ", $rel_file_name";
							}
						}	 
			?>
		</ul>
		Awards:
		<ul>
			<li>Award Name - 1st, 2nd, 3rd </li>
		</ul>
		
	</p>
	<br/>
	<?php
	showTrailer();

?>