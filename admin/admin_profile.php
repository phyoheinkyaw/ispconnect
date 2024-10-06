<?php
session_start();

if(!isset($_SESSION['admin_id'])){
	header("location: admin_login.php");
	exit;
}

require_once '../include/db_connection.php';

// Fetch admin details
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT admin_full_name, admin_email, admin_password, admin_phone_number FROM admin WHERE admin_id = ?");
$stmt->bind_param("i",$admin_id);
$stmt->execute();

$result = $stmt->get_result();

$admin = $result->fetch_assoc();

// Handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$admin_email = $_POST["admin_email"];
	$admin_full_name = $_POST["admin_full_name"];
	$admin_phone_number = $_POST["admin_phone_number"];
	$current_password = $_POST["current_password"];
	$new_password = $_POST["new_password"];
	$confirm_password = $_POST["confirm_password"];

	// Prepare statement for fetching hash password
	// $stmt = $conn->prepare("SELECT admin_password FROM admin WHERE admin_id = ?");
	// $stmt->bind_param("i",$admin_id);
	// $stmt->execute();
	// $result = $stmt->get_result();
	// $admin_data = $result->fetch_assoc();

	if($result->num_rows > 0 && password_verify($current_password,$admin['admin_password'])){
		echo "Working";
	}else{
		echo "password error";
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ISP Connect | Admin Dashboard</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
	<link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>

	<div class="wrapper">
		<?php include_once 'admin_include/admin_sidebar.php'; ?>
				
		<?php include_once 'admin_include/admin_navigation.php'; ?>

	<!-- Main Content Start -->
		<main class="content">
			<div class="container-fluid">
				<div class="my-3">
					<h4>Admin Profile</h4>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-6">
						<div id="response-message"></div>
						<form action="admin_profile.php" method="POST">
							<div class="mb-3">
								<label for="admin_email" class="form-label">Email Address</label>
								<input type="email" name="admin_email" id="admin_email" class="form-control" value="<?php echo $admin['admin_email'];?>" required />
							</div>
							<div class="mb-3">
								<label for="admin_full_name" class="form-label">Full Name</label>
								<input type="text" name="admin_full_name" id="admin_full_name" class="form-control" value="<?php echo $admin['admin_full_name']; ?>" required />
							</div>
							<div class="mb-3">
								<label for="admin_phone_number" class="form-label">Phone Number</label>
								<input type="text" name="admin_phone_number" id="admin_phone_number" class="form-control" value="<?php echo $admin['admin_phone_number']; ?>" required />
							</div>
							<div class="mb-3">
								<label for="current_password" class="form-label">Current Password</label>
								<input type="password" name="current_password" id="current_password" class="form-control" required />
							</div>
							<div class="mb-3">
								<label for="new_password" class="form-label">New Password</label>
								<input type="password" name="new_password" id="new_password" class="form-control" />
							</div>
							<div class="mb-3">
								<label for="confirm_password" class="form-label">Confirm Password</label>
								<input type="password" name="confirm_password" id="confirm_password" class="form-control" />
							</div>
							<button type="submit" class="btn btn-primary w-100">Update Profile</button>
						</form>
					</div>
				</div>
				
			</div>
		</main>
	<!-- Main Content End -->

	<!-- Footer Start -->
		<?php include_once 'admin_include/admin_footer.php'; ?>
	<!-- Footer End -->

		</div>
		<!-- Main DIV End -->
	</div>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
	<script src="js/script.js" type="text/javascript"></script>
</body>
</html>