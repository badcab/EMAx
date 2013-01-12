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
		<td><input type="text" name="phoneNumber" value="<?= $Organization->getphoneNumber() ?>" onblur="phoneValid(this, <?= $areaCode ?>)"/></td>	
	</tr>
	
	<tr>
		<td>emailAddress</td><!-- format validater js -->
		<td><input type="text" name="emailAddress" value="<?= $Organization->getemailAddress() ?>" onblur="emailValid(this)"/></td>	
	</tr>
	
	<tr>
		<td>address</td>
		<td><input type="text" name="address" value="<?= $Organization->getaddress() ?>"/></td>	
	</tr>
	
	<tr>
		<td>City</td>
		<td><input type="text" name="City"  id="city" value="<?= $City->getCity() ?>" onclick="autoCompleteCity()"/></td>
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
		<td><input type="text" name="Zip" value="<?= $Zip->getZip() ?>" onblur="zipValid(this)"/></td>
	</tr>
	
	<tr>
		<td>In <?= $county ?> County</td>
		<td><input type="checkbox" name="countyCB" id="countyCB" value="" onchange="checkBoxFix(this, 'county')" />
			<input type="hidden" name="county" id="county" value="" />		
		</td>	
	</tr>
	
	<tr>
		<td>notes</td>
		<td><textarea rows="4" cols="25" name="notes" ><?= $Organization->getnotes() ?></textarea> </td>	
	</tr>
	<tr>
	<td>
		<input type="button" value="Save" class="crudOrganization" onclick="collectFormDataAjax(this.form)"/>
		<input type="button" value="Clear" class="crudOrganization" onclick="clearFormData(this.form)"/>		
	</td>
	<td>
		
	</td>
	</tr>
	<?php if($id):?>
		<script type="text/javascript" > 
			setDropDownValue($('select[name="State"]', this.form), <?= $State->getID() ?>);				
		</script>
	<?php endif; ?>
</table>
</form>
</div>