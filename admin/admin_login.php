<?php
session_start();
require_once '../include/db_connection.php';

// Handle Form Submission
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$admin_email = $_POST["admin_email"];
	$admin_password = $_POST["admin_password"];

	// Prepared statement to prevent SQL injection
	$stmt = $conn->prepare("SELECT * FROM admin WHERE admin_email = ?");
	$stmt->bind_param("s", $admin_email);
	$stmt->execute();

	$result = $stmt->get_result();

	if($result->num_rows > 0){
		$admin = $result->fetch_assoc();

		// Verify password
		if(password_verify($admin_password, $admin['admin_password'])){
			$_SESSION['admin_id'] = $admin['admin_id'];
			$_SESSION['admin_full_name'] = $admin['admin_full_name'];

			$success = true;

		// to insert in database admin password = a
		// $2y$10$/hr8m8Ou.yKmdrW8JEFSf.MCMvQ8TSDqM6N9u7Vsiaxp923/cvLp6

		}else{
			$error = "Invalid Password";
		}

	}else{
		$error = "User not found";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login | ISP - Connect</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
	<link href="css/style.css" rel="stylesheet" type="text/css"/>
</head>
	<style type="text/css">
		#loading{
			display: none;
			text-align: center;
			margin-top: 20px;
		}
	</style>
<body>

	<div class="container">
		<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
			<div class="col-lg-4 col-md-6">
				<div class="card shadow">
					<div class="card-body">
						<h3 class="text-center mb-4">Admin Login</h3>

						<?php if(!empty($error)): ?>
							<div class="alert alert-danger"><?php echo htmlspecialchars_decode($error); ?></div>
						<?php endif; ?>

						<?php if(isset($success) && $success): ?>
							<div class="alert alert-success">Login successful!<br/> Redirecting you to the admin panel...</div>
							<div id="loading">
								<div class="spinner-border text-primary" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
								<p>Redirecting...</p>
							</div>
							<script type="text/javascript">
								document.getElementById('loading').style.display = "block";
								setTimeout(function(){
									window.location.href = 'index.php';
								}, 2000);
							</script>
						<?php else: ?>
						<form action="admin_login.php" method="POST">
							<div class="mb-3">
								<label for="admin_email" class="form-label">Email Address</label>
								<input type="email" name="admin_email" id="admin_email" class="form-control" required />
							</div>
							<div class="mb-3">
								<label for="admin_password" class="form-label">Password</label>
								<input type="password" name="admin_password" id="admin_password" class="form-control" required />
							</div>
							<button type="submit" class="btn btn-primary w-100">Login</button>
						</form>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
	<script src="js/script.js" type="text/javascript"></script>
</body>
</html>