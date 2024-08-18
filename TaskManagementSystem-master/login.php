<?php 
    // check if user is already logged-in..if user is alaready logged-in then send user to main page
    session_start();
    if(isset($_SESSION['email'])){
        header("location: main/main-page.php");
        exit;
    }
    // connecting to database 
    require_once 'config.php';
    $email = $username = $password = "";
    $err = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrganizeU: Login</title>
    <!-- favicon -->
    <link rel="icon" type="image/png" href="images/favicon1.PNG" sizes="96x96">
    <!-- font aewsome cdn -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- css file -->
    <link rel="stylesheet" href="registerAndLogin.css">
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <!-- AOS animate on scroll liblary cdn -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body>
    <div class="register-container">
        <div class="left" data-aos="fade-right">
            <div>
                <img src="images/logo3.PNG" alt="">
                <a href="homepage.php" class="fa fa-arrow-left">Back to homepage</a>
            </div>
            <h1>Accomplish more with the help of OrganizeU</h1>
            <p>OrganizeU helps busy people like you focus on what's important. It helps people to save time and do the things that really matters.</p>
        </div>
        <div class="right" data-aos="fade-left">
            <div>
                <i class="fa fa-solid fa-gear"></i>
                <i class="fa fa-solid fa-gear"></i>
            </div>
            <form action="" method="post">
                <h1>Login</h1>
                <input name="email" type="text" placeholder="Enter Email"> 
                <input name="password" type="password" placeholder="Enter Password"> 
                <Button name="submit" class="form-btn">LOG IN</Button>
                <p>Don't have an account? <a href="register.php">SignUp here!</a> </p>
                <div class="error">
                    <?php 
                        // if request method is post
                        if ($_SERVER['REQUEST_METHOD'] == "POST"){
                            // check if password or email is empty
                            if(empty(trim($_POST['email'])) || empty(trim($_POST['password']))){
                                $err = 'Please enter email and password';
                                echo '<p>'.$err.'</p>';
                            }
                            // if password and email is not empty add it to database
                            else{
                                $email = trim($_POST['email']);
                                $password = trim($_POST['password']);
                            }
                            // run this if condition when there is no error
                            if(empty($err)){
                                $sql = "SELECT id, email, username, password FROM users WHERE email = ?";
                                $stmt = mysqli_prepare($conn, $sql);
                                mysqli_stmt_bind_param($stmt, "s", $param_email);
                                $param_email = $email;
                                // Try to execute this statement
                                if(mysqli_stmt_execute($stmt)){
                                    mysqli_stmt_store_result($stmt);
                                    if(mysqli_stmt_num_rows($stmt) == 1){
                                        mysqli_stmt_bind_result($stmt, $id, $email, $username, $hashed_password);
                                        if(mysqli_stmt_fetch($stmt)){
                                            if(password_verify($password, $hashed_password)){
                                                // this means the password is correct. Allow user to login
                                                session_start();
                                                $_SESSION["id"] = $id;
                                                $_SESSION["email"] = $email;
                                                $_SESSION["username"] = $username;
                                                $_SESSION["password"] = $hashed_password;
                                                $_SESSION["loggedin"] = true;
                                                //Redirect user to main page
                                                header("location: main/main-page.php?");
                                            }
                                            else{
                                                // if user enter wrong password then show this error
                                                $err = 'Incorrect password! <br> Please enter correct password.';
                                                echo '<p>'.$err.'</p>';
                                            } 
                                        }
                                    }
                                    else{
                                        // if user enter wrong email then show this error
                                        $err = 'Incorrect email! <br> Please enter correct email.';
                                        echo '<p>'.$err.'</p>';
                                    }
                                }
                            }    
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
</body>
</html>
