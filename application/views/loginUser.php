<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome to MMG Support</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
</head>
<body class="bg-dark">
    
    <div class="container" style="margin-top: 5%; width: 50%; border-radius: 50px; background: white; padding:5%">
    <img src="http://192.168.0.11/skripsi/assets/mmg.png" style=" display: block;
                        margin-left: auto;
                            margin-right: auto;
                            width: 30%">
    <h1 style="text-align:center"> PT Mitra Mentari Global Customer Support </h1><br>
        <?php
            if(!empty($success_msg)){
                echo '<p class="statusMsg" style="color: blue"> '.$success_msg.'</p>';
            }elseif(!empty($error_msg)){
                echo '<p class="statusMsg" style="color: red">'.$error_msg.'</p>';
            }
        ?>
        <?php echo form_open('UserController/userLogin'); ?>
        <form class="form-horizontal" action="" method="post">
            <div class="form-group has-feedback">
                <input type="username" class="form-control" name="username" placeholder="Username" required="" value="">
                <?php echo form_error('email','<span class="help-block">','</span>'); ?>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required="">
                <?php echo form_error('password','<span class="help-block">','</span>'); ?>
            </div>
            <div class="form-group">
                <?php
                    //echo '<a href="'.base_url().'index.php/Main/forgetPassword','"> ';
                    //echo '<span class="fa fa-question-circle"></span>';
                   // echo '   Forget your password?';
                  //  echo '</a>';
                ?>
                
            </div>
            <div class="form-group">
                <input type="submit" name="signIn" class="btn-primary" value="Sign In"/>
            </div>
        </form>
        <?php echo form_close(); ?>
    </div>
    
</body>
    <footer class="page-footer">
         <div class="footer-copyright text-center py-3">
             <p style="color:white">© PT Mitra Mentari Global</p>
           <p style="color:white">2019</p>
        </div>
    </footer>

</html>