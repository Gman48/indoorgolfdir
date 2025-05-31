<?php 
//just to show things
function show($stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

// routes to page name entered in url
function page($file)
{
	return "app/pages/".$file.".php";
}

//connects to database
function db_connect()
{
	$string = DBDRIVER.":hostname=".DBHOST.";dbname=".DBNAME;
	$con = new PDO($string, DBUSER, DBPASS); // use PDO to prevent SQL injections and to use prepared statements 

	return $con;
}

//used to run a query of the database to return an array of arrays
function db_query($query, $data = array())
{
	$con = db_connect();

	$stm = $con->prepare($query);
	if($stm)
	{
		$check = $stm->execute($data);
		if($check)
		{
			$result = $stm->fetchAll(PDO::FETCH_ASSOC); //fetches an associative array

			if(is_array($result) && count($result) > 0)
			{
				return $result;
			}
		}
	}
	return false;
}

// returns just one record from database
function db_query_one($query, $data = array())
{
	$con = db_connect();

	$stm = $con->prepare($query);
	if($stm)
	{
		$check = $stm->execute($data);
		if($check){
			$result = $stm->fetchAll(PDO::FETCH_ASSOC);

			if(is_array($result) && count($result) > 0)
			{
				return $result[0];
			}
		}
	}
	return false;
}

// sends message once something is done on the website (i.e. registration successful)
function message($message = '', $clear = false)
{
	if(!empty($message))
	{
		$_SESSION['message'] = $message; //this saves the message if there is one
	}else {
		if(!empty($_SESSION['message']))
		{
			$msg = $_SESSION['message'];
			if($clear)
			{
				unset($_SESSION['message']);
			}
			return $msg;
		}
	}
	return false;
}

//this redirects to another page
function redirect($page)
{
	header("Location: ".ROOT."/".$page);
	die;
}

//keeps what was entered into the form so do not have to retype if there are errors
function set_value($key, $default = '')
{
	if(!empty($_POST[$key]))
	{
		return $_POST[$key];
	}else{
		return $default;
	}
	return '';
}

// keeps the value in a selector
function set_select($key, $value, $default = '')
{
	if(!empty($_POST[$key]))
	{
		if($_POST[$key] == $value)
		{
			return " selected ";
		}
	}else {
		if($default == $value)
		{
			return " selected ";
		}
	}
	return '';
}

//makes date more readable
function get_date($date)
{
	return date("jS M, Y",strtotime($date));
}

//check if someone is logged in
function logged_in()
{
	if(!empty($_SESSION['USER']) && is_array($_SESSION['USER']))
	{
		return true;
	}
	return false;
}

//check if person logged in is an admin
function is_admin()
{
	if(!empty($_SESSION['USER']['role']) && $_SESSION['USER']['role'] == 'admin')
	{
		return true;
	}
	return false;
}

//grab any user column we need
function user($column)
{
	if(!empty($_SESSION['USER'][$column]))
	{
		return $_SESSION['USER'][$column];
	}
	return "Unknown";
}

//authenticate the user
function authenticate($row)
{
	$_SESSION['USER'] = $row;
}

// this converts a string with spaces to a clean url name 
function str_to_url($url)
{
	$url = str_replace("'", "", $url);
	$url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
	$url = trim($url, "-");
	$url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
	$url = strtolower($url);
	$url = preg_replace('~[^-a-z0-9_]+~', '', $url);

	return $url;
}

// get the category name based on the category_id
function get_category($id)
{
	$query = "select category from categories where id = :id limit 1";
	$row = db_query_one($query,['id'=>$id]);

	if(!empty($row['category']))
	{
		return $row['category'];
	}
	return "Unknown";
}

// makes sure the string has clean code for the browser
function esc($str)
{
	return nl2br(htmlspecialchars($str));
}

// get the artist name based on the artist_id
function get_artist($id)
{
	$query = "select name from artists where id = :id limit 1";
	$row = db_query_one($query,['id'=>$id]);

	if(!empty($row['name']))
	{
		return $row['name'];
	}
	return "Unknown";
}

// another function that could clean data before showing on website (to prevent injections)
function clean_search($data)
{
	$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	$result = mysqli_real_escape_string($conn, $data);

	return $result;
}

// return htmlspecialchars($data);

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