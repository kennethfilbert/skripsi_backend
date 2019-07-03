<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add New Company Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
    <script>
         //$(document).ready(function(){
       //     $('#prodList').dataTable();
        // });
    </script>
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
                    echo '<a href="'.base_url().'index.php/AdminController/logout','" style="margin-left: 3%">';
                    echo '<span class="fa fa-power-off"></span>';
                    echo '   Sign Out';
                    echo '</a>';
                ?>
            </div>
    </nav>

    <div class="container bg-light" style="margin-top: 2%;">
    <h1>All Company Data</h1>
    <?php
        if($this->session->flashdata('success')!=null){
            echo '<p style="color:blue">'.$this->session->flashdata('success').'</p>';
        }
        elseif($this->session->flashdata('fail')!=null){
            echo '<p style="color:red">'.$this->session->flashdata('fail').'</p>';
        }
    ?>
    <?php echo '<a class="btn btn-primary" style="margin:2px" a href="'.base_url().'index.php/AdminController/manageProducts'.'">
            <span class="fa fa-arrow-left"></span> Back to Manage Products</a>'; ?>
    <hr>
    <h3>Add New Company Data</h3>
     <?php echo form_open('AdminController/insertNewCompany'); ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="companyName">Company Name</label>
                <input type="text" class="form-control" name="companyName" required="">
                <?php echo form_error('name','<span class="help-block">','</span>'); ?>
            </div>
            <div class="form-group">
                <input type="submit" name="confirm" class="btn btn-primary" value="Add New Company"/>
            </div>
        </form>
    <?php echo form_close(); ?>      
    <table id="companyList" class='table table-striped table-bordered' cellspacing='0'>
			 <thead>
                 <tr>
                    <th>Company ID</th>
                    <th>Company Name</th>
                    <th>Delete</th>
                 </tr>
             </thead>
             <tbody>
                <?php
                    foreach($companyData as $key => $value){
                        $id = $value['companyID'];
                        $companyName = $value['companyName'];

                        echo "<tr>";
                        echo "<td>".$id."</td>";
                        echo "<td>".$companyName."</td>";
                        echo '<td> <a class="btn btn-danger" name="btnDelete" href="'.base_url().'index.php/AdminController/deleteCompany/'.$value['companyID'].'">';
                        echo '<span class="fa fa-close"></span>   Delete Company</a>';
                        echo "</tr>";
                    }
                ?>
             </tbody>
        </table>   
    </div>

</body>

</html>