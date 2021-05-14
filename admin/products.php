<?php include_once 'header.php'; ?>

	<div class="ibox">
		<div class="ibox-content">
			<div class="col-xs-12 col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th></th>
								<th>Status</th>
								<th>User</th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Size</th>
								<th>Description</th>
								<th>Pickup Name</th>
								<th>Pickup Zipcode</th>
								<th>Pickup Address</th>
								<th>Pickup Lat</th>
								<th>Pickup Lng</th>
								<th>Pickup City</th>
								<th>Pickup State</th>
								<th>Pickup Phone Number</th>
								<th>Dropoff Name</th>
								<th>Dropoff Zipcode</th>
								<th>Dropoff Address</th>
								<th>Dropoff Lat</th>
								<th>Dropoff Lng</th>
								<th>Dropoff City</th>
								<th>Dropoff State</th>
								<th>Dropoff Phone Number</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$q = "SELECT 
								p.id,
								p.idStatus,
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
								p.dropoff_phone_number,
								u.name as user 
								FROM products p 
								INNER JOIN users u ON u.id = p.idUser 
								ORDER BY p.id DESC";
								$q = mysqli_query($mysqli, $q);
								while ($r = mysqli_fetch_array($q)) {
									echo '<td>';
										echo '<a class="btn btn-primary" href="product.php?id='.$r["id"].'"><i class="fa fa-pencil"></i></a>';
									echo '</td>';
									echo '<td>';
											if($r["idStatus"] == 0){ echo '<div class="alert alert-info">Pending</div>'; }
											if($r["idStatus"] == 1){ echo '<div class="alert alert-success">Delivered</div>'; }
											if($r["idStatus"] == 2){ echo '<div class="alert alert-danger">Cancelled</div>'; }
										echo '</a>';
									echo '</td>';
									echo '<td>'.$r["user"].'</td>';
									echo '<td>'.$r["name"].'</td>';
									echo '<td>'.$r["quantity"].'</td>';
									echo '<td>'.$r["size"].'</td>';
									echo '<td>'.$r["description"].'</td>';
									echo '<td>'.$r["pickup_name"].'</td>';
									echo '<td>'.$r["pickup_zipcode"].'</td>';
									echo '<td>'.$r["pickup_address"].'</td>';
									echo '<td>'.$r["pickup_lat"].'</td>';
									echo '<td>'.$r["pickup_lng"].'</td>';
									echo '<td>'.$r["pickup_city"].'</td>';
									echo '<td>'.$r["pickup_state"].'</td>';
									echo '<td>'.$r["pickup_phone_number"].'</td>';
									echo '<td>'.$r["dropoff_name"].'</td>';
									echo '<td>'.$r["dropoff_zipcode"].'</td>';
									echo '<td>'.$r["dropoff_address"].'</td>';
									echo '<td>'.$r["dropoff_lat"].'</td>';
									echo '<td>'.$r["dropoff_lng"].'</td>';
									echo '<td>'.$r["dropoff_city"].'</td>';
									echo '<td>'.$r["dropoff_state"].'</td>';
									echo '<td>'.$r["dropoff_phone_number"].'</td>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

<?php include_once 'footer.php'; ?>