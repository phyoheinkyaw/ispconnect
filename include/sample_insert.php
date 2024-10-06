<?php
require_once 'db_connection.php';

// Select the database
$conn->select_db($database);

// Function to execute SQL Statement
function executeStatement($conn, $sql, $successMessage){
	if($conn->query($sql) === TRUE){
		echo $successMessage . "<br/>";
	}else{
		echo "Error: " . $conn->error . "<br/>";
	}
}


// Hash admin Password
$adminPassword = "a";
$hashAdminPassword = password_hash($adminPassword,PASSWORD_DEFAULT);

$sqlInsertAdmin = "
INSERT INTO admin(admin_full_name,admin_email,admin_password,admin_phone_number) VALUES('Admin','admin@admin.com','$hashAdminPassword','09123456789')";

executeStatement($conn,$sqlInsertAdmin,"Admin user inserted successfully.");


// Hash user Password
$userPassword1 = "aungaung";
$hashUserPassword1 = password_hash($userPassword1,PASSWORD_DEFAULT);

$userPassword2 = "susu";
$hashUserPassword2 = password_hash($userPassword2,PASSWORD_DEFAULT);

$sqlInsertUser = "
insert into user(user_full_name, user_email, user_password)
			values('Aung Aung','aungaung@gmail.com','$hashUserPassword1'),
				  ('Su Su','susu@gmail.com','$hashUserPassword2')";

executeStatement($conn,$sqlInsertUser,"Sample users inserted successfully.");

// Close the database connection
$conn->close();
?>