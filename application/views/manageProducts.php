<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Products</title>
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

    <div class="container bg-light">
        <h1>All Products</h1>
            <?php
                echo '<h5 style="color:blue">'.$this->session->flashdata('success').'</h5>';
                        
            ?>  
        <hr>
        <?php echo '<a class="btn btn-primary" style="margin:10px" a href="'.base_url().'index.php/AdminController/addNewProduct'.'">
            <span class="fa fa-plus"></span> Add New Product</a>'; ?>
        
        <table id="prodList" class='table table-striped table-bordered' cellspacing='0'>
			 <thead>
                 <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Customer Name</th>
                    <th>Delete</th>
                 </tr>
             </thead>
             <tbody>
                <?php
                    foreach($productData as $key => $value){
                        $id = $value['productID'];
                        $productName = $value['productName'];
                        $customerName = $value['customerUsername'];

                        echo "<tr>";
                        echo "<td>".$id."</td>";
                        echo "<td>".$productName."</td>";
                        echo "<td>".$customerName."</td>";
                        echo '<td> <a class="btn btn-danger" name="btnDelete" href="'.base_url().'index.php/AdminController/deleteProduct/'.$value['productID'].'">';
                        echo '<span class="fa fa-close"></span>   Delete Prod</a>';
                        echo "</tr>";
                    }
                ?>
             </tbody>
        </table>
    </div>

</body>

</html>