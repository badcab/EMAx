<div>
<form id="orgForm">
<table>
<input type="hidden" name="id" value="<?= $Organization->getID() ?>" />
<input type="hidden" name="table" value="Organization" />
	<tr>
		<td>Name</td>
		<td><input type="text" name="name" value="<?= $Organization->getOrganization() ?>"/></td>	
	</tr>
	
	<tr>
		<td>phoneNumber</td><!-- format validater js -->
		<td><input type="text" name="phoneNumber" value="<?= $Organization->getphoneNumber() ?>" onblur="Valid.phoneValid(this, <?= $areaCode ?>)"/></td>	
	</tr>
	
	<tr>
		<td>emailAddress</td><!-- format validater js -->
		<td><input type="text" name="emailAddress" value="<?= $Organization->getemailAddress() ?>" onblur="Valid.emailValid(this)"/></td>	
	</tr>
	
	<tr>
		<td>address</td>
		<td><input type="text" name="address" value="<?= $Organization->getaddress() ?>"/></td>	
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
		<td>In <?= $county ?> County</td>
		<td><input type="checkbox" name="countyCB" id="countyCB" value="" onchange="Etera.checkBoxFix(this, 'county')" />
			<input type="hidden" name="county" id="county" value="<?= $sameCounty ?>" />		
		</td>	
	</tr>
	
	<tr>
		<td>notes</td>
		<td><textarea rows="4" cols="25" name="notes" ><?= $Organization->getnotes() ?></textarea> </td>	
	</tr>
	<tr>
	<td>
		<input type="button" value="Save" class="crudOrganization" onclick="LoadContent.collectFormDataAjax(this.form)"/>
		<input type="button" value="Clear" class="crudOrganization" onclick="LoadContent.clearFormData(this.form)"/>		
	</td>
	<td>
		
	</td>
	</tr>
	<?php if($id):?>
		<script type="text/javascript" > 
			$('select[name="State"]', this.form).val(<?= $State->getID() ?>);				
		</script>
	<?php endif; ?>
	<?php if($sameCounty): ?>
		$("#countyCB").prop("checked", true);
	<?php endif; ?>
</table>
</form>
</div>