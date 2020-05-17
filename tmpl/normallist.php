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
?>
<body>
<?php $year = 0; ?>
	<div id="page_body">
		<table class='table table-bordered table-hover table-condensed' >
			<colgroup>
			 	<col width='120'></col><!--Date Range-->
				<col width='280'></col><!--Event Description-->
				<col width='150'></col><!--Squadron-->
				<col width='200'></col><!--Contact-->
				<col width='120'></col><!--Telephone Number-->
			</colgroup>
			<tr class='header_row'>
		    	<th height="37" colspan="5" scope="col">
		    		<div align="center" class="style14b">
		    			<h4>What's Happening in Squadrons of District 5
		    			<br />
		    			Join in the Fun and Education </h4>
		    		</div>
		    	</th>
			</tr>
			<?php
			foreach($events as $event){
				$start_date = strtotime($event['start_date']);
				if (date('Y',$start_date) > $year){
					$year = date('Y',$start_date);
			?>
			<tr>
				<td height='10' colspan='5' bgcolor='#FFFFFF' class='style12b'>
					<div align='center' class='style22'>
						<?php echo $year; ?>
					</div>
				</td>
			</tr>
			<tr class='header_row' >
				<td class='style14b'>
					<div align='center' class='style21'>Date</div>
				</td>
				<td  class='style14b'>
					<div align='center' class='style21'>Event Description </div>
				</td>
				<td  height='29'>
					<div align='center' class='style14b style21'>Squadron</div>
				</td>
				<td class='style14b'>
					<div align='center' class='style21'>Contact</div>
				</td>
				<td class='style14b'>
					<div align='center' class='style21'>Phone</div>
				</td>
			</tr>
			<?php	
			}
			?>
			<!--<tr bgcolor='#FFFFFF' class='style12b'>
				<td height='10'><div align='center'></div></td>
				<td class='style12b'><div align='center'></div></td>
				<td class='style12b style23'><div align='center'></div></td>
				<td class='style12b'></td>
				<td class='style12b'><div align='center'></div></td>
			</tr>-->
			<tr class='data_row'>
			<!--// display event date -->
				<td valign='middle' class="initialism">
					<div align='center'>
						<?php echo $event['date_2ln']; ?>
					</div>
				</td>
				<td valign='middle'  class='bs-example'>
					<div align='left'>
						<span class='style14b'>
							<?php echo $event['event_name_with_modal']; ?>
						</span>
						<br>
						<small>
						<?php echo $event['location_name']; ?>
						</small> 
					</div>
				</td>
				<td height='25' valign='middle' class='style12b'>
					<div align='center'>
						<?php echo $event['squad_short_name']; ?>
					</div>
				</td>
				<td valign='middle'  class='style12b'>
					<div align='center'>
					<?php echo $event['poc_full_name']; ?>
					</div>
				</td>
				<td valign='middle'  class='style12b'>
					<div align='center'>
						<?php echo $event['telephone']; ?>
					</div>
				</td>
			</tr>
		<?php 	
		}
		?>	      
		</table>
	</div>
</body>

