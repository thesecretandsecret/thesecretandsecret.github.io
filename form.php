<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize_input($_POST["name"]);
    $email = sanitize_input($_POST["email"]);
    $message = $_POST["message"];
    // Validation
    $nameErr = "";
    $emailErr = "";

    if (empty($name)) {
        $nameErr = "Name is required";
    } else {
        // Check if name contains only letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    if (empty($email)) {
        $emailErr = "Email is required";
    } else {
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // If there are no validation errors, process the form data
    if (empty($nameErr) && empty($emailErr)) {
        $projectData = array(
            'name' => $name,
            'email' => $email,
            'message' =>$message // You need to set the message value here
        );

        if (connectDatabase($projectData)) {
            echo "Form submitted successfully!";
        } else {
            echo "Form submission failed.";
        }
    }
}

// Function to sanitize user input
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to establish a database connection and insert data
function connectDatabase()
{
    $servername = 'localhost';
    $username = 'root';
    $password = 'root';
    $dbname = 'portfoliodb';

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }
return $conn;
}
function insertproject($projectData){
    $sql = "INSERT INTO users (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $projectData['name'], $projectData['email'], $projectData['message']);

    if ($stmt->execute()) {
        // Close the statement and connection
        $stmt->close();
        $conn->close();
        return true; // Insert successful
    } else {
        // Close the statement and connection
        $stmt->close();
        $conn->close();
        return false; // Insert failed
    }
}
 
// Function to retrieve project data from the database
function getproject(){ 
	$conn = connectDatabase();
	
	$sql="SELECT * FROM users";
	$result=$conn->query($sql);
	
    

	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			echo"<br><br>,name".$row['name'].",email".$row['email']."message".$row['email']."<br>";
		}
	}else{
		echo"No user found.";
}
}


function updateUser($id, $name, $email){
    $conn = connectDatabase();
    $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $id);

    if($stmt->execute()){
        echo "User updated successfully";
    } else{
        echo "Error updating user: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
}



function deleteUser($id){
    $conn = connectDatabase();
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        echo "User deleted successfully";
    } else{
        echo "Error deleting user: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
}

getproject();
updateUser('saula','saula21@gamil.com',9);
deleteUser(30);
?>
