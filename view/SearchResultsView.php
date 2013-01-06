<div id="tabs">
    <ul>
        <li><a href="#tabs-Event">Event</a></li>
        <li><a href="#tabs-Organization">Organization</a></li>
        <li><a href="#tabs-Person">Person</a></li>
    </ul>
    <div id="tabs-Event" class="overflow">
        <p>
        	<?php
        		if(is_int($Event))
        		{
        			require_once('../controller/EventController.php');
					$EventCtrl = new EventController();
					$EventCtrl->activate($Event);
        		}
        		elseif(is_string($Event))
        		{
        			echo($Event);
        		}
        		else
        		{
        			date_default_timezone_set(EMAxSTATIC::$TIMEZONE);
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
        			foreach($Event as $record):
        			?>
        				<tr>
        					<td> <?= $record['Organization'] ?> </td>
        					<td>
        						<?= date('l jS \of', strtotime($record['startTime'])) ?>
        						<br />
        						<?= date('F Y', strtotime($record['startTime'])) ?>
        					</td>
        					<td> <?= date('g:i a', strtotime($record['startTime'])) ?> </td>
        					<td> <?= date('g:i a', strtotime($record['endTime'])) ?> </td>
							<td> <?= $record['bookedBy'] ?> </td>
							<td> <?= $record['RoomLocation'] ?> </td>
							<td> <?= $record['fName'] ?> <?= $record['lName'] ?> </td>
							<td> <?= $record['emailAddress'] ?> </td>
							<td> <?= $record['phoneNumber'] ?> </td>

							<td> <input type="button" value="select" onclick="loadContent(
								'RPC/SearchResultsRPC.php', 
								<?= $record['ID'] ?> , 
								'Event')" />
							</td>
        				</tr>
        			<?php
        			endforeach;
        			echo('</table>');
        		}
        	?>
        </p>
    </div>
    <div id="tabs-Organization" class="overflow">
        <p>
			<?php
        		if(is_int($Organization))
        		{
        			require_once('../controller/OrganizationController.php');
					$OrganizationCtrl = new OrganizationController();
					$OrganizationCtrl->activate($Organization);
        		}
        		elseif(is_string($Organization))
        		{
        			echo($Organization);
        		}
        		else
        		{
        			echo('
        			<table class="searchTable">
        			<tr>
						<th>Name</th>
						<th>Address</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Zip</th>
						<th>State</th>
						<th>City</th>
						<th></th>
        			</tr>
        			');
        			foreach($Organization as $record):
        			?>
        				<tr>
        					<td> <?= $record['name'] ?> </td>
        					<td> <?= $record['address'] ?> </td>
        					<td> <?= $record['emailAddress'] ?> </td>
							<td> <?= $record['phoneNumber'] ?> </td>
							<td> <?= $record['Zip'] ?> </td>
							<td> <?= $record['State'] ?> </td>
							<td> <?= $record['City'] ?> </td>
							<td> <input type="button" value="select" onclick="loadContent(
								'RPC/SearchResultsRPC.php',
								<?= $record['ID'] ?>,
								'Organization')" />
							</td>
        				</tr>
        			<?php
        			endforeach;
        			echo('</table>');
        		}
        	?>
        </p>
    </div>
    <div id="tabs-Person" class="overflow">
        <p>
        <?php
        		if(is_int($Person))
        		{
     				require_once('../controller/PersonController.php');
					$PersonCtrl = new PersonController();
					$PersonCtrl->activate($Person);
        		}
        		elseif(is_string($Person))
        		{
        			echo($Person);
        		}
        		else
        		{
        			echo('
        			<table class="searchTable">
        			<tr>
						<th>Name</th>
						<th></th>
						<th></th>
						<th>Address</th>
						<th>City</th>
						<th>State</th>
						<th>Zip</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Organization</th>
						<th></th>
        			</tr>
        			');
        			foreach($Person as $record):
        			?>
        				<tr>
        					<td> <?= $record['fName'] ?> </td>
        					<td> <?= $record['mName'] ?> </td>
        					<td> <?= $record['lName'] ?> </td>
							<td> <?= $record['address'] ?> </td>
							<td> <?= $record['City'] ?> </td>
							<td> <?= $record['State'] ?> </td>
							<td> <?= $record['Zip'] ?> </td>
							<td> <?= $record['emailAddress'] ?> </td>
							<td> <?= $record['phoneNumber'] ?> </td>
							<td> <?= $record['Organization'] ?> </td>
							<td> <input type="button" value="select" onclick="loadContent(
								'RPC/SearchResultsRPC.php',
								<?= $record['ID'] ?>,
								'Person')" />
							</td>
			
        				</tr>
        			<?php
        			endforeach;
        			echo('</table>');
        		}
        	?>
        	</p>
    </div>
    <script type="text/javascript" > reloadTabs(); </script>
</div>	