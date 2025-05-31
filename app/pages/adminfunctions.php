<?php
// ===== Functions to populate Dynamic Countries, ProvStates and Regions =====
//connect to database
function databaseConnection()
{
	$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	
    if($conn->connect_errno != 0) {
        die("Error connecting database " . $conn->connect_error);
    }

	return $conn;
}

function getCountries() {
    $mysqli = databaseConnection();
    if(!$mysqli) {
        return false;
    }

    $res = $mysqli->query("SELECT * FROM countries");
    while($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}


// to handle the get request for populating States
if(isset($_GET["country_code"])) {
    echo getProvState($_GET["country_code"]);
}

function getProvState($country_code) {
    $mysqli = databaseConnection();
    if(!$mysqli) {
        return false;
    }

    $country_code = htmlspecialchars($country_code);

    $res = $mysqli->query("SELECT * FROM states WHERE country = '$country_code'");
    while($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    return json_encode($data);
}


// to handle the get request for populating Regions
if(isset($_GET["state_code"])) {
    echo getRegions($_GET["state_code"]);
}

function getRegions($state_code) {
    $mysqli = databaseConnection();
    if(!$mysqli) {
        return false;
    }

    $state_code = htmlspecialchars($state_code);

    $res = $mysqli->query("SELECT * FROM regions WHERE state = '$state_code'");
    while($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    return json_encode($data);
}
// ***** END Functions to populate Dynamic Countries, ProvStates and Regions *****