<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Customer</title>
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
                    <li class="nav-item">
                        <?php 
                            echo '<a class="nav-link" href="'.base_url().'index.php/AdminController/dashboard">Home</a>';
                        ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Manage Users</a>
                    </li> 
                    <li class="nav-item">
                        <?php 
                            echo '<a class="nav-link" href="'.base_url().'index.php/AdminController/manageCustomers">Manage Customers</a>';
                        ?>
                    </li> 

                </ul>
                <?php
                            echo '<a href="'.base_url().'index.php/AdminController/logout','" style="margin-left: 3%">';
                            echo '<span class="fa fa-power-off"></span>';
                            echo '   Sign Out';
                            echo '</a>';
                ?>
            </div>
    </nav>

    <div class="container" style="margin-top: 2%;">
    <h1>Edit Customer Data</h1>
    <?php
        if($this->session->flashdata('success')!=null){
            echo '<p style="color:blue">'.$this->session->flashdata('success').'</p>';
        }
        elseif($this->session->flashdata('fail')!=null){
            echo '<p style="color:red">'.$this->session->flashdata('fail').'</p>';
        }
            echo '<a class="btn btn-primary" style="margin:10px" a href="'.base_url().'index.php/AdminController/manageCompany'.'">
            <span class="fa fa-plus"></span> Manage Company Data</a>';
        ?>
	<hr>
     <?php echo form_open('AdminController/updateCustomer/'.$editing[0]['customerID']); ?>
      <form action="" method="post">
        <div class="form-group">
          <label for="name">Customer Username</label>
          <input type="text" class="form-control" name="username" required="" value="<?php echo !empty($editing[0]['customerUsername'])?$editing[0]['customerUsername']:''; ?>">
            <?php echo form_error('name','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <label for="email">Customer Email</label>
            <input type="email" class="form-control" name="email" required="" value="<?php echo !empty($editing[0]['customerEmail'])?$editing[0]['customerEmail']:''; ?>">
          <?php echo form_error('email','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <label for="phone">Customer Phone Number</label>
            <input type="phone" class="form-control" name="phone" required="" value="<?php echo !empty($editing[0]['customerPhone'])?$editing[0]['customerPhone']:''; ?>">
          <?php echo form_error('phone','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
          <label for="companyName">Company Name</label>
          <select name="companyName" required="">
                    <?php
                            foreach($availCompany as $key =>$value){
                                echo '<option value="'.$value['companyID'].'">'.$value['companyName'].'</option>';
                            }
                    ?>  
            </select>
          <?php echo form_error('companyName','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <input type="submit" name="confirm" class="btn btn-primary" value="Submit"/>
        </div>
    </form>
    <?php echo form_close(); ?>         
</div>

</body>

</html>