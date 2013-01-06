<div>
<table>
<form id="eventForm">
<input type="hidden" name="id" value="<?= $Event->getID() ?>" />
<input type="hidden" name="table" value="Event" />
<input type="hidden" name="optionEventMapHiddenText" id="optionEventMapHiddenText" value="<?= $selectedOptions ?>" />
<input type="hidden" name="gradeEventMapHiddenText" id="gradeEventMapHiddenText" value="<?= $selectedGrades ?>" />
	<tr>
		<td>Organization</td>
		<td>
		<select id="Organization" name="Organization" onchange="personAssociatedWithOrg(this)" id="OrganizationEventDropDown">
			<?php foreach($orgList as $org): ?>
				<option value="<?php echo(array_search($org, $orgList)) ?>"><?= $org ?></option>
			<?php endforeach; ?>		
		</select>		
		</td>	
		<td></td>
	</tr>
	
	<tr>
		<td>Person</td>
		<input type="hidden" id="PersonEvent" value="<?= $Person->getID() ?>" name="Person" />
		<td id="person">
			<select name="dropDownPerson" onchange="setPersonInForm(this)" onload="setPersonInForm(this)" id="PersonEventDropDown">
			<!-- this is not sending information, how odd -->
			</select>
		</td>
		<td></td>	
	</tr>
	
	<tr>
		<td>RoomLocation</td>
		<td>
		<select name="RoomLocation">
			<?php foreach($roomList as $room): ?>
				<option value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
			<?php endforeach; ?>		
		</select>
		</td>	
	</tr>

	<tr>
		<td>Login</td>
		<td><?= $LoginUser ?></td><!-- session variable not working for some reason -->
		<input type="hidden" name="Login" value="<?= $_SESSION['user'] ?>"/>
	</tr>
	
	<tr>
		<td>Date</td>
		<td><input type="text" name="Date" id="datepicker" value="<?= $date ?>"/></td>	
	</tr>
	
	<tr>
		<td>Start Time</td>
		<td>
		<select id="startTime" name="startTime" onchange="setTimePlus2Hr(this)">
			<?php foreach($timeOfEvent as $sta): ?>
				<option value="<?php echo(array_search($sta, $timeOfEvent)) ?>"><?= $sta ?></option>
			<?php endforeach; ?>		
		</select>			
		</td>	
	</tr>	
	
	<tr>
		<td>End Time</td>
		<td>
		<select id="endTime" name="endTime" onchange="setEndTimeAfterStartTime(this)">
			<?php foreach($timeOfEvent as $end): ?>
				<option value="<?php echo(array_search($end, $timeOfEvent)) ?>"><?= $end ?></option>
			<?php endforeach; ?>		
		</select>			
		</td>	
	</tr>
	
	<tr>
		<td>Attendance</td>
		<td>
		<select name="attendance" >
			<?php foreach($attend as $attendingCount): ?>
				<option value="<?= $attendingCount ?>"><?= $attendingCount ?></option>
			<?php endforeach; ?>		
		</select>	
		</td>	
	</tr>
	
	<tr>
		<td>Lunch</td>
		<td><input type="checkbox" name="havingLunch" id="LunchCB" value="" onchange="checkBoxFix(this, 'Lunch')" />
			<input type="hidden" name="Lunch" id="Lunch" value="<?= $lunch ?>" />		
		</td>	
	</tr>
	
	<tr>	
		<td>Pre-Paid</td>
		<td><input type="checkbox" name="hasPaid" id="PaidCB" value="" onchange="checkBoxFix(this, 'Paid')" />
			<input type="hidden" name="Paid" id="Paid" value="<?= $prepay ?>"/>
		</td>	
	</tr>	
	
	<tr>	
		<td>Room Reservation</td>
		<td><input type="checkbox" name="roomReservationCB" id="roomReservationCB"  onchange="checkBoxFix(this, 'roomReservation')" />
			 <input type="hidden" name="roomReservation" id="roomReservation" value="" />	
		</td>	
	</tr>
	
	<tr>
		<td></td>
		<td>
			<input type="button" value="Grades Coming" onclick="eventAddGrade()"/>
			<input type="button" value="Options" onclick="eventAddOption()"/>
		</td>	
	</tr>
	<tr>
		<td>Notes</td>
		<td><textarea rows="4" cols="20" name="notes" ><?= $Event->getnotes() ?></textarea></td>	
	</tr>	
	<tr>
	<td>
		<input type="button" value="Save" class="crudEvent" onclick="collectFormDataAjax(this.form)"/>
		<input type="button" value="Clear" class="crudEvent" onclick="clearFormData(this.form)"/> 
	</td>
	<td >
	
	</td>
	</tr>	
	<script type="text/javascript" > 
		datepicker(); 
		personAssociatedWithOrg($('#Organization')); 	
		<?php if($id):?>
			setDropDownValue($('select[name="Organization"]', this.form), <?= $Organization->getID() ?>);
			personAssociatedWithOrg($('#Organization'));

			<?php if($lunch): ?>
			$("#LunchCB").prop("checked", true);
			<?php endif; ?>
			
			<?php if($prepay): ?>
			$("#PaidCB").prop("checked", true);
			<?php endif; ?>
			setDropDownValue($('select[name="dropDownPerson"]', this.form), <?= $Person->getID() ?>);				
			setPersonInForm($('#PersonEventDropDown')); 
			$('#PersonEventDropDown').val(<?= $Person->getID() ?>);
			setDropDownValue($('select[name="RoomLocation"]', this.form), <?= $RoomLocation->getID() ?>); 
			setDropDownValue($('select[name="attendance"]', this.form), <?= $Event->getattendance() ?>); 
			setDropDownValue($('select[name="startTime"]', this.form), <?= $startTime ?>);	
			setDropDownValue($('select[name="endTime"]', this.form), <?= $endTime ?>);	
		<?php endif; ?>
		
		<?php if(!$id):?>
			setTimePlus2Hr($('#startTime'));  
		<?php endif; ?>	
	</script>
</form>
</table>
</div>