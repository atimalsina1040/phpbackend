<?php
// Make sure there's no whitespace or HTML content before the opening PHP tag
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "contact-us");
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database
    $sql = "INSERT INTO feedback (firstname, lastname, email, subject) VALUES ('$firstname', '$lastname', '$email', '$subject')";

    if ($conn->query($sql) === TRUE) {
        echo "Feedback submitted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
 */




 // Make sure there's no whitespace or HTML content before the opening PHP tag
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
   // Validate and sanitize input data
   $firstname = htmlspecialchars($_POST['firstname']);
   $lastname = htmlspecialchars($_POST['lastname']);
   $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : null;
   $subject = htmlspecialchars($_POST['subject']);
 
   // Check if all required fields are filled
   if (!$firstname || !$lastname || !$email || !$subject) {
     echo "All fields are required.";
     exit;
   }
 
   // Database connection
   $conn = new mysqli("localhost", "root", "", "contact-us");
 
   // Check connection
   if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
   }
 
   // Prepare and bind SQL statement to prevent SQL injection
   $stmt = $conn->prepare("INSERT INTO feedback (firstname, lastname, email, subject) VALUES (?, ?, ?, ?)");
   $stmt->bind_param("ssss", $firstname, $lastname, $email, $subject); // Update data types if needed
 
   // Execute the statement
   if ($stmt->execute()) {
     echo "Feedback submitted successfully";
   } else {
     echo "Error: " . $stmt->error;
   }
 
   // Close statement and connection
   $stmt->close();
   $conn->close();
 }
 ?>
 