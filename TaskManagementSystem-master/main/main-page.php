<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
    {
        header("location: ../login.php");
    }
    if(isset($_GET['page'])){
        $currentPage = $_GET['page'];
    }
    else{
        $currentPage = "Today tasks";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrganizeU:<?php if ($currentPage!="")echo " $currentPage"; ?></title>
    <!-- css file -->
    <link rel="stylesheet" href="main-page.css">
    <!-- favicon -->
    <link rel="icon" type="image/png" href="" sizes="96x96">
    <!-- font aewsome cdn -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <!-- storyset attibute -->
    <a href="https://storyset.com/user"></a>
</head>
<body>
    <?php 
        include ('main-navbar.php');
    ?>
    <section class="wrapper">
            <?php 
                include_once ('main-sidebar.php');
                if ( isset($_GET['page']) && $_GET['page'] == 'All tasks' )
                {
                    $currentPage="All tasks";
                    include_once('all-tasks.php');
                }
                elseif ( isset($_GET['page']) && $_GET['page'] == 'Today tasks' )
                {
                    $currentPage="Today tasks";
                    include_once('today-tasks.php');
                }
                elseif ( isset($_GET['page']) && $_GET['page'] == 'Overdue tasks' )
                {
                    $currentPage="Overdue tasks";
                    include_once('overdue-tasks.php');
                }
                elseif ( isset($_GET['page']) && $_GET['page'] == 'Upcoming tasks' )
                {
                    $currentPage="Upcoming tasks";
                    include_once('upcoming-tasks.php');
                }
                else{
                    $currentPage="Today tasks";
                    include_once('today-tasks.php');
                }              
            ?>
    </section>
    <!-- js file -->
    <script src="main-page.js"></script>
</body>
</html>