<?php 
    // connecting to database 
    require_once 'config.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrganizeU: Register</title>
    <!-- favicon -->
    <link rel="icon" type="image/png" href="images/favicon1.PNG" sizes="96x96">
    <!-- font aewsome cdn -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- css file -->
    <link rel="stylesheet" href="registerAndLogin.css">
    <!--  bootstrap cdn-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <h1>Create Account</h1>
                <input name="email" type="email" placeholder="Enter Email"> 
                <input name="username" type="text" placeholder="Enter Username"> 
                <input name="password" type="password" placeholder="Enter Password"> 
                <input name="confirm_password" type="password" placeholder="Confirm Password">
                <Button name="submit" class="form-btn">SIGN UP</Button>
                <p>I already have an account? <a href="login.php" >Login Here!</a> </p>
                <div class="error">
                    <?php 
                        $email = $username = $password = $confirm_password = "";
                        $email_err = $username_err = $password_err = $confirm_password_err = "";
                        if (isset($_POST['submit'])){ 
                            // checking for email
                            if(empty(trim($_POST['email']))){
                                // if email is empty then show this error
                                $email_err = 'email cannot be blank';
                                echo $email_err.'<br>';
                            }
                            else{
                                // if email is not empty then run this code
                                $sql = "SELECT id FROM users WHERE email = ? "; 
                                $stmt = mysqli_prepare($conn, $sql);
                                if($stmt){
                                    mysqli_stmt_bind_param($stmt, 's', $param_email);
                                    // setting and executing the value of param_email
                                    $param_email = trim($_POST['email']);
                                    if(mysqli_stmt_execute($stmt)){
                                        mysqli_stmt_store_result($stmt);
                                        // check if email is already taken 
                                        if(mysqli_stmt_num_rows($stmt) == 1){
                                            // if email is taken then show this error
                                            $email_err = "This email is already taken";
                                            echo $email_err.'<br>';
                                        }
                                        else{
                                            // if email is not taken then post email
                                            $email = trim($_POST['email']);
                                        }
                                    }
                                }
                                else{
                                    echo "<br>Something went wrong!!";
                                }
                                mysqli_stmt_close($stmt);
                            }
                            // checking for username
                            if(empty(trim($_POST['username']))){
                                // if username is empty then show this error
                                $username_err = 'username cannot be blank';
                                echo $username_err.'<br>';
                            }
                            else{
                                // post username
                                $username = trim($_POST['username']);
                            }
                            // checking for password
                            if(empty(trim($_POST['password']))){
                                // if password is empty then show this error
                                $password_err = 'Password cannot be blank';
                                echo $password_err.'<br>';
                            }
                            elseif(strlen(trim($_POST['password'])) < 5){
                                // if password is less then 5 characters
                                $password_err = 'Password cannot be less than 5 characters';
                                echo $password_err.'<br>';
                            }
                            else{
                                //post password
                                $password = trim($_POST['password']);
                            }
                            // checking for confirm password
                            if(trim($_POST['password']) != trim($_POST['confirm_password'])){
                                // if password and conifirm password are not same show this error
                                $confirm_password_err = 'Passwords should match! ';
                                echo $confirm_password_err.'<br>';
                            }
                            // inserting user into database if no error occured
                            if(empty($email_err) && empty($username_err) && empty($password_err) &&empty($confirm_password_err)){
                                $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
                                $stmt = mysqli_prepare($conn, $sql);
                                if($stmt){
                                    mysqli_stmt_bind_param($stmt, 'sss' , $param_email, $param_username, $param_password);
                                    $param_email = $email;
                                    $param_username = $username;
                                    $param_password = password_hash($password, PASSWORD_DEFAULT);
                                }
                                // if registered successfully send user to login page
                                if (mysqli_stmt_execute($stmt)){
                                    header("location: login.php");
                                }
                                else{
                                    echo "Something went wrong... Cannot redirect";
                                }
                                mysqli_stmt_close($stmt);
                            }
                            mysqli_close($conn);
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
