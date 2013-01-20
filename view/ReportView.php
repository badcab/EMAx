<div id="tabs">
    <ul>
        <li><a href="#tabs-Attendance">Attendance</a></li>
        <li><a href="#tabs-Options">Options</a></li>
    </ul>
    <div id="tabs-Attendance">    
     <form>
       From: <input type="text" name="start" class="datepicker"/>
       To: <input type="text" name="end" class="datepicker"/>
       <input type="button" value="lookup" onclick="Report.showReportAttendance(this.form)"/>
     </form>
     <div id="tabs-Attendance-Results">
     	<!-- I don't need any stuff her as the onclick js will populate -->
     </div>
        
    </div>
    <div id="tabs-Options">
     
        <form>
	        From: <input type="text" name="start" class="datepicker"/>
	        To: <input type="text" name="end" class="datepicker"/>
	        <input type="button" value="lookup" onclick="Report.showReportOption(this.form)"/>
	        <br/>
		
				<input type="radio" name="filterBy" value="Option" onselect="Report.radioChange($('#optionSelect'))" checked>Option </input>
				<br/>
				<input type="radio" name="filterBy" value="Room" onselect="Report.radioChange($('#roomSelect'))">Room </input>
			  		    
	         <select id="optionSelect" class="ReportViewOptions">
				<?php foreach($OptionList as $option): ?>
					<option value="<?= $option['id'] ?>"><?= $option['name'] ?></option>
				<?php endforeach; ?>			        
	        </select>
	        
	         <select id="roomSelect" class="ReportViewOptions">
				<?php foreach($RoomList as $room): ?>
					<option value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
				<?php endforeach; ?>			        
	        </select>
			</form>  
     
        <div id="tabs-Options-Results">
        	<!-- I don't need any stuff her as the onclick js will populate -->
        </div>
    </div>
    <script type="text/javascript" > 
    	Etera.reloadTabs(); 
		$('.datepicker').datepicker();
    </script>
</div>	