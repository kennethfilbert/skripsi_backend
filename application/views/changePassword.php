<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
</head>
<body class="backgrnd">
    <div style="margin-top: 5%; margin-left: 2%; padding-right:50%">
        <h3> Change Password </h3>
        <hr>
        <?php
            if(!empty($success_msg)){
                echo '<p class="statusMsg" style="color: blue">'.$success_msg.'</p>';
            }elseif(!empty($error_msg)){
                echo '<p class="statusMsg" style="color: red">'.$error_msg.'</p>';
            }
        ?>
        <?php echo form_open('Main/changePassword/'.$passData[0]->customerID); ?>
            <form class="form-horizontal" action="" method="post">
                <div class="form-group">
                    <label for="oldPass"><b>Old Password</b></label>
                    <input type="password" class="form-control" name="oldPass" placeholder="Old Password" required="" value="">
                    <?php echo form_error('email','<span class="help-block">','</span>'); ?>
                </div>
                <div class="form-group">
                    <label for="newPass"><b>New Password</b></label>
                    <input type="password" class="form-control" name="newPass" placeholder="New Password" required="" value="">
                    <?php echo form_error('email','<span class="help-block">','</span>'); ?>
                </div>
                <div class="form-group">
                    <label for="confirmPass"><b>Confirm Password</b></label>
                    <input type="password" class="form-control" name="confirmPass" placeholder="Confirm Password" required="" value="">
                    <?php echo form_error('email','<span class="help-block">','</span>'); ?>
                </div>
                <div class="form-group">
                    <input type="submit" name="changePassword" class="btn-primary" value="Change Password"/>
                </div>
            </form>
        <?php echo form_close(); 
             $loggedInUser = $this->session->userdata['isUserLoggedIn']['customerID'];
            echo '<a href="'.base_url().'index.php/Main/profile/'.$loggedInUser.'"> ';
            echo '<span class="fa fa-arrow-left"></span>';
            echo '   Back';
            echo '</a>';
        ?>
    </div>
</body>