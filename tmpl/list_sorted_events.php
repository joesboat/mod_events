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
defined('_JEXEC') or die('Restricted access' );
$doc = JFactory::getDocument();
$doc->addScript("scripts/JoesSlideShow.js");
$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB");
$WebSites = JoeFactory::getLibrary("USPSd5dbWebSites",'local');
$evts = $WebSites->getEventsObject();
$locs = $WebSites->getLocationsObject();
$crs = $WebSites->getCoursesObject();
$sqds = $vhqab->getSquadronObject();
$mbrs = $vhqab->getD5MembersObject();
$title = "Boating Course and Seminar Schedules";
$states = array('DC'=>'District of Columbia',
				'DE'=>'Delaware',
				'MD'=>'Maryland',
				'NJ'=>'New Jersey',
				'PA'=>'Pennsylvania',
				'VA'=>'Virginia');
showHeader($title,'');
$lst_by = $evts->display_by["$display_by"];
?>
<div class='style10b' id='Layer2'>
<table width='770' border='1' cellpadding='0'	cellspacing='0'	bordercolor='#CCCCCC'>
<!--Date --><!--Class Description & Location --><!--Squadron    Phone  --><!--Contact --><!--Phone -->
	<colgroup>
		<col width='45' /><col width='155' /><col width='95' /><col width='100' /><col width='50' />
	</colgroup>
	<tr>
		<td height='10' colspan='5' 
			bgcolor='#FFFFFF' class='style16b'><div align='center' class='style22'>

			<span class='style16b'>
				<br>
				<?php echo $lst_by; ?>
			</span>
			<br />
<?php	
			foreach($evts->display_by as $key=>$value){
				if ($display_by != $key){
?>
					<input 	type='button' name='display_by' 
							value='<?php echo $value; ?>' 
							id='<?php echo $key;?>'  
							onclick="submit_it(this);">
<?php
				}
			}
?>
		</td>
	</tr>
<?php 
	$this_year = $event_name = $state = $squad_no = '';
	foreach ($events as $event){
		$squadron = $sqds->get_record('squad_no',$event['squad_no']);
		$squad_name_with_link = $vhqab->getSquadronName($event['squad_no'],true);
		$contact = $mbrs->get_mbr_record($event['poc_id']);
		$start_date = strtotime($event['start_date']);
		$end_date = strtotime($event['end_date']);
		switch($display_by){	
			case 'name':
?>
				<tr>
					<td height='10' colspan='5' bgcolor='#FFFFFF' class='style16b'>
						<div align='center' class='style22'>
							Date field may contain additional course data and online registration. 
						</div>
					</td>
				</tr>
<?php 			
				if ($event_name != $event['event_name']){
					$event_name = $event['event_name'];
					$course = $crs->get_record('course_id',$event['course_id']);
					show_blank_line();
					show_title_line($crs->get_course_name_with_link($course));
					show_heading_line("Squadron","Location / Address");
				}
				$link = $event['event_name_url'];
				if ($event['usps_id'] != '')
					$link .= "&usps_id=".$event['usps_id'];
				show_blank_line();				
?>				
				<tr bgcolor='#DFFFFF'>
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<a target='_blank' href='<?php echo $link;?>'> 
								<?php echo get_date_range($event);?> 
							</a>
						</div>
					</td>
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<span class='style14b'>
								<?php echo $locs->getLocationName($event['location_id'],1);?>
							</span>
							<br/>
							<?php echo $locs->get_full_address($event['location_id'],true);?>
						</div>
					</td>
					<td height='25' valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='center'>
							<?php echo $sqds->get_web_or_our_data($squadron);?>
						</div>
					</td>	
					<!--display event contact -->
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<?php echo $vhqab->getMemberName($event['poc_id'],true); ?>
						</div>
					</td>
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='center'>
							<?php echo $vhqab->getMemberPhone($event['poc_id']); ?>
						</div>
					</td>
				</tr>
<?php 				
				break;
			case 'location':
				if ($event['location_state'] != $state){
					$state = $event['location_state'];
					show_blank_line();
					show_title_line($states[$state]);
					show_heading_line("City");
				}
				show_blank_line();
?>
				<tr bgcolor='#DFFFFF'>
					<!--display event date -->
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<?php echo get_date_range($event);?>
						</div>
					</td>
					<!--display event name w/ link to page showing more data--> 	
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<span class='style14b'>
								<?php echo get_event_name_with_link($event);?>
							</span>
<?php 							
							if ($event['location_id'] != 0){
								echo "<br/>";
								echo $locs->getLocationName($event['location_id'],1);
							}
?>
						</div>
					</td>	
					<!--display squadron name as a link to squadron web site.-->
					<td height='25' valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='center'>
							<?php echo $squad_name_with_link;?>

						</div>
					</td>
					<!--display event contact phone number-->
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<?php echo $vhqab->getMemberName($event['poc_id'],true);?>
						</div>
					</td>
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='center'>
							<?php echo $vhqab->getMemberPhone($event['poc_id']);?>
						</div>
					</td>
				</tr>
<?php 
				break;
			case 'squadron':
				if ($event['squad_no'] != $squad_no){
					$squad_no = $event['squad_no'];
					show_blank_line();
					show_title_line($sqds->get_web_or_our_data($squadron));
					show_heading_line("Address");
				}
				
				
				
				
				
				show_blank_line();
?>
				<tr bgcolor='#DFFFFF'>

					<!--display event date -->
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<?php echo get_date_range($event);?>
						</div>
					</td>
					<!--display event name w/ link to page showing more data--> 	
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<span class='style14b'>
								<?php echo get_event_name_with_link($event); ?>
							</span>
<?php	
							if ($event['location_id'] != 0){
								echo "<br/>";
								echo $locs->getLocationName($event['location_id'],1);
							}
?>
						</div>
					</td>	
					<!--display squadron name as a link to squadron web site.-->
					<td height='25' valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='center'>
							<?php echo $squad_name_with_link;?>
						</div>
					</td>
					<!--display event contact phone number-->
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<?php echo $vhqab->getMemberName($event['poc_id'],true); ?>
						</div>
					</td>	
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='center'>
							<?php echo $vhqab->getMemberPhone($event['poc_id']); ?>
						</div>
					</td>
				</tr>
<?php
				break;		
			case 'date':
			case 'seminars':
			case 'classes':
			default:
				if (date('Y',strtotime($event['start_date'])) != $this_year){
					$this_year = date('Y',strtotime($event['start_date']));
					show_blank_line();
					show_title_line($this_year);
					show_heading_line('Squadron');
				}
				show_blank_line();
?>
				<tr bgcolor='#DFFFFF'>
					<!--display event date--> 
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<?php echo get_date_range($event); ?>
						</div>
					</td>
					<!--display event name w/ link to page showing more data--> 	
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<span class='style14b'>
								<?php echo get_event_name_with_link($event);?>
							</span>
<?php 
							if ($event['location_id'] != 0){
								echo "<br/>";	
								echo $locs->getLocationName($event['location_id'],1);
							}
?>
						</div>
					</td>	
					<!--display squadron name as a link to squadron web site.-->
					<td height='25' valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='center'>
							<?php echo $squad_name_with_link; ?>
						</div>
					</td>
					<!--display event contact phone number-->
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='left'>
							<?php echo $vhqab->getMemberName($event['poc_id'],true); ?>
						</div>
					</td>	
					<td valign='middle' bgcolor='#DFFFFF' class='style12b'>
						<div align='center'>
							<?php echo $vhqab->getMemberPhone($event['poc_id']); ?>
						</div>
					</td>
				</tr>
<?php 
		}
	}
