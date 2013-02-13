<?php	  
require_once('../configure/EMAxSTATIC.php');
global $CONFIG;
date_default_timezone_set($CONFIG->TIMEZONE);
echo('
<table class="searchTable">
<tr>
	<th>Organization</th> 
	<th>Date</th>  
	<th>Start</th>
	<th>End</th>
	<th>BookedBy</th>
	<th>Room</th>
	<th>Name</th>
	<th>Email</th> 
	<th>Phone</th>
	<th></th>     			
</tr>
');
foreach($upcomingEvents as $record):
?>
<tr>  
  			<td> <?= $record['Organization'] ?> </td>
  			<td> 
  				<?= date('l jS \of', strtotime($record['startTime'])) ?> 
  				<br/>
  				<?= date('F Y', strtotime($record['startTime'])) ?> 
  			</td>
  			<td> <?= date('g:i a', strtotime($record['startTime'])) ?> </td>
  			<td> <?= date('g:i a', strtotime($record['endTime'])) ?> </td>
			<td> <?= $record['bookedBy'] ?> </td>
			<td> <?= $record['RoomLocation'] ?> </td>
			<td> <?= $record['fName'] ?> <?= $record['lName'] ?> </td>
			<td> <?= $record['emailAddress'] ?> </td> 
			<td> <?= $record['phoneNumber'] ?> </td>

	<td> <input type="button" value="select" onclick="LoadContent.loadContent(
		'RPC/SearchResultsRPC.php', 
		<?= $record['ID'] ?> ,
		'Event')" /> 
	</td>  
   				
</tr>
<?php endforeach; ?> 
</table>

 