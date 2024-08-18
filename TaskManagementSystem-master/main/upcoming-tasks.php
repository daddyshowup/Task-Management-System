<?php 
    // starting session if it is not started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // connecting to database
    require_once '../config.php';
?>
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
<section id="content-today" class="content">
    <div class="head">
        <div class="heading">
            <span>Upcoming</span>
        </div>
        <form method="post">
            <select name="sort-by" id="sort-box">
                <option hidden selected value="">Sort By</option>
                <option value="priority">Priority </option>
                <option value="due-date-asc">(Early) Due date </option>
                <option value="due-date-desc">(Later) Due date </option>
                <option value="old-task-first">(oldest) Date added </option>
                <option value="new-task-first">(newest) Date added &nbsp;&nbsp; </option>
                <option value="A-Z">(A-Z) Alphabetically</option>
                <option value="Z-A">(Z-A) Alphabetically</option>
            </select>
            <span class="buttons">
                <button class="two" name="sort-submit">Sort</button>
                <button class="one" name="sort-reset">Reset</button>
            </span>
        </form>
    </div>
    <div class="tasks">
        <?php
            if(isset($_POST['sort-submit'])){
                $sortBy = $_POST['sort-by'];
                if($sortBy == "priority"){
                    $sql1 = "SELECT * FROM `tasks` WHERE `user-id` = '{$_SESSION['id']}' AND DATE(`due-date`) > DATE(now()) ORDER BY `priority` ASC";
                }
                if($sortBy == "due-date-asc"){
                    $sql1 = "SELECT * FROM `tasks` WHERE `user-id` = '{$_SESSION['id']}' AND DATE(`due-date`) > DATE(now()) ORDER BY `due-date` ASC";
                }
                if($sortBy == "due-date-desc"){
                    $sql1 = "SELECT * FROM `tasks` WHERE `user-id` = '{$_SESSION['id']}' AND DATE(`due-date`) > DATE(now()) ORDER BY `due-date` DESC";
                }
                if($sortBy == "old-task-first"){
                    $sql1 = "SELECT * FROM `tasks` WHERE `user-id` = '{$_SESSION['id']}' AND DATE(`due-date`) > DATE(now()) ORDER BY `timestamp` ASC";
                }
                if($sortBy == "new-task-first"){
                    $sql1 = "SELECT * FROM `tasks` WHERE `user-id` = '{$_SESSION['id']}' AND DATE(`due-date`) > DATE(now()) ORDER BY `timestamp` DESC";
                }
                if($sortBy == "A-Z"){
                    $sql1 = "SELECT * FROM `tasks` WHERE `user-id` = '{$_SESSION['id']}' AND DATE(`due-date`) > DATE(now()) ORDER BY `task-name` ASC";
                }
                if($sortBy == "Z-A"){
                    $sql1 = "SELECT * FROM `tasks` WHERE `user-id` = '{$_SESSION['id']}' AND DATE(`due-date`) > DATE(now()) ORDER BY `task-name` DESC";
                }
                if($sortBy == ""){
                    $sql1 = "SELECT * FROM `tasks` WHERE `user-id` = '{$_SESSION['id']}' AND DATE(`due-date`) > DATE(now())";
                }
            }
            else{
                // $sql1 = "SELECT * FROM `tasks` WHERE `user-id` = '{$_SESSION['id']}' AND`timestamp` > CURDATE()";
                $sql1 = "SELECT * FROM `tasks` WHERE `user-id` = '{$_SESSION['id']}' AND DATE(`due-date`) > DATE(now())";
            }
            $result1 = mysqli_query($conn, $sql1) or die('query unsucessful');
            if(mysqli_num_rows($result1) > 0){    
                while($row = mysqli_fetch_assoc($result1)){
                    // print_r($row['Sno']);
        ?>
        <div class="single-task">
            <div class="todo">
                <div class="checkbox">
                    <i id="<?php 
                        if($row['priority'] == 1){echo 'first'; }
                        else if($row['priority'] == 2){echo 'second'; }
                        else if($row['priority'] == 3){echo 'third'; }
                        else if($row['priority'] == 4){echo 'fourth'; }
                        else{echo 'fourth'; }?>"
                        class="fa fa-solid fa-circle-o">
                    </i>
                </div>
                <div class="text">
                    <input type="text" hidden value="<?php echo $row['Sno'];?>">
                    <span class="task-name"><?php echo $row['task-name'];?></span>
                    <p class="task-desc"><?php echo $row['task-desc'];?></p>
                    <div class="display-date">
                        <small style="color: rgb(255, 0, 0, 0.6);"><?php $dueDate = strtotime($row['due-date']); $myFormatForView = date("d M g:i A", $dueDate); echo ' <i style="font-size:16px;" class=" fa fa-solid fa-calendar-o"></i> Due date: ' . $myFormatForView;?></small>                        
                        <!-- <small style="color: #bbb;"><?php //echo 'Task added on: '.$row['timestamp'];?></small>                         -->
                    </div>
                </div>
            </div>
            <div class="icons">
                <i attr-id="<?php echo $row['Sno'] ?>" class="fa fa-solid fa-edit"></i> 
                <i attr-id="<?php echo $row['Sno'] ?>" class="fa fa-solid fa-trash"></i>
            </div>        
        </div>
        <?php 
            } }
        ?>
        <!-- Add task modal -->
        <div class="addtask">
            <form class="add-task" action="function.php" method="post">
                <div class="add-task-head">
                    <i class="fa fa-light fa-plus"></i>
                    <span>Add Task</span>
                </div>
                <div class="add-task-body">
                    <input type="text" name="Sno" hidden>
                    <input type="text" placeholder="Task Name" name="task-name" >
                    <textarea name="task-desc" id="" cols="30" rows="3" placeholder="Task Description"></textarea>
                    <div class="buttons">
                        <div class="left-buttons">
                        <?php

                            date_default_timezone_set('Asia/Kolkata'); 

                                $minDate = date("Y-m-d");
                                $minTime = date("h:i");
                                $min = $minDate."T".$minTime;
                                
                                $defaultDate = date("Y-m-d", strtotime("+1 day"));
                                $defaultTime = date("23:59");
                                $default = $defaultDate."T".$defaultTime;
                            ?>
                            <input name="select-due-date"
                            type="datetime-local" id="due-date" placeholder="set due date"
                            min="<?php echo $min?>" value="<?php echo $default;?>"
                            >
                            <select name="select-priority" id="priority">
                                <option value="4" selected hidden>Set Priority</option>
                                <option id="first" value="1">1st Priority</option>
                                <option id="second" value="2">2nd Priority</option>
                                <option id="third" value="3">3rd Priority</option>
                                <option id="fourth" value="4">No Priority</option>
                            </select>
                        </div>
                        <div class="right-buttons">
                            <button type="reset" class="one" id="one" name="cancelbtn">Cancel</button>
                            <button class="addBtn two" name="add-task" >Add Task</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php 
            if(mysqli_num_rows($result1) == 0){
                echo '<h1 class="tittle">No Tasks To Show! Add New Tasks here.</h1>
                <div class="img-container">
                    <img src="../images/Add-tasks.GIF" alt="" class="add-task-image">
                </div>';
            }
        ?>
        <!-- Delete task Modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modalClose">&times;</span>
                    <h2>Delete Task?</h2>
                </div>
                <form action="function.php" method="post">
                    <input type="hidden" name="task-id" id="delId" value="">
                    <div class="modal-body">
                        <p>Are you sure you want to delete this task?</p>           
                    </div>
                    <div class="modal-footer">
                        <div class="buttons">
                            <button name="reset" class="modalClose one" type="button">cancel</button>
                            <button name="del-task" type="submit" class="two"> Yes! </button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        <!-- Edit task Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modalClose">&times;</span>
                    <h2>Edit Task</h2>
                </div>
                <form action="function.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="task-id" id="editId" value="">
                        <h4>Task name:</h4>
                        <input type="text" id="editName" name="new-task-name" placeholder="Task Name" value="">
                        <h4>Task description:</h4>
                        <textarea id="editDesc" name="new-task-desc" cols="30" rows="3" placeholder="Task Description"></textarea>
                        <h4>Task priorty:</h4>
                        <select id="editPriority" name="new-priority">
                            <option value="4" selected hidden>Set Priority</option>
                            <option id="first" value="1">1st Priority</option>
                            <option id="second" value="2">2nd Priority</option>
                            <option id="third" value="3">3rd Priority</option>
                            <option id="fourth" value="4">No Priority</option>
                        </select>
                        <h4>Task due date:</h4>
                        <input id="editDuedate" name="new-due-date"
                            type="datetime-local" id="due-date" placeholder="set due date"
                            min="<?php echo $min?>" value=""
                        >
                    </div>
                    <div class="modal-footer">
                        <div class="buttons">
                            <button name="reset" class="modalClose one" type="button">cancel</button>
                            <button name="edit-task" class="two">Edit Task</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</section>
<?php 
mysqli_close($conn); 
?>
</body>