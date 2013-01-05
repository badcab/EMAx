<?php 
//require('../module/SearchModule.php'); this file should ultimately be deleted
require_once('../model/_SearchModel.php');
class SearchResultsController
{
	function __construct()
	{
		if(!isset($_SESSION)) 
		{ 
			session_start();
		} 
	}

	public function activate($searchString = NULL, $selectedRecord = NULL)
	{
		if(!$_SESSION['isLoggedIn'])
		{
			require_once('../view/LoginView.php');
			return;
		}
		$search = new _SearchModel();
		
		switch($selectedRecord)
		{
			case 'Person':
			$searchResults = $search->getPersonSearch((int)$searchString);
			break;
			
			case 'Event':
			$searchResults = $search->getEventSearch((int)$searchString);
			break;
			
			case 'Organization':
			$searchResults = $search->getOrganizationSearch((int)$searchString);
			break;
			
			default:
				$searchResults = $search->doSearchString($searchString);
		}
		
		$personCount = count($searchResults['Person']);
		$organizationCount = count($searchResults['Organization']);
		$eventCount = count($searchResults['Event']);
		
		switch($personCount) 
		{
			case 0:
				$Person = 'no results returned';
			break;
			
			case 1:
				foreach($searchResults['Person'] as $record) $Person = (int)$record['ID'];
			break;
			
			default:
				$Person = $searchResults['Person'];
		}
		
		switch($eventCount) 
		{
			case 0:
				$Event = 'no results returned';
			break;
			
			case 1:
				foreach($searchResults['Event'] as $record) $Event = (int)$record['ID'];
			break;
			
			default:
				$Event = $searchResults['Event'];
		}
		
		switch($organizationCount) 
		{
			case 0:
				$Organization = 'no results returned';
			break;
			
			case 1:
				foreach($searchResults['Organization'] as $record) $Organization = (int)$record['ID'];
			break;
			
			default:
				$Organization = $searchResults['Organization'];
		}
		
		if($personCount == 0 || $organizationCount == 0)
		{
			if($personCount == 0)
			{
				if($eventCount == 1)
				{
					foreach($searchResults['Event'] as $record) $Person = (int)$record['EMAx_Person_ID'];
				}
			}
			
			if($organizationCount == 0)
			{
				if($eventCount == 1)
				{
					foreach($searchResults['Event'] as $record) $Organization = (int)$record['EMAx_Organization_ID'];			
				}
				
				elseif($personCount == 1)
				{
					foreach($searchResults['Person'] as $record) $Organization = (int)$record['EMAx_Organization_ID'];
				}
			}
		}
		
		require_once('../view/SearchResultsView.php');
	}
}
?>

