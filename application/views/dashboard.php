<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Support</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
</head>
<body>
    <nav class="navbar sticky-top navbar-expand-lg backgrnd" style="padding: 0px"> 
        <?php echo '<a class="navbar-brand" href="'.base_url().'index.php/Main/dashboard'.'">';
                echo '<img src="http://159.89.197.191/~careermmg/assets/mmg.png" style="width:8%">'; 
                echo '</a>';

                echo '<a style="color: black; margin-right: 2%; width:25%; background: white; padding:10px; border-radius:25px">Welcome, '.$this->session->userdata['isUserLoggedIn']['customerUsername'].'!</a>';

                echo '<a class="btn btn-primary" href="'.base_url().'index.php/Main/logout','" style="margin-right: 3%; width: 12%">';
                echo '<i class="fa fa-power-off"></i>';
                echo '   Sign Out';
                echo '</a>';
        ?>
    </nav>
    <div class="container" style="margin-top:2%">
         <h1>Choose an Action</h1>
         <hr>
         <div class="card" style="width: 25rem; display:inline-block; margin-bottom: 2%; margin-right:2%">
            <div class="card-body">
                <?php
                    echo '<a href="'.base_url().'index.php/Main/homepage">';
                    echo '<h5 class="card-title">Submit a Support Ticket</h5>';
                    echo '</a>';
                ?>
                <p class="card-text">Having problems with one of our products? Report them here.</p>
            </div>
         </div>

         <div class="card" style="width: 25rem; display:inline-block; margin-bottom: 2%; margin-right:2%">
            <div class="card-body">
                 <?php
                    $loggedInUser = $this->session->userdata['isUserLoggedIn']['customerID'];
                    echo '<a href="'.base_url().'index.php/Main/profile/'.$loggedInUser.'">';
                    echo '<h5 class="card-title">My Profile</h5>';
                    echo '</a>';
                ?>
                <p class="card-text">View your profile info, change your password, and view your ticket history.</p>
            </div>
         </div>
         <div class="card" style="width: 25rem; display:inline-block">
            <div class="card-body">
                 <?php
                    echo '<a href="'.base_url().'index.php/Main/contactUs">';
                    echo '<h5 class="card-title">Contact Us</h5>';
                    echo '</a>';
                ?>
                <p class="card-text">Contact PT MMG via other means.</p>
            </div>
         </div>
    </div>
</body>

<footer class="page-footer" style="padding-top: 18%">
         <div class="footer-copyright text-center py-3">© PT Mitra Mentari Global
           <p>2019</p>
        </div>
</footer>

</html>