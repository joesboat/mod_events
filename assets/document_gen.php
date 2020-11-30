<?php
$logging = false;
include($_SERVER['CONTEXT_DOCUMENT_ROOT']."/applications/setupJoomlaAccess.php");
$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites","local");
if ($logging) log_it("Entering ".__FILE__,__LINE__);
if (isset($_GET['event_id'])){
	$event_id = $_GET['event_id'];		
} else {
	exit;
}
if ($logging) log_it("event_id = $event_id");
$evt = $WebSites->getEvent($event_id,TRUE);
$loc = $WebSites->getLocationData($evt['location_id']);
$LocationName = $WebSites->getLocationName($loc,true);
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name=Generator content="Microsoft Word 11 (filtered)">
	<title>Event Details</title>
</head>
<body onload='setsize(900,880);'>
<div class='Section1' id='beni0'>
	<table id='t8' class='table table-bordered' >
	<colgroup>	
		<col id='1' />
		<col id='2' />
	</colgroup>
	<tr>
		<td>Event Name:</td>
		<td>
			<?php echo $evt['event_name']; ?> 
		</td>
	</tr>
	<tr>
		<td>Squadron:</td>
		<td>
			<?php echo $vhqab->getSquadronName($evt['squad_no'],true); ?> 	
		</td>
	</tr>
	<tr>
		<td>Location:</td>
		<td>
			<?php echo $LocationName;?>  
			<br/>
			<?php echo $loc['location_street']; ?>
			<?php echo $loc['location_city']; ?> 
			<?php echo $loc['location_state']; ?> 
			<?php echo $loc['location_zip']; ?> 
			<br/>
			<?php echo $loc['location_phone'];?>
		</td>
	</tr>
<!--Start Date & Time--> 	
	<tr>
		<td> Start Date & Time:
		</td>
		<td>
		<!--data-provide="datepicker"-->
			<?php echo $evt['start_date']; ?>
			<?php //echo $evt['start_time']; ?>
		</td>
	</tr>
	<tr>
		<td> End Date & Time:</td>
		<td>
			<?php echo $evt['end_date']; ?>
			<?php //echo $evt['end_time']; ?>
		</td>
	</tr>
<!-- Event Description -->
	<tr>
		<td>Event Description: </td>
		<td>
			<?php echo $evt['event_description'] ;?>
		</td>
	</tr>
	<tr>
		<td>EXCOM Member Point of Contact:</td>
		<td>
			<?php if ($evt['poc_id'] != '')
				echo $vhqab->getMemberNameAndRank($evt['poc_id'], true); ?>
		</td>
	</tr>
	<tr>
		<td>Event Documents:</td>
		<td>
			<table>
			<?php 
				foreach($evt['extras'] as $type=>$docs)
					foreach ($docs as $app=>$url){
					?>
					<tr>
						<td>
							<?php echo $type; ?>
						</td>
						<td>&nbsp;&nbsp;&nbsp;</td>
						<td>
							<!--<a href="<?php echo $site_url."/".$url; ?>" target="_blank">-->
							<a href="<?php echo $url; ?>" target="_blank">
								<?php echo $app; ?>
							</a>
						</td>
					</tr>	
					<?php
					}	 
			?>
			</table>
		</td>
	</tr>
	</table>
	</div>
</body>
</html>
