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
	<table id='t8' class='table table-bordered' >
	<colgroup>	
	</colgroup>
	<tr>
		<td>Award:</td> 
		<td></td> 
	</tr>
<!-- Award Year --> 	
	<tr>
		<td> Award Year :
		</td>
		<td>
			<?php echo $award['award_year'] ;?>
		</td>
	</tr>
<!-- Award Name -->
	<tr>
		<td>Award Name:</td>
		<td>
			<?php echo $award["award_name"] . " " . $award['award_place'];?>
		</td>
	</tr>
<!--Award From-->
	<tr>
		<td>Award From: </td>
		<td>
			<?php echo $award['award_source']; ?>				
		</td>
	</tr>
<!--Award Type-->
	<tr>
		<td>Award Type:</td>
		<td>
			<?php echo $award['award_type']; ?>
		</td>
	</tr>
<?php	
	if ($award['award_type'] == 'pers') {
?>
<!-- Award Recepitent -->
	<tr>
		<td>Recipient:</td>
		<td>
			<?php echo $award['award_to_member']; 	?>
		</td>
	</tr>
<?php 
	}
?>
<!-- Award Citation -->
	<tr>
		<td>Award Citation: </td>
		<td>
			<TEXTAREA 	name='award_citation' 
						readonly 
						rows='100' 
						cols='50' 
						style="	width: 100%; 
								height: 150px;"
			><?php echo $award['award_citation'];?>
			</TEXTAREA><br/>
		</td>
	</tr>
<!--Award Documents -->
	<tr>
		<td>Award Documents: </td>
		<td>
			<table>
			<?php 
				$ct = 0;
				if (is_array($award['extras'])) 
					foreach($award['extras'] as $type=>$doc){
						$ct ++;
					?>
					<tr>
						<td>
						</td>
						<td>
							<?php echo $type; ?>
						</td>
						<td>&nbsp;&nbsp;&nbsp;</td>
						<td>
							<img src='<?php echo $doc; ?>' width='400'>
						</td>
					</tr>	
					<?php
					}	 
			?>
			</table>
		</td>
	</tr>

	</tr>
<?php
	if ($setup['org'] == 6243){
?>
<!--Responsible Squadron -->
	<tr>
		<td>
			Lead Squadron:
		</td>
		<td>
			<?php $sqds->showSquadronListBox('lead_squadron',
												$award['lead_squadron'],
												$sqds->get_squadron_list(),3);
			?>
		</td>
	</tr>
<?php
	}
?>		
	</table>