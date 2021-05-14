<?php include_once 'header.php'; ?>

	<div class="ibox">
		<div class="ibox-content">
			<div class="col-xs-12 col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Picture</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Address</th>
								<th>City</th>
								<th>State</th>
								<th>Zip Code</th>
								<th>Created Date</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$q = "SELECT * FROM users ORDER BY id DESC";
								$q = mysqli_query($mysqli, $q);
								while ($r = mysqli_fetch_array($q)) {
									echo '
									<td>
										<img src="http://localhost/4return/app/api/files/'.$r["picture"].'">
									</td>';
									echo '<td>'.$r["name"].'</td>';
									echo '<td>'.$r["email"].'</td>';
									echo '<td>'.$r["phone"].'</td>';
									echo '<td>'.$r["address"].'</td>';
									echo '<td>'.$r["city"].'</td>';
									echo '<td>'.$r["state"].'</td>';
									echo '<td>'.$r["zipcode"].'</td>';
									echo '<td>'.$r["createddate"].'</td>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

<?php include_once 'footer.php'; ?>