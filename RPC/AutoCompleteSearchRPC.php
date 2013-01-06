<?php 
require('../module/AutoCompleteModule.php');
$AutoComplete = new AutoCompleteModule();
$result = $AutoComplete->activate();
$searchStringList = implode(',', $result);
echo($searchStringList);
?>