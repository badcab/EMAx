<?php 
require_once('../model/CityModel.php');
$City = new CityModel();
$cityList = $City->getList();
$listOfCityNames = array();
foreach($cityList as $cityNameList)
{
	$listOfCityNames[] = $cityNameList['name'];
}
$cityStringList = implode(',', $listOfCityNames);
echo($cityStringList);
?>