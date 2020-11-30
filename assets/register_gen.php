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
$folder = __DIR__ ;
$item_file=__DIR__.'/'.$event_id."_items.txt"; 
$base = explode('/modules',JURI::base())[0];
$user = JFactory::getUser();
$member = ! $user->guest ;
$access = JAccess::getAuthorisedViewLevels($user->id);
$id = getGroupId('USPS Member');
$groups = $user->groups ;
$member = in_array($id,$groups);
if ($logging) log_it("event_id = $event_id");
$evt = $WebSites->getEvent($event_id,TRUE);
$loc = $WebSites->getLocationData($evt['location_id']);
$registrar = $vhqab->getD5Member($evt['registrar']);
$registrar_name = get_person_name($registrar);
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name=Generator content="Microsoft Word 11 (filtered)">
	<title>Event Registration</title>
	<style>
	.cboxElement {
		color:#336666;
	}
	.location {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 16px;		
		color:#000000;
	}

	</style>

</head>
<body onload='setsize(1100,880);'>
<div class='Section1' id='beni0'>
	<table id='t8' class='table table-bordered' >
	<colgroup>	
		<col id='1' style="width:250px;"/>
		<col id='2' style="width:550px;"/>
	</colgroup>
	<tr>
		<td colspan="2"><h3>Registration Instructions for:	<?php echo $evt['event_name']; ?> </h3>
		</td>
	</tr>
	<tr>
		<td style="text-align: right">
			Location:
		</td>
		<td>
			<?php echo $WebSites->getLocationName($loc,false);?>  
			<br/>
			<?php echo $loc['location_street']; ?>
			<br/>
			<?php echo $loc['location_city']; ?> 
			<?php echo $loc['location_state']; ?> 
			<?php echo $loc['location_zip']; ?> 
			<br/>
			<?php echo $loc['location_phone'];?>
		</td>
	</tr>
	<tr>
		<td colspan='2'>
There are two ways in which you can register for the Fall Conference.  Both provide
a registration <br />form with instructions and links to reserve a hotel room:
		</td>
	<tr>
		<td colspan="2">
			1.	Click on this button to initiate registration.  You may be asked to Log-in, 
			and then the 
			<br />interactive form will be displayed for you to complete.  Then submit it electronically to 			the 
			<br />conference organizers, and click on the link to the hotel located on the form to make 
			room reservations.  
			<br />Don’t forget to send a check to cover the cost of the Fall Conference.
		</td>
	</tr>
<?php 	
	if ( time() < strtotime($evt['reg_deadline']) ){
?>	
	<tr>
		<td style="text-align: right">
			Register on-line: 
		</td>
		<td>
			<form method="get" 
				action="<?Php
					if ($member)
						echo "$base/index.php/register"; 
					else
						echo "$base/index.php/home-reg"; 
					$str = 	"?event_id=".$evt['event_id']."&items=$item_file";
					echo $str;
				?>" >
			    <button type="submit">Register</button>
			    <input type="hidden" name="event_id" value="<?php echo $evt['event_id'];?>" />
			    <input type="hidden" name="items" value="<?php echo $item_file; ?>" />
			</form>
			<br />
			( If Needed - The Registration Instructions document <br />listed below provides additional information.)  
		</td>
	</tr>
<?php 
	}
?>
	<tr>
		<td colspan="2">
			2.	Click on this button to display the mail-in registration form, print a copy and fill it out, mail it and a check, <br />and follow the form's instructions to make your hotel room reservations.
		</td>
	</tr>	
	</tr>
	<tr>
		<td style="text-align: right">
			Form for submittal via US Mail: 
		</td>
		<td>
			<form 	method="get" 
					action="<?php 
						$lk = $evt['extras']['Registration']['application/pdf'];
						echo $lk;
					?>">
			    <button type="submit">Registration Form</button>
			</form>		
		</td>
	</tr>
	<tr>
		<td style="text-align: right">Check or Registration Form to:</td>
		<td>
		<?php
			echo $registrar_name."<br>";
			echo $registrar['address_1']." ".$registrar['address_2']."<br>";
			echo get_citystatezip_line($registrar)."<br>";
			echo $registrar['telephone'];
		?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right" >
			 Hotel <br>Registration:   
		</td>
		<td>
			<?php echo $WebSites->getLocationName($loc,false);?> <a  href="<?php echo $evt['location_event_url'];?>" target="_blank" >Hotel Reservations Link</a><br /> or contact the hotel at <?php echo $loc['location_phone'];?> and use the reservation code of <b><?php echo  $evt['location_event_code']; ?></b> to obtain the <b>$<?php echo $evt['location_room_rate'] ?></b> room rate.  
			  	
		</td>
	</tr>
	<tr>
		<td style="text-align: right">Other Event Documents:</td>
		<td>
			<table>
			<?php 
				//foreach($setup['doc_types'] as $key=>$type){
				//	if (! isset($evt_row['extras'][$key])) continue;
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
<?php 
$WebSites->close();
$vhqab->close();
