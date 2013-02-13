<div id="tabs">
    <ul>
        <li><a href="#tabs-State">State</a></li>
        <li><a href="#tabs-Grade">Grade</a></li> 
        <li><a href="#tabs-Option">Option</a></li> 
        <li><a href="#tabs-Room">Room</a></li>
        <li><a href="#tabs-Config">Admin Configure</a></li>
    </ul>
    <div id="tabs-State" class="overflow">
		<table>
        		<tr>
					<td><input type="text" name="add" id="tabs-State-add"/></td> 
					<td><input type="button" value="Add New" onclick="Etera.miscellaneousScript('STATE', 'ADD', $('#tabs-State-add').val())" /></td>       		
        		</tr>
      <?php foreach($stateList as $item): ?>
      		<tr>
					<td> <?= $item['name'] ?> </td>
					<td><input type="button" value="Delete" onclick="Etera.miscellaneousScript('STATE', 'DELETE', '<?= $item['name'] ?>')" /></td>
      		</tr>      
      <?php endforeach; ?>
		</table>        
    </div>
  
    <div id="tabs-Grade" class="overflow">
      <table>
        		<tr>
					<td><input type="text" name="add" id="tabs-Grade-add" /></td> 
					<td><?= $costGrade ?></td>
					<td><input type="button" value="Add New" onclick="Etera.miscellaneousScript('GRADE', 'ADD', $('#tabs-Grade-add').val(), $('#gradeCost').val())" /></td>       					
        		</tr>
      <?php foreach($gradeList as $item): ?>
      		<tr>
					<td> <?= $item['name'] ?> </td>
					<td> <?= money_format('%(#10n',$item['cost']) ?> </td>
					<td>
					<input type="button" value="disable/enable" onclick="Etera.enableDisableOptionGrade('GRADE', '<?= $item['name'] ?>', <?= $item['enable'] ?>, this)"/>
					<input type="button" value="Delete" onclick="Etera.miscellaneousScript('GRADE', 'DELETE', '<?= $item['name'] ?>')" />
					</td>
      		</tr>    
      <?php endforeach; ?>
		</table> 
    </div>
    
    <div id="tabs-Option" class="overflow">
      <table>
        		<tr>
					<td><input type="text" name="add" id="tabs-Option-add" /></td> 
					<td><?= $costOption ?></td>
					<td><input type="button" value="Add New" onclick="Etera.miscellaneousScript('OPTION', 'ADD', $('#tabs-Option-add').val(), $('#optionCost').val())" /></td>       							
        		</tr>
      <?php foreach($optionList as $item): ?>
      		<tr>
					<td> <?= $item['name'] ?> </td>
					<td> <?= money_format('%(#10n',$item['cost']) ?> </td>
					<td>
					<input type="button" value="disable/enable" onclick="Etera.enableDisableOptionGrade('OPTION', '<?= $item['name'] ?>', <?= $item['enable'] ?>, this)"/>
					<input type="button" value="Delete" onclick="Etera.miscellaneousScript('OPTION', 'DELETE', '<?= $item['name'] ?>')" />
					</td>
      		</tr>      
      <?php endforeach; ?>
		</table> 
    </div>

    <div id="tabs-Room" class="overflow">
      <table>
        		<tr>
					<td><input type="text" name="add" id="tabs-Room-add" /></td> 
					<td><?= $costBaseNonProfit ?></td>
					<td><?= $costBaseForProfit ?></td>
					<td><?= $costExtraLongNonProfit ?></td>
					<td><?= $costExtraLongForProfit ?></td>
					<td><input type="button" value="Add New" onclick="Etera.miscellaneousScript('ROOM', 'ADD', $('#tabs-Room-add').val(), $('#costBaseNonProfit').val(), $('#costBaseForProfit').val(), $('#costExtraLongNonProfit').val(), $('#costExtraLongForProfit').val() )" /></td>      					
        		</tr>      		
				<tr>
					<th> Room </th>
					<th> Non Profit Short Stay </th>
					<th> For Profit Short Stay </th>
					<th> Non Profit Long Stay </th>
					<th> For Profit Long Stay </th>
				</tr>        		        		
      <?php foreach($roomList as $item): ?>
      		<tr>
					<td> <?= $item['name'] ?> </td>
					<td> <?= money_format('%(#10n',$item['costBaseNonProfit']) ?> </td>
					<td> <?= money_format('%(#10n',$item['costBaseForProfit']) ?> </td>
					<td> <?= money_format('%(#10n',$item['costExtraLongNonProfit']) ?> </td>
					<td> <?= money_format('%(#10n',$item['costExtraLongForProfit']) ?> </td>
					
					<td>
					<input type="button" value="disable/enable" onclick="Etera.enableDisableOptionGrade('ROOM', '<?= $item['name'] ?>', <?= $item['enable'] ?>, this)"/>
					<input type="button" value="Delete" onclick="Etera.miscellaneousScript('ROOM', 'DELETE', '<?= $item['name'] ?>')" />
					</td>
      		</tr>  
      <?php endforeach; ?>
		</table> 
    </div>
    
    
    
    <div id="tabs-Config" class="overflow">
  		<p>This will be for the new config table when everything else is set up</p>
    </div>
    <script type="text/javascript" > Etera.reloadTabs(); </script>
</div>	