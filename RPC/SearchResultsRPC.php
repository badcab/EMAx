<?php  
require_once('../controller/SearchResultsController.php');
$search = (isset($_POST['id'])) ? $_POST['id'] : NULL;
$selectedRecord = (isset($_POST['option'])) ? $_POST['option'] : NULL;
$SearchResults = new SearchResultsController();
$SearchResults->activate($search, $selectedRecord);
?>