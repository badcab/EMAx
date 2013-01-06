<div id="tabs">
    <ul>
        <li><a href="#tabs-State">State</a></li>
        <li><a href="#tabs-Grade">Grade</a></li> 
        <li><a href="#tabs-Option">Option</a></li> 
        <li><a href="#tabs-Room">Room</a></li>
    </ul>
    <div id="tabs-State" class="overflow">
		<table>
        		<tr>
					<td><input type="text" name="add" id="tabs-State-add"/></td> 
					<td><input type="button" value="Add New" onclick="miscellaneousScript('STATE', 'ADD', $('#tabs-State-add').val())" /></td>       		
        		</tr>
      <?php foreach($stateList as $item): ?>
      		<tr>
					<td> <?= $item['name'] ?> </td>
					<td><input type="button" value="Delete" onclick="miscellaneousScript('STATE', 'DELETE', '<?= $item ?>')" /></td>
      		</tr>      
      <?php endforeach; ?>
		</table>        
    </div>
  
    <div id="tabs-Grade" class="overflow">
      <table>
        		<tr>
					<td><input type="text" name="add" id="tabs-Grade-add" /></td> 
					<td><?= $costGrade ?></td>
					<td><input type="button" value="Add New" onclick="miscellaneousScript('GRADE', 'ADD', $('#tabs-Grade-add').val(), $('#gradeCost').val())" /></td>       					
        		</tr>
      <?php foreach($gradeList as $item): ?>
      		<tr>
					<td> <?= $item['name'] ?> </td>
					<td> <?= $item['cost'] ?> </td>
					<td><input type="button" value="Delete" onclick="miscellaneousScript('GRADE', 'DELETE', '<?= $item['name'] ?>')" /></td>
      		</tr>    
      <?php endforeach; ?>
		</table> 
    </div>
    
    <div id="tabs-Option" class="overflow">
      <table>
        		<tr>
					<td><input type="text" name="add" id="tabs-Option-add" /></td> 
					<td><?= $costOption ?></td>
					<td><input type="button" value="Add New" onclick="miscellaneousScript('OPTION', 'ADD', $('#tabs-Option-add').val(), $('#optionCost').val())" /></td>       							
        		</tr>
      <?php foreach($optionList as $item): ?>
      		<tr>
					<td> <?= $item['name'] ?> </td>
					<td> <?= $item['cost'] ?> </td>
					<td><input type="button" value="Delete" onclick="miscellaneousScript('OPTION', 'DELETE', '<?= $item['name'] ?>')" /></td>
      		</tr>      
      <?php endforeach; ?>
		</table> 
    </div>
   
    <div id="tabs-Room" class="overflow">
      <table>
        		<tr>
					<td><input type="text" name="add" id="tabs-Room-add" /></td> 
					<td><?= $costRoom ?></td>
					<td><input type="button" value="Add New" onclick="miscellaneousScript('ROOM', 'ADD', $('#tabs-Room-add').val(), $('#roomCost').val() )" /></td> <!-- we will need to add cost variables to the miscelaneoues script -->      					
        		</tr>
      <?php foreach($roomList as $item): ?>
      		<tr>
					<td> <?= $item['name'] ?> </td>
					<td> <?= $item['cost'] ?> </td>
					<td><input type="button" value="Delete" onclick="miscellaneousScript('ROOM', 'DELETE', '<?= $item['name'] ?>')" /></td>
      		</tr>  
      <?php endforeach; ?>
		</table> 
    </div>
    <script type="text/javascript" > reloadTabs(); </script>
</div>	