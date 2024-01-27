<?php
include("../../system_config.php");

if (!empty($_GET['countryId'])) {
	$countryId = $_GET['countryId'];
	$state_query = "SELECT id, name FROM states WHERE country_id = $countryId";
	$state_result = mysqli_query($link, $state_query);
	$states = array();
	while ($row = mysqli_fetch_assoc($state_result)) {
		$states[] = $row;
	}
	$response = array(
		'states' => $states
	);
	echo json_encode($response);
} else if (!empty($_GET['stateId'])) {
	$stateId = $_GET['stateId'];
	$cities_query = "SELECT id, name FROM cities WHERE state_id = $stateId";
	$cities_query_result = mysqli_query($link, $cities_query);
	$cities = array();
	while ($row = mysqli_fetch_assoc($cities_query_result)) {
		$cities[] = $row;
	}
	$response = array(
		'cities' => $cities
	);

	echo json_encode($response);
} else if (!empty($_GET['district'])) {
	$stateId = $_GET['district'];
	$district_query = "SELECT district_id, district_name FROM district WHERE state_id = $stateId";
	$district_query_result = mysqli_query($link, $district_query);
	$districts = array();
	while ($row = mysqli_fetch_assoc($district_query_result)) {
		$districts[] = $row;
	}
	$response = array(
		'districts' => $districts
	);

	echo json_encode($response);
} else if (!empty($_GET['distId'])) {
	$distId = $_GET['distId'];
	$district_query = "SELECT taluka_id, taluka_name FROM taluka WHERE taluka_district_id = $distId";
	$district_query_result = mysqli_query($link, $district_query);
	$talukas = array();
	while ($row = mysqli_fetch_assoc($district_query_result)) {
		$talukas[] = $row;
	}
	$response = array(
		'talukas' => $talukas
	);

	echo json_encode($response);
}
