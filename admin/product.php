<?php include_once 'header.php'; ?>
	
	<?php 

		define("CUSTOMER_ID", "cus_N2tUD1EBiKG_V-");
		define("SANDBOX_API_KEY", "ea816055-7fd0-4022-8589-2fa9eb76abb7");
		define("PRODUCTION_API_KEY", "48ff471b-7f6f-478a-806a-8af872ee9eae");

	?>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCZ6h9F9HKGrh2KYe6bZnKf2p9GlNnDmc&libraries=places&sensor=false&callback=initMap" async defer></script>

	<?php 
		$name = "";
		$quantity = "";
		$size = "";
		$description = "";
		$pickup_name = "";
		$pickup_zipcode = "";
		$pickup_address = "";
		$pickup_lat = "";
		$pickup_lng = "";
		$pickup_city = "";
		$pickup_state = "";
		$pickup_phone_number = "";
		$dropoff_name = "";
		$dropoff_zipcode = "";
		$dropoff_address = "";
		$dropoff_lat = "";
		$dropoff_lng = "";
		$dropoff_city = "";
		$dropoff_state = "";
		$dropoff_phone_number = "";
		$delivery_id = "";
		if (isset($_GET["id"])) {
			$q = "SELECT 
			d.delivery_id, 
			p.id, 
			p.name, 
			p.quantity, 
			p.size, 
			p.description, 
			p.pickup_name, 
			p.pickup_zipcode, 
			p.pickup_address, 
			p.pickup_lat, 
			p.pickup_lng, 
			p.pickup_city, 
			p.pickup_state, 
			p.pickup_phone_number, 
			p.dropoff_name, 
			p.dropoff_zipcode, 
			p.dropoff_address, 
			p.dropoff_lat, 
			p.dropoff_lng, 
			p.dropoff_city, 
			p.dropoff_state, 
			p.dropoff_phone_number 
			FROM products p 
			INNER JOIN deliveries d ON d.idProduct = p.id WHERE p.id = ".$_GET["id"];
			$q = mysqli_query($mysqli, $q);
			$r = mysqli_fetch_assoc($q);
			$name = $r["name"];
			$quantity = $r["quantity"];
			$size = $r["size"];
			$description = $r["description"];
			$pickup_name = $r["pickup_name"];
			$pickup_zipcode = $r["pickup_zipcode"];
			$pickup_address = $r["pickup_address"];
			$pickup_lat = $r["pickup_lat"];
			$pickup_lng = $r["pickup_lng"];
			$pickup_city = $r["pickup_city"];
			$pickup_state = $r["pickup_state"];
			$pickup_phone_number = $r["pickup_phone_number"];
			$dropoff_name = $r["dropoff_name"];
			$dropoff_zipcode = $r["dropoff_zipcode"];
			$dropoff_address = $r["dropoff_address"];
			$dropoff_lat = $r["dropoff_lat"];
			$dropoff_lng = $r["dropoff_lng"];
			$dropoff_city = $r["dropoff_city"];
			$dropoff_state = $r["dropoff_state"];
			$dropoff_phone_number = $r["dropoff_phone_number"];
			$delivery_id = $r["delivery_id"];
			?>

			<script type="text/javascript">
				function initMap(){
			        let pickup_centerpos = { lat: parseFloat(<?php echo $pickup_lat; ?>), lng: parseFloat(<?php echo $pickup_lng; ?>) };
			        var pickup_map = new google.maps.Map(document.getElementById("pickup_map"), {
			          zoom: 15,
			          center: pickup_centerpos,
			          scrollwheel: false,
			          navigationControl: false,
			          mapTypeControl: false,
			          scaleControl: false,
			          draggable: false
			        });
			        new google.maps.Marker({
			          position: pickup_centerpos,
			          map: pickup_map,
			        });

			        let dropoff_centerpos = { lat: parseFloat(<?php echo $dropoff_lat; ?>), lng: parseFloat(<?php echo $dropoff_lng; ?>) };
			        var dropoff_map = new google.maps.Map(document.getElementById("dropoff_map"), {
			          zoom: 15,
			          center: dropoff_centerpos,
			          scrollwheel: false,
			          navigationControl: false,
			          mapTypeControl: false,
			          scaleControl: false,
			          draggable: false
			        });
			        new google.maps.Marker({
			          position: dropoff_centerpos,
			          map: dropoff_map,
			        });

				}
			</script>

			<?php
		}


		include_once 'vendor/autoload.php';

		// https://github.com/aglipanci/postmates-api

		$client = new Postmates\PostmatesClient([
			'customer_id' => CUSTOMER_ID,
			'api_key' => SANDBOX_API_KEY
		]);
		

		$delivery = new Postmates\Resources\Delivery($client);
		$delivery = $delivery->get($delivery_id);

		$tracking_url = $delivery["tracking_url"];
		$status = $delivery["status"];
	?>
		
		<div class="row">
			<div class="col-xs-12 col-md-12 form-group">
				<div class="alert alert-info">
					<h1><?php echo ucfirst($status); ?></h1>
				</div>
				<div>
					<a class="btn btn-primary" href="<?php echo $tracking_url; ?>" target="_blank">Access Track Url</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-6 form-group">
				<a href="products.php" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Back</a>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="ibox">
					<div class="ibox-title">
						<h2>Pickup</h2>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-xs-12 col-md-4 form-group">
								<label><b>Name</b></label>
								<div><?php echo $pickup_name; ?></div>
							</div>
							<div class="col-xs-12 col-md-4 form-group">
								<label><b>Zipcode</b></label>
								<div><?php echo $pickup_zipcode; ?></div>
							</div>
							<div class="col-xs-12 col-md-4 form-group">
								<label><b>Address</b></label>
								<div><?php echo $pickup_address; ?></div>
							</div>
							<div class="col-xs-12 col-md-4 form-group">
								<label><b>City</b></label>
								<div><?php echo $pickup_city; ?></div>
							</div>
							<div class="col-xs-12 col-md-4 form-group">
								<label><b>State</b></label>
								<div><?php echo $pickup_state; ?></div>
							</div>
							<div class="col-xs-12 col-md42 form-group">
								<label><b>Phone Number</b></label>
								<div><?php echo $pickup_phone_number; ?></div>
							</div>
						</div>
						<div class="row">
							<div class="map" style="width: 100%;height: 400px;" id="pickup_map"></div>
						</div>		
					</div>			
				</div>			
			</div>	
			<div class="col-xs-12 col-md-6">
				<div class="ibox">
					<div class="ibox-title">
						<h2>Dropoff</h2>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-xs-12 col-md-4 form-group">
								<label><b>Name</b></label>
								<div><?php echo $dropoff_name; ?></div>
							</div>
							<div class="col-xs-12 col-md-4 form-group">
								<label><b>Zipcode</b></label>
								<div><?php echo $dropoff_zipcode; ?></div>
							</div>
							<div class="col-xs-12 col-md-4 form-group">
								<label><b>Address</b></label>
								<div><?php echo $dropoff_address; ?></div>
							</div>
							<div class="col-xs-12 col-md-4 form-group">
								<label><b>City</b></label>
								<div><?php echo $dropoff_city; ?></div>
							</div>
							<div class="col-xs-12 col-md-4 form-group">
								<label><b>State</b></label>
								<div><?php echo $dropoff_state; ?></div>
							</div>
							<div class="col-xs-12 col-md42 form-group">
								<label><b>Phone Number</b></label>
								<div><?php echo $dropoff_phone_number; ?></div>
							</div>
						</div>
						<div class="row">
							<div class="map" style="width: 100%;height: 400px;" id="dropoff_map"></div>
						</div>		
					</div>			
				</div>			
			</div>			
		</div>			



<?php include_once 'footer.php'; ?>