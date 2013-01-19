<?php  
require_once('../controller/SearchResultsController.php');
$search = (isset($_POST['id'])) ? $_POST['id'] : NULL;
$selectedRecord = (isset($_POST['option'])) ? $_POST['option'] : NULL;
error_log($search . '< line 5 searchresultsRPC >' . $selectedRecord);
$SearchResults = new SearchResultsController();
$SearchResults->activate($search, $selectedRecord);
?>