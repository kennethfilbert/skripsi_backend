<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>About Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
    <script>
        var now = new Date(<?php echo time() * 1000 ?>);
            function startInterval(){  
                setInterval('updateTime();', 1000);  
            }
            startInterval();//start it right away
            function updateTime(){
                var nowMS = now.getTime();
                nowMS += 1000;
                now.setTime(nowMS);
                var clock = document.getElementById('clock');
                if(clock){
                    clock.innerHTML = now.toLocaleString();        //adjust to suit
                }
            }
    </script> 
</head>
<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <?php
                    echo '<a href="'.base_url().'index.php/Main/dashboard">';
                    echo '<img src="http://159.89.197.191/~careermmg/assets/mmg.png" style=" display: block;
                        margin-left: auto;
                            margin-right: auto;
                            width: 70%">';
                    echo '</a>';
                ?>
                <p style="text-align:center">SUPPORT</p>
            </div>
            
            <ul class="list-unstyled components" style="margin-left: 3%; margin-right: 3%">   
                <p style="text-align:center"><b>Actions</b></p>
                <hr>
                    <li style="background: white; padding:5%; border-radius:25px">
                        <?php
                            echo '<a href="'.base_url().'index.php/Main/homepage">';
                            echo '<span class="fa fa-home"></span>';
                            echo "   Submit a Ticket";
                            echo '</a>';
                        ?>
                    </li>
                    <hr>
                    <li style="background: white; padding:5%; border-radius:25px">
                        <?php
                            $loggedInUser = $this->session->userdata['isUserLoggedIn']['customerID'];
                            //echo $this->session->userdata('isUserLoggedIn');
                            echo '<a href="'.base_url().'index.php/Main/profile/'.$loggedInUser.'">';
                            echo '<span class="fa fa-user"></span>';
                            echo '   My Profile';
                            echo '</a>';
                        ?>
                    </li>
                    <hr>
                    <li style="background: white; padding:5%; border-radius:25px">
                        <?php
                            echo '<a href="'.base_url().'index.php/Main/contactUs','">';
                            echo '<span class="fa fa-info-circle"></span>';
                            echo '   Contact Us';
                            echo '</a>';
                        ?>
                    </li>
                    <hr>
                    <li style="background: white; padding:5%; border-radius:25px">
                        <?php
                            echo '<a href="'.base_url().'index.php/Main/logout','">';
                            echo '<span class="fa fa-power-off"></span>';
                            echo '   Sign Out';
                            echo '</a>';
                        ?>
                    </li>
                    <hr>
                </ul>
            <footer>
                <div class="footer-copyright text-center py-3">© PT Mitra Mentari Global
                    <p>2019</p>
                </div>
            </footer>
        </nav>
        <div style="margin:2%;">
                <div class="navbar backgrnd" style="padding-bottom:-5%; width:200%">
                        <?php 
                            $displayName = $this->session->userdata['isUserLoggedIn']['customerUsername'];
                            echo '<h5>Welcome, '.$displayName.'!</h5>'; 
                        ?>
                        <span class="navbar-text" id="clock"></span>
                </div>
        <h1>Contact Us</h1>
        <hr style="width: 200%">
        <h5><span class="fa fa-mobile" style="margin-right: 1.5em"></span> 0813 8377 0358</h5>
        <h5><span class="fa fa-phone" style="margin-right: 1.1em"></span> 021 2965 9338</h5>
        <h5><span class="fa fa-envelope" style="margin-right: 1em"></span> info@mitramentariglobal.com</h5>
        <h5><span class="fa fa-home" style="margin-right: 1em"></span> APL Tower Lt. 19 Unit 17<br></h5>
            
            <h5 style="margin-left : 2.2em; margin-top: -0.4em">
                Central Park<br>
                Jl. Letjend S. Parman Kav. 28<br>
                Jakarta Barat 11470</h5>
           

        </div>
    </div>
</body>

</html>