?>
	</table></div>
<?php
	
//*************************************************************************
function get_event_name_with_link($event, $base=''){
	$str = $window = "";
	if ($base!='')
		$window = " target='_blank' ";
	$xxx = $event['event_name_url'];
	if ($event['event_name_url']==''){
		$str .= $event['event_name'];
		return $str;
	}
	if (strtolower(substr($event['event_name_url'],0,7)) != 'courses'){
		if (strtolower(substr($event['event_name_url'],0,4)) == 'http')
			$link = $event['event_name_url'];	// absolute link 
		else
			$link = $base . $event['event_name_url'];  // relative link
		$str .= "<a href='".$link."' ".$window.">";
		$str .= $event['event_name'];
		$str .= "</a>";
		return $str;
	}
	if (strtolower(substr($event['event_name_url'],0,7)) == 'courses'){
		$link = $base . $event['event_name_url']; 
		if (isset($event['usps_id']) and $event['usps_id']!=''){
			$link .= "&usps_id=".$event['usps_id'];
		}
		$str .= "<a href='".$link."' ".$window.">";
		$str .= $event['event_name'];
		$str .= "</a>";
		return $str;
	}
	
	return $str;
}
//*************************************************************************
function show_blank_line(){
?>
	<tr bgcolor='#FFFFFF' class='style12b'>
		<td height='10'><div align='center'></div></td>
		<td class='style12b'><div align='center'></div></td>
		<td class='style12b'><div align='center'></div></td>
		<td class='style12b'></td><td class='style12b'><div align='center'></div></td>
	</tr>
<?php
}
//*************************************************************************
function show_heading_line($column, $normal = "Class Description / Location"){
?>
	<tr bgcolor='#99CCCC'>
		<td class='style14b'>
			<div align='center' class='style21'>
				Date
			</div>
		</td>
		<td class='style14b'>
			<div align='center' class='style21'>
				<?php echo $normal;?>
			</div>
		</td>
		<td height='29'>
			<div align='center' class='style14b style21'>
				<?php echo $column;?>
			</div>
		</td>
		<td class='style14b'>
			<div align='center' class='style21'>
				Contact
			</div>
		</td>
		<td class='style14b'>
			<div align='center' class='style21'>
				Phone
			</div>
		</td>
	</tr>
<?php
}
//*************************************************************************
function show_title_line($name){
?>
    <tr>
    	<td height='10' colspan='5' bgcolor='#FFFFFF' class='style16b'>
    		<div align='center' class='style22'>
    			<?php echo $name; ?>
    		</div>
    	</td>
    </tr>
<?php 
}

