<?php 

include 'connect.php';

if(isset($_POST['signUp'])){
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password); // Encrypt password
    
    // New fields
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    
    if($result->num_rows > 0){
        echo "Email Address Already Exists!";
    } else {
        // Insert query with new fields
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password, age, height, weight) 
                        VALUES ('$firstName', '$lastName', '$email', '$password', '$age', '$height', '$weight')";
        
        if($conn->query($insertQuery) === TRUE){
            header("location: index.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];

        // Store additional user details in session
        $_SESSION['firstName'] = $row['firstName'];
        $_SESSION['lastName'] = $row['lastName'];
        $_SESSION['age'] = $row['age'];
        $_SESSION['height'] = $row['height'];
        $_SESSION['weight'] = $row['weight'];

        header("Location: homepage.php");
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
?>
