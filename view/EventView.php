<div>
<form id="eventForm">
<table>
	<tr>
		<td>Organization</td>
		<td>
		<input type="hidden" name="id" value="<?= $Event->getID() ?>" />
		<input type="hidden" name="table" value="Event" />
		<input type="hidden" name="optionEventMapHiddenText" id="optionEventMapHiddenText" value="<?= $selectedOptions ?>" />
		<input type="hidden" name="gradeEventMapHiddenText" id="gradeEventMapHiddenText" value="<?= $selectedGrades ?>" />
		<select id="Organization" name="Organization" onchange="DropDown.personAssociatedWithOrg(this)">
			<?php foreach($orgList as $org): ?>
				<option value="<?= $org['id'] ?>"><?= $org['name'] ?></option>
			<?php endforeach; ?>		
		</select>		
		</td>	
		<td></td>
	</tr>
	
	<tr>
		<td>Person
			<input type="hidden" id="PersonEvent" value="<?= $Person->getID() ?>" name="Person" />		
		</td>
		
		<td id="person">
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
		<td>Booked By
			<input type="hidden" name="Login" value="<?= $_SESSION['user'] ?>"/>
		</td>
		<td><?= $LoginUser ?></td><!-- session variable not working for some reason -->
		
	</tr>
	
	<tr>
		<td>Date</td>
		<td><input type="text" name="Date" id="Etera.datepicker" value="<?= $date ?>"/></td>	
	</tr>
	
	<tr>
		<td>Start Time</td>
		<td>
		<select id="startTime" name="startTime" onchange="DropDown.setTimePlus2Hr(this)">
			<?php foreach($timeOfEvent as $sta): ?>
				<option value="<?php echo(array_search($sta, $timeOfEvent)) ?>"><?= $sta ?></option>
			<?php endforeach; ?>		
		</select>			
		</td>	
	</tr>	
	
	<tr>
		<td>End Time</td>
		<td>
		<select id="endTime" name="endTime" onchange="DropDown.setEndTimeAfterStartTime(this)">
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
		<td><input type="checkbox" name="havingLunch" id="LunchCB" value="" onchange="Etera.checkBoxFix(this, 'Lunch')" />
			<input type="hidden" name="Lunch" id="Lunch" value="<?= $lunch ?>" />		
		</td>	
	</tr>
	
	<tr>	
		<td>Pre-Paid</td>
		<td><input type="checkbox" name="hasPaid" id="PaidCB" value="" onchange="Etera.checkBoxFix(this, 'Paid')" />
			 <input type="hidden" name="Paid" id="Paid" value="<?= $prepay ?>"/>
		</td>	
	</tr>	
	
	<tr>	
		<td>Room Reservation</td>
		<td><input type="checkbox" name="roomReservationCB" id="roomReservationCB"  onchange="Etera.checkBoxFix(this, 'roomReservation')" />
			 <input type="hidden" name="roomReservation" id="roomReservation" value="<?= $roomRes ?>" />	
		</td>	
	</tr>
	
	<tr>
		<td></td>
		<td>
			<input type="button" value="Grades Coming" onclick="EventAdd.eventAddGrade()"/>
			<input type="button" value="Options" onclick="EventAdd.eventAddOption()"/>
		</td>	
	</tr>
	<tr>
		<td>Notes</td>
		<td><textarea rows="4" cols="20" name="notes" ><?= $Event->getnotes() ?></textarea></td>	
	</tr>	
	<tr>
	<td>
		<input type="button" value="Save" class="crudEvent" onclick="LoadContent.collectFormDataAjax(this.form)"/>
		<input type="button" value="Clear" class="crudEvent" onclick="LoadContent.clearFormData(this.form)"/> 
		
	</td>
	<td >
	</td>
	</tr>	
</table>
<p id="gradeShowPrint" class="showPrint" >Grades Selected: none</p>
<p id="optionShowPrint" class="showPrint" > Options Selected: none </p>
<script type="text/javascript" > 
	Etera.datepicker(); 	
	DropDown.personAssociatedWithOrg($('select[name="Organization"]', this.form).val());
	EventAdd.gradeHiddenForPrint();
	EventAdd.optionHiddenForPrint();
	
	<?php if($id):?>
		DropDown.setDropDownValue($('select[name="Organization"]', this.form), <?= $Organization->getID() ?>);
		DropDown.personAssociatedWithOrg($('select[name="Organization"]', this.form).val());

		<?php if($lunch): ?>
		$("#LunchCB").prop("checked", true);
		<?php endif; ?>

		<?php if($roomRes): ?>
		$("#roomReservationCB").prop("checked", true);
		<?php endif; ?>

		<?php if($prepay): ?>
		$("#PaidCB").prop("checked", true);
		<?php endif; ?>
		
		DropDown.setDropDownValue($('select[name="dropDownPerson"]', this.form), <?= $Person->getID() ?>);				
		DropDown.setPersonInForm($('#PersonEventDropDown')); 
		$('#PersonEventDropDown').val(<?= $Person->getID() ?>);
		DropDown.setDropDownValue($('select[name="RoomLocation"]', this.form), <?= $RoomLocation->getID() ?>); 
		DropDown.setDropDownValue($('select[name="attendance"]', this.form), <?= $Event->getattendance() ?>); 
		DropDown.setDropDownValue($('select[name="startTime"]', this.form), <?= $startTime ?>);	
		DropDown.setDropDownValue($('select[name="endTime"]', this.form), <?= $endTime ?>);	
	<?php endif; ?>
	
	<?php if(!$id):?>
		DropDown.setTimePlus2Hr($('select[name="startTime"]', this.form));  
	<?php endif; ?>	
</script>
</form>
</div>