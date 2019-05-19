<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Customers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
    <script>
         $(document).ready(function(){
            $('#custList').dataTable();
         });
    </script>
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
                        <?php echo '<a class="nav-link" href="'.base_url().'index.php/SpvController/manageUsers">';
                                echo 'Manage Users'; 
                                echo '</a>'; 
                        ?>
                    </li> 
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Manage Customers <span class="sr-only">(current)</span></a>
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
    
    <div class="container bg-light">
        <h1>All Customers</h1>
        <hr>
        <?php echo '<a class="btn btn-primary" style="margin:10px" a href="'.base_url().'index.php/SpvController/addNewCustomer'.'">
            <span class="fa fa-plus"></span> Add New Customer</a>'; ?>
        <table id="custList" class='table table-striped table-bordered' cellspacing='0'>
			 <thead>
                 <tr>
                    <th>Customer ID</th>
                    <th>Customer Username</th>
                    <th>Customer Email</th>
                    <th>Company Name</th>
                    <th>Date Added</th>
                    <th>Edit</th>
                 </tr>
             </thead>
             <tbody>
                <?php
                    foreach($customerData as $key => $value){
                        $id = $value['customerID'];
                        $username = $value['customerUsername'];
                        $email = $value['customerEmail'];
                        $companyName = $value['companyName'];
                        $dateAdded = $value['dateAdded'];

                        echo "<tr>";
                        echo "<td>".$id."</td>";
                        echo "<td>".$username."</td>";
                        echo "<td>".$email."</td>";
                        echo "<td>".$companyName."</td>";
                        echo "<td>".$dateAdded."</td>";
                        echo '<td> <a class="btn btn-primary" name="btnEdit" href="'.base_url().'index.php/SpvController/editCustomer/'.$value['customerID'].'">';
                        echo '<span class="fa fa-pencil"></span>   Edit Cust</a>';
                        echo "</tr>";
                    }
                ?>
             </tbody>
        </table>
    </div>

</body>

</html>