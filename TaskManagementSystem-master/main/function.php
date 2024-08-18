<?php 
    // starting session
    session_start();
    //connecting to database 
    require_once '../config.php';

    // calling functions
    if(isset($_POST['add-task'])){
        addTask($conn);
    }
    if(isset($_GET['getEditData'])){
        $id = $_GET['id'];
        editGetData($conn, $id);
    }
    if(isset($_POST['edit-task'])){
        editTask($conn);
    }  
    if(isset($_POST['del-task'])){
        deleteTask($conn);
    }
    if(isset($_POST['confirm-updateAcc']) || (isset($_POST['cancel-updateAcc'])) ){
        updateUserInfo($conn);
    }  
    if(isset($_POST['confirm-deleteAcc']) || (isset($_POST['cancel-deleteAcc'])) ){
        deleteAccount($conn);
    }   
    if(isset($_POST['logout'])){
        logout();
    }

    // defining functions
    function addTask($conn) {
        if(isset($_POST['add-task'])){

        $Sno = $_POST['Sno'];
        $taskName = $_POST['task-name'];
        $taskDesc = $_POST['task-desc'];
        $dueDate = $_POST['select-due-date'];
        $priority = $_POST['select-priority'];
  
        $sql = "INSERT INTO `tasks`( `user-id`,`task-name`, `task-desc`,`due-date`,`priority`) VALUES ('{$_SESSION['id']}',
        '{$taskName}','{$taskDesc}','{$dueDate}','{$priority}')";
        $result = mysqli_query($conn, $sql) or die('query unsuccessful');
    
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        mysqli_close($conn);
        }
        else if(isset($_POST['cancelBtn'])){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    function editGetData($conn, $id){
        $sql2 = "SELECT * FROM `tasks` WHERE Sno ='{$id}'";
        $result2 = mysqli_query($conn, $sql2) or die('query unsucessful');
        while($row = mysqli_fetch_assoc($result2)){
            $test[] = $row; 
            echo json_encode($test);
        }
    }

    function editTask($conn) {
        var_dump($_POST);
        $_POST['$server'];
        if(isset($_POST['edit-task'])){
            $Sno = $_POST['task-id'];
            $newTaskName = $_POST['new-task-name'];
            $newTaskDesc = $_POST['new-task-desc'];
            $newPriority = $_POST['new-priority'];
            $newDuedate = $_POST['new-due-date'];
            
            $sql= "UPDATE `tasks` SET `task-name`= '{$newTaskName}',`task-desc`='{$newTaskDesc}', `due-date`= '{$newDuedate}',
            `priority`='{$newPriority}' WHERE Sno = {$Sno}";
            $result = mysqli_query($conn, $sql) or die(' query unsucessful'); 
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            mysqli_close($conn);
        }
    }
    function deleteTask($conn) {
        if(isset($_POST['del-task'])){
            
            $Sno = $_POST['task-id'];

            $sql1 = "DELETE FROM `tasks` WHERE Sno = {$Sno}";
            $result1 = mysqli_query($conn, $sql1) or die('query unsucessful'); 
             
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            mysqli_close($conn);  
        }
    }

    function updateUserInfo($conn) {
        if (isset($_POST['confirm-updateAcc'])){
            echo "<script>$('#userInfoModal').css('display', 'block');</script>";

            $id = $_POST['id'];
            $new_username = $_POST['new-username'];
            $new_email = $_POST['new-email'];

            if(empty(trim($_POST['new-username'])) || empty(trim($_POST['new-email']))){
                header("location: main-page.php?err=empty-values");
            }
            else{
                mysqli_query($conn,"start transaction;");
                $sql1 = "UPDATE `users` SET `email` = '{$new_email}', `username` = '{$new_username}' WHERE `id` = '{$id}' ";
                $result1 = mysqli_query($conn, $sql1) or die('query unsucessful');
                $check_email = mysqli_query($conn, "SELECT email FROM users where email = '$new_email' ");
                if(mysqli_num_rows($check_email) > 1){
                    mysqli_query($conn,"rollback;");
                    header("location: main-page.php?err=email-taken");
                }
                else{
                    mysqli_query($conn,"commit;");
                    header("location: main-page.php?status=updated");
                }
            }
        }
        if(isset($_POST['cancel-updateAcc'])){
            header("location: main-page.php");
        }
    }
    
    function deleteAccount($conn) {

        echo "<script>$('#deleteAccountModal').css('display', 'block');</script>";

        $user_email = $user_password = '';
        $err = '';
        if (isset($_POST['confirm-deleteAcc'])){
            $user_email = trim($_POST['email']);
            $user_password = trim($_POST['password']);
            if(empty(trim($_POST['email'])) || empty(trim($_POST['password']))){
                header("location: main-page.php?err=emp-val");
            }
            else if($_POST['email'] == $_SESSION['email'] && password_verify($_POST['password'], $_SESSION['password'])){
                $err = "";
                $sql3 = "DELETE FROM `users` WHERE `email` = '{$_SESSION['email']}' ";
                $result3 = mysqli_query($conn, $sql3) or die('query unsucessful');
                $_SESSION = array();
                session_destroy();
                header("location: ../register.php");
            }
            else{
                header("location: main-page.php?err=wrong-val");
            }
        }
        if (isset($_POST['cancel-deleteAcc'])){
            echo "<script>$('#userInfoModal').css('display', 'block');</script>";
            header("location: main-page.php");
        }
    }
    function logout(){
        if(isset($_POST['logout'])){
            session_start();
            $_SESSION = array();
            session_destroy();
            header("location: ../login.php");
        } 
    }
    
    
?>