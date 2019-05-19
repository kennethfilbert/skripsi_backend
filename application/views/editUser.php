<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
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
                    <li class="nav-item">
                        <?php 
                            echo '<a class="nav-link" href="'.base_url().'index.php/SpvController/manageUsers">Manage Users</a>';
                        ?>
                    </li> 
                    <li class="nav-item">
                        <?php 
                            echo '<a class="nav-link" href="'.base_url().'index.php/SpvController/manageCustomers">Manage Customers</a>';
                        ?>
                    </li> 

                </ul>
                <?php
                            echo '<a href="'.base_url().'index.php/SpvController/logout','" style="margin-left: 3%">';
                            echo '<span class="fa fa-power-off"></span>';
                            echo '   Sign Out';
                            echo '</a>';
                ?>
            </div>
    </nav>

    <div class="container" style="margin-top: 2%">
    <h1>Edit User Data</h1>
    <?php
        if($this->session->flashdata('success')!=null){
            echo '<p style="color:blue">'.$this->session->flashdata('success').'</p>';
        }
        elseif($this->session->flashdata('fail')!=null){
            echo '<p style="color:red">'.$this->session->flashdata('fail').'</p>';
        }
    ?>
	<hr>
     <?php echo form_open('SpvController/updateUser/'.$editing[0]['userID']); ?>
      <form action="" method="post">
        <div class="form-group">
          <label for="name">Username</label>
          <input type="text" class="form-control" name="username" required="" value="<?php echo !empty($editing[0]['userName'])?$editing[0]['userName']:''; ?>">
            <?php echo form_error('name','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <label for="email">User Email</label>
            <input type="email" class="form-control" name="email" required="" value="<?php echo !empty($editing[0]['userEmail'])?$editing[0]['userEmail']:''; ?>">
          <?php echo form_error('email','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
          <label for="userPass">User Password</label>
          <input type="password" class="form-control" name="userPass" required="">
          <?php echo form_error('userPass','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <label for="level">User Level</label>
            <select class="form-control" style="width: 5%" name="level">
                <option>2</option>
                <option>1</option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" name="confirm" class="btn btn-primary" value="Submit"/>
        </div>
    </form>
    <?php echo form_close(); ?>         
</div>

</body>

</html>