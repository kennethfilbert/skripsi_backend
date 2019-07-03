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
            startInterval();
            function updateTime(){
                var nowMS = now.getTime();
                nowMS += 1000;
                now.setTime(nowMS);
                var clock = document.getElementById('clock');
                if(clock){
                    clock.innerHTML = now.toLocaleString();        
                }
            }
    </script> 
</head>
<body>
<div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <?php
                    echo '<a href="'.base_url().'index.php/Main/homepage">';
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
        <div class="container" style="margin-top:2%">
            <?php
                            
                if($this->session->flashdata('success')!=null){
                    echo '<h3 style="color:blue">'.$this->session->flashdata('success').'</h3>';
                }
                elseif($this->session->flashdata('fail')!=null){
                    echo '<h3 style="color:red">'.$this->session->flashdata('fail').'</h3>';
                }
                $loggedInUser = $this->session->userdata['isUserLoggedIn']['customerID'];
                echo '<a class="btn btn-primary" href="'.base_url().'index.php/Main/profile/'.$loggedInUser.'">';
                echo '<i class="fa fa-arrow-left"></i> Back to Ticket List </a>';
            ?>
        </div>
    </div>
            
</body>

</html>