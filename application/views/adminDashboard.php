<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
</head>
<body>
    <nav class="navbar sticky-top navbar-expand-lg bg-dark"> 
        <?php echo '<a class="navbar-brand" href="'.base_url().'index.php/AdminController/dashboard'.'">';
                echo 'MMG SUPPORT'; 
                echo '</a>'; ?>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <?php echo '<a class="nav-link" href="'.base_url().'index.php/AdminController/manageUsers">';
                                echo 'Manage Users'; 
                                echo '</a>'; 
                        ?>
                    </li> 
                    <li class="nav-item">
                        <?php echo '<a class="nav-link" href="'.base_url().'index.php/AdminController/manageCustomers">';
                                echo 'Manage Customers'; 
                                echo '</a>'; 
                        ?>
                    </li> 

                </ul>
                
                <?php
                    echo '<a style="color: white; margin-left: 1%">'.$this->session->userdata['isUserLoggedIn']['userName'].'</a>';
                    echo '<a href="'.base_url().'index.php/SpvController/logout','" style="margin-left: 3%">';
                    echo '<span class="fa fa-power-off"></span>';
                    echo '   Sign Out';
                    echo '</a>';
                ?>
            </div>
        <!-- add user, edit user,add customer, manage customer-->
    </nav>

    <div class="container" style="margin-top:2%">
         <h1>Choose an Action</h1>
         <hr>
         <div class="card" style="width: 25rem; display:inline-block">
            <div class="card-body">
                <?php
                    echo '<a href="'.base_url().'index.php/AdminController/manageUsers">';
                    echo '<h5 class="card-title">Manage Users</h5>';
                    echo '</a>';
                ?>
                <p class="card-text">Add and edit user data.</p>
            </div>
         </div>

         <div class="card" style="width: 25rem; display:inline-block">
            <div class="card-body">
                 <?php
                    echo '<a href="'.base_url().'index.php/AdminController/manageCustomers">';
                    echo '<h5 class="card-title">Manage Customers</h5>';
                    echo '</a>';
                ?>
                <p class="card-text">Add and edit user + customer data.</p>
            </div>
         </div>
    </div>

</body>

<footer class="page-footer" style="padding-top:30%">
    <div class="footer-copyright text-center py-3">© PT Mitra Mentari Global
     <p>2019</p>
    </div>
</footer>

</html>