<?php 
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
	header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
	header("Content-Type: application/json; charset=utf-8");
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include_once "conn.php";
	include_once "funcs.php";
	include_once "pass.php";

	if(count($_GET) > 0){
		$postjson = $_GET;
	}else {
		$postjson = json_decode(file_get_contents('php://input'), true);
	}

	switch ($postjson['id']) {

		case 'getAllProducts':
			getAllProducts();
			break;
		case 'productsadd':
			productsadd();
			break;
		case 'productssave':
			productssave();
			break;

		case 'getAllStates':
			getAllStates();
			break;

		case 'login':
			login();
			break;
		case 'signup':
			signup();
			break;

		case 'profilesave':
			profilesave();
			break;
			
		default:
				# code...
			break;
	}

	///////////////////////////////////////////////////////////////////////////

	function profilesave(){
		global $mysqli;
		global $postjson;
		$rows = array();
		$items = array();
        $model = $postjson["model"];
		$idmodel = removeallspecial($model["id"]);
		$name = removeallspecial($model["name"]);
		$name = removeallspecial($model["name"]);
		$email = removeallspecial($model["email"]);
		$phone = removeallspecial($model["phone"]);
		$password = removeallspecial($model["password"]);
		$zipcode = removeallspecial($model["zipcode"]);
		$address = removeallspecial($model["address"]);
		$city = removeallspecial($model["city"]);
		$state = removeallspecial($model["state"]);
        $q = "SELECT * FROM users WHERE id = ".$idmodel;
        $q = mysqli_query($mysqli, $q);
        if ($q) {
            if (mysqli_num_rows($q) > 0) {

				if($password != ""){
					$password = password_hash($password, PASSWORD_BCRYPT);
					$q = "UPDATE users SET password = '".$password."' WHERE id = ".$idmodel;
					$q = mysqli_query($mysqli, $q);
					if (!$q) {
						$rows["success"] = false;
						$rows["msg"] = mysqli_error($mysqli);
						echo json_encode($rows);
						die();
					}
				}

				$q = "UPDATE users SET 
				name = '".$name."', 
				email = '".$email."', 
				phone = '".$phone."', 
				zipcode = '".$zipcode."', 
				address = '".$address."', 
				city = '".$city."', 
				state = '".$state."' WHERE id = ".$idmodel;
        		$q = mysqli_query($mysqli, $q);
        		if ($q) {
					$rows["success"] = true;
					$rows["msg"] = "Saved";
                }else{
					$rows["success"] = false;
					$rows["msg"] = mysqli_error($mysqli);
				}
            }else{
				$rows["success"] = false;
				$rows["msg"] = "Nothing found";
            }
        }else{
			$rows["success"] = false;
			$rows["msg"] = mysqli_error($mysqli);
        }
		echo json_encode($rows);
	}

	///////////////////////////////////////////////////////////////////////////

	function signup(){
		global $mysqli;
		global $postjson;
		$rows = array();
		$items = array();
        $model = $postjson["model"];
		$name = removeallspecial($model["name"]);
		$email = removeallspecial($model["email"]);
		$phone = removeallspecial($model["phone"]);
		$password = removeallspecial($model["password"]);
		$zipcode = removeallspecial($model["zipcode"]);
		$address = removeallspecial($model["address"]);
		$city = removeallspecial($model["city"]);
		$state = removeallspecial($model["state"]);
        $q = "SELECT * FROM users WHERE email = '$email'";
        $q = mysqli_query($mysqli, $q);
        if ($q) {
            if (mysqli_num_rows($q) > 0) {
				$rows["success"] = false;
				$rows["msg"] = "Email already exists";
            }else{
                $password = password_hash($password, PASSWORD_BCRYPT);
				$q = "INSERT INTO users 
				(
				name, 
				email, 
				phone, 
				password, 
				zipcode, 
				address, 
				city, 
				state
				) 
				VALUES 
				(
				'".$name."', 
				'".$email."', 
				'".$phone."', 
				'".$password."', 
				'".$zipcode."', 
				'".$address."', 
				'".$city."', 
				'".$state."' 
				)
				";
				$q = mysqli_query($mysqli, $q);
				if ($q) {
					$rows["success"] = true;
                }else{
					$rows["success"] = false;
					$rows["msg"] = mysqli_error($mysqli);
                }
            }
        }else{
			$rows["success"] = false;
			$rows["msg"] = mysqli_error($mysqli);
        }
		echo json_encode($rows);
	}

	///////////////////////////////////////////////////////////////////////////

	function login(){
		global $mysqli;
		global $postjson;
		$rows = array();
		$items = array();
        $model = $postjson["model"];
        $email = removeallspecial($model["email"]);
        $password = removeallspecial($model["password"]);
        $q = "SELECT * FROM users WHERE email = '$email'";
        $q = mysqli_query($mysqli, $q);
        if ($q) {
            if (mysqli_num_rows($q) > 0) {
                $r = mysqli_fetch_assoc($q);
                $hash = $r["password"];
                if (password_verify($password, $hash)) {
					$rows["success"] = true;
					$items[] = $r;
                }else{
					$rows["success"] = false;
					$rows["msg"] = "Invalid user";
                }
            }else{
				$rows["success"] = false;
				$rows["msg"] = "Nothing found";
            }
        }else{
			$rows["success"] = false;
			$rows["msg"] = mysqli_error($mysqli);
        }
		$rows["items"] = $items;
		echo json_encode($rows);
	}

	///////////////////////////////////////////////////////////////////////////

	function getAllStates(){
		global $mysqli;
		global $postjson;
		$rows = array();
		$items = array();
		$q = "SELECT * FROM states ORDER BY title ASC";
		$q = mysqli_query($mysqli, $q);
		if($q){
			while($r = mysqli_fetch_array($q)){
				$items[] = $r;
			}
			$rows["success"] = true;
		}else{
			$rows["success"] = false;
			$rows["msg"] = mysqli_error($mysqli);
		}
		$rows["items"] = $items;
		echo json_encode($rows);
	}

	///////////////////////////////////////////////////////////////////////////

	function productssave(){
		global $mysqli;
		global $postjson;
		$rows = array();
		$model = $postjson["model"];
		$idmodel = removeallspecial($model["id"]);
		$name = removeallspecial($model["name"]);
		$quantity = removeallspecial($model["quantity"]);
		$size = removeallspecial($model["size"]);
		$description = removeallspecial($model["description"]);
		$pickup_name = removeallspecial($model["pickup_name"]);
		$pickup_zipcode = removeallspecial($model["pickup_zipcode"]);
		$pickup_address = removeallspecial($model["pickup_address"]);
		$pickup_lat = removeallspecial($model["pickup_lat"]);
		$pickup_lng = removeallspecial($model["pickup_lng"]);
		$pickup_city = removeallspecial($model["pickup_city"]);
		$pickup_state = removeallspecial($model["pickup_state"]);
		$pickup_phone_number = removeallspecial($model["pickup_phone_number"]);
		$dropoff_name = removeallspecial($model["dropoff_name"]);
		$dropoff_zipcode = removeallspecial($model["dropoff_zipcode"]);
		$dropoff_address = removeallspecial($model["dropoff_address"]);
		$dropoff_lat = removeallspecial($model["dropoff_lat"]);
		$dropoff_lng = removeallspecial($model["dropoff_lng"]);
		$dropoff_city = removeallspecial($model["dropoff_city"]);
		$dropoff_state = removeallspecial($model["dropoff_state"]);
		$dropoff_phone_number = removeallspecial($model["dropoff_phone_number"]);
		$idStatus = removeallspecial($model["idStatus"]);
 
		if($idStatus == 2){
			$idStatus = 0;
		}

		$q = "UPDATE products SET 
		idStatus = $idStatus, 
		name = '".$name."', 
		quantity = '".$quantity."', 
		size = '".$size."', 
		description = '".$description."', 
		pickup_name = '".$pickup_name."', 
		pickup_zipcode = '".$pickup_zipcode."', 
		pickup_address = '".$pickup_address."', 
		pickup_lat = '".$pickup_lat."', 
		pickup_lng = '".$pickup_lng."', 
		pickup_city = '".$pickup_city."', 
		pickup_state = '".$pickup_state."', 
		pickup_phone_number = '".$pickup_phone_number."', 
		dropoff_name = '".$dropoff_name."', 
		dropoff_zipcode = '".$dropoff_zipcode."', 
		dropoff_address = '".$dropoff_address."', 
		dropoff_lat = '".$dropoff_lat."', 
		dropoff_lng = '".$dropoff_lng."', 
		dropoff_city = '".$dropoff_city."', 
		dropoff_state = '".$dropoff_state."', 
		dropoff_phone_number = '".$dropoff_phone_number."' WHERE id = ".$idmodel;
		$q = mysqli_query($mysqli, $q);
		if($q){
			$rows["success"] = true;
			$rows["msg"] = "Saved";
		}else{
			$rows["success"] = false;
			$rows["msg"] = mysqli_error($mysqli);
		}
		echo json_encode($rows);
	}

	///////////////////////////////////////////////////////////////////////////

	function productsadd(){
		global $mysqli;
		global $postjson;
		$rows = array();
		$model = $postjson["model"];
		$idUser = removeallspecial($model["idUser"]);
		$name = removeallspecial($model["name"]);
		$quantity = removeallspecial($model["quantity"]);
		$size = removeallspecial($model["size"]);
		$description = removeallspecial($model["description"]);
		$pickup_name = removeallspecial($model["pickup_name"]);
		$pickup_zipcode = removeallspecial($model["pickup_zipcode"]);
		$pickup_address = removeallspecial($model["pickup_address"]);
		$pickup_lat = removeallspecial($model["pickup_lat"]);
		$pickup_lng = removeallspecial($model["pickup_lng"]);
		$pickup_city = removeallspecial($model["pickup_city"]);
		$pickup_state = removeallspecial($model["pickup_state"]);
		$pickup_phone_number = removeallspecial($model["pickup_phone_number"]);
		$dropoff_name = removeallspecial($model["dropoff_name"]);
		$dropoff_zipcode = removeallspecial($model["dropoff_zipcode"]);
		$dropoff_address = removeallspecial($model["dropoff_address"]);
		$dropoff_lat = removeallspecial($model["dropoff_lat"]);
		$dropoff_lng = removeallspecial($model["dropoff_lng"]);
		$dropoff_city = removeallspecial($model["dropoff_city"]);
		$dropoff_state = removeallspecial($model["dropoff_state"]);
		$dropoff_phone_number = removeallspecial($model["dropoff_phone_number"]);
		$q = "INSERT INTO products 
		(
		idUser, 
		name, 
		quantity, 
		size, 
		description, 
		pickup_name, 
		pickup_zipcode, 
		pickup_address, 
		pickup_lat, 
		pickup_lng, 
		pickup_city, 
		pickup_state, 
		pickup_phone_number, 
		dropoff_name, 
		dropoff_zipcode, 
		dropoff_address, 
		dropoff_lat, 
		dropoff_lng, 
		dropoff_city, 
		dropoff_state, 
		dropoff_phone_number 
		) VALUES 
		(
		".$idUser.", 
		'".$name."', 
		'".$quantity."', 
		'".$size."', 
		'".$description."', 
		'".$pickup_name."', 
		'".$pickup_zipcode."', 
		'".$pickup_address."', 
		'".$pickup_lat."', 
		'".$pickup_lng."', 
		'".$pickup_city."', 
		'".$pickup_state."', 
		'".$pickup_phone_number."', 
		'".$dropoff_name."', 
		'".$dropoff_zipcode."', 
		'".$dropoff_address."', 
		'".$dropoff_lat."', 
		'".$dropoff_lng."', 
		'".$dropoff_city."', 
		'".$dropoff_state."', 
		'".$dropoff_phone_number."' 
		)";
		$q = mysqli_query($mysqli, $q);
		if($q){
			$rows["success"] = true;
			$rows["msg"] = "Saved";
		}else{
			$rows["success"] = false;
			$rows["msg"] = mysqli_error($mysqli);
		}
		echo json_encode($rows);
	}

	///////////////////////////////////////////////////////////////////////////

	function getAllProducts(){
		global $mysqli;
		global $postjson;
		$rows = array();
		$items = array();
		$idUser = $postjson["idUser"];
		$q = "SELECT * FROM products WHERE idUser = ".$idUser." ORDER BY id DESC";
		$q = mysqli_query($mysqli, $q);
		if($q){
			while($r = mysqli_fetch_array($q)){
				if($r["picture"] != ""){
					$r["picture"] = "http://localhost/4return/app/api/files/".$r["picture"];
				}else{
					$r["picture"] = "";
				}
				$items[] = $r;
			}
			$rows["success"] = true;
		}else{
			$rows["success"] = false;
			$rows["msg"] = mysqli_error($mysqli);
		}
		$rows["items"] = $items;
		echo json_encode($rows);
	}

	///////////////////////////////////////////////////////////////////////////

?>