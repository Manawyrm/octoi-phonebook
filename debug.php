<?php
require_once("phonebook.php");
$phonebook = fetch_phonebook();
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>OCTOI phonebook debug</title>
	 	<script type="text/javascript" src="assets/jquery-3.2.1.min.js"></script>
		<link href="assets/bootstrap.min.css" rel="stylesheet">
		<link href="assets/bootstrap-theme.min.css" rel="stylesheet">
		<script src="assets/bootstrap.min.js"></script>
	</head>

	<body>
		<div class="container-fluid" role="main">
			<div class="page-header">
				<h1>OCTOI phonebook debug</h1>
			</div>
		
			<div class="row">
				<div class="col-md-12">
					This page shows how the phonebook is parsed from the Redmine Wiki.<br>
					Red lines contain invalid digits or are otherwise invalid.<br>
					The guessed service type is used to filter export lists (phones don't need data extensions, etc.).<br><br>

					<table id="phonebook" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th style="width:1%">Area</th>
								<th style="width:1%">Prefix</th>
								<th style="width:1%">Extension</th>
								<th style="width:10%">Operator</th>
								<th style="width:15%">Service</th>
								<th style="width:60%">Description</th>
								<th style="width:5%">Guessed type</th>
							</tr>
							<?php
							foreach ($phonebook as $entry)
							{
								?>
								<tr class="<?php echo $entry['valid'] ? "bg-success" : "bg-danger" ?>">
									<td><?php echo htmlentities($entry['area']); ?></td>
									<td><?php echo htmlentities($entry['prefix']); ?></td>
									<td><?php echo htmlentities($entry['extension']); ?></td>
									<td><?php echo htmlentities($entry['operator']); ?></td>
									<td><?php echo htmlentities($entry['service']); ?></td>
									<td><?php echo htmlentities($entry['description']); ?></td>
									<td><?php echo htmlentities($entry['guessedType']); ?></td>
								</tr>
								<?php
							}
							?>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
