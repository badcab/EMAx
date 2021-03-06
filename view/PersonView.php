<div>
<form id="personForm">
<table>
<input type="hidden" name="id" value="<?= $Person->getID() ?>" />
<input type="hidden" name="table" value="Person" />
	<tr>
		<td>First Name</td>
		<td><input type="text" name="fName" value="<?= $Person->getfName() ?>"/></td>	
	</tr>
	
	<tr> 
		<td>Middle Name</td>
		<td><input type="text" name="mName" value="<?= $Person->getmName() ?>"/></td>	
	</tr>
	
	<tr> 
		<td>Last Name</td>
		<td><input type="text" name="lName" value="<?= $Person->getlName() ?>"/></td>	
	</tr>
	
	<tr>
		<td>Phone Number</td><!-- valid check -->
		<td><input type="text" name="phoneNumber" value="<?= $Person->getphoneNumber() ?>" onblur="Valid.phoneValid(this, <?= $areaCode ?>)"/></td>	
	</tr>
	
	<tr> 
		<td>Secondary Phone</td><!-- valid check -->
		<td><input type="text" name="secondPhoneNumber" value="<?= $Person->getsecondaryPhoneNumber() ?>" onblur="Valid.phoneValid(this, <?= $areaCode ?>)"/></td>	
	</tr>
	
	<tr>
		<td>Email Address</td><!-- valid check -->
		<td><input type="text" name="emailAddress" value="<?= $Person->getemailAddress() ?>" onblur="Valid.emailValid(this)"/></td>	
	</tr>	
	
	<tr>
		<td>Address</td>
		<td><input type="text" name="address" value="<?= $Person->getaddress() ?>"/></td>	
	</tr>
	
	<tr>
		<td>City</td>
		<td><input type="text" name="City"  id="city" value="<?= $City->getCity() ?>" onfocus="Etera.autoCompleteCity()"/></td>	
	</tr>	
	
	<tr>
		<td>State</td>
		<td>
		<select name="State">
			<?= $stateDropDown ?>
		</select>
		</td>	
	</tr>
	
	<tr>
		<td>Zip</td>
		<td><input type="text" name="Zip" value="<?= $Zip->getZip() ?>" onblur="Valid.zipValid(this)"/></td>	
	</tr>	
	
	<tr>
		<td>Organization</td>
		<td>
		<select name="Organization" id="PersonOrganizationDropDown">
			<?php foreach($orgList as $org): ?>
				<option value="<?= $org['id'] ?>"><?= $org['name'] ?></option>
			<?php endforeach; ?>		
		</select>
		</td>	
	</tr>
	<tr>
		<td>Notes</td>
		<td><textarea rows="4" cols="20" name="notes"><?= $Person->getnotes() ?></textarea> </td>	
	</tr>
	<tr>
	<td>
		<input type="button" value="Save" class="crudPerson" onclick="LoadContent.collectFormDataAjax(this.form)"/>
		<input type="button" value="Clear" class="crudPerson" onclick="LoadContent.clearFormData(this.form)"/> 
	</td>
	<td >	
	</td>
	</tr>
	<?php if($id):?>
		<script type="text/javascript" > 
			$('select[name="State"]', this.form).val(<?= $State->getID() ?>);
			$('select[name="Organization"]', this.form).val(<?= $Organization->getID() ?>);						
		</script>
	<?php endif; ?>	
</table>
</form>
</div>