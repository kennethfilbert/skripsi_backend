<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Users</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
    <script>
         $(document).ready(function(){
            $('#userList').dataTable();
         });
    </script>
</head>
<body>
    <nav class="navbar sticky-top navbar-expand-lg bg-dark"> 
        <?php echo '<a class="navbar-brand" href="'.base_url().'index.php/SpvController/dashboard'.'">';
                echo 'MMG SUPPORT'; 
                echo '</a>'; ?>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <?php 
                            echo '<a class="nav-link" href="'.base_url().'index.php/SpvController/dashboard">Home</a>';
                        ?>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Manage Users <span class="sr-only">(current)</span></a>
                    </li> 
                    <li class="nav-item">
                        <?php echo '<a class="nav-link" href="'.base_url().'index.php/SpvController/manageCustomers">';
                                echo 'Manage Customers'; 
                                echo '</a>'; 
                        ?>
                    </li>
                </ul>
            </div>
    </nav>

    <div class="container bg-light">
        <h1>All Users</h1>
        <hr>
        <?php echo '<a class="btn btn-primary" style="margin:10px" a href="'.base_url().'index.php/SpvController/addUser'.'">
            <span class="fa fa-plus"></span> Add New User</a>'; ?>
        <table id="userList" class='table table-striped table-bordered' cellspacing='0'>
			 <thead>
                 <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>User Email</th>
                    <th>User Level</th>
                    <th>Date Added</th>
                    <th>Edit</th>
                 </tr>
             </thead>
             <tbody>
                <?php
                    foreach($userData as $key => $value){
                        $id = $value['userID'];
                        $username = $value['userName'];
                        $email = $value['userEmail'];
                        $level= $value['userLevel'];
                        $dateAdded = $value['dateAdded'];

                        echo "<tr>";
                        echo "<td>".$id."</td>";
                        echo "<td>".$username."</td>";
                        echo "<td>".$email."</td>";
                        echo "<td>".$level."</td>";
                        echo "<td>".$dateAdded."</td>";
                        echo '<td> <a class="btn btn-primary" name="btnEdit" href="'.base_url().'index.php/SpvController/editUser/'.$value['userID'].'">';
                        echo '<span class="fa fa-pencil"></span>   Edit User</a>';
                        echo "</tr>";
                    }
                ?>
             </tbody>
        </table>
    </div>

    
</body>

</html>