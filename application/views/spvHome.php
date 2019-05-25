<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
    <script>
         $(document).ready(function(){
            $('#ticketList').dataTable();
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
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <?php echo '<a class="nav-link" href="'.base_url().'index.php/SpvController/manageUsers">';
                                echo 'Manage Users'; 
                                echo '</a>'; 
                        ?>
                    </li> 
                    <li class="nav-item">
                        <?php echo '<a class="nav-link" href="'.base_url().'index.php/SpvController/manageCustomers">';
                                echo 'Manage Customers'; 
                                echo '</a>'; 
                        ?>
                    </li> 

                </ul>
                <?php
                    echo '<a style="color: white; margin-left: 1%">'.$this->session->userdata['isUserLoggedIn']['userName'].'</a>';
                    echo '<a href="'.base_url().'index.php/SpvController/logout','" style="margin-left: 3%">';
                    echo '<span class="fa fa-power-off"></span>';
                    echo '   Sign Out';
                    echo '</a>';
                ?>
            </div>
        <!-- add user, edit user, delegate ticket, add customer, manage customer-->
    </nav>

    <div class="container">
        <h1>All Tickets</h1>
        <?php
            echo '<a class="btn btn-primary" href="'.base_url().'index.php/SpvController/exportXls">';
            echo 'Export to Excel'; 
            echo '</a>';
        ?>
        <hr>
        <table id="ticketList" class='table table-striped table-bordered'>
			        <thead>
				    <tr>
                        <th>ID</th>
                        <th>Token</th>
                        <th>Date Added</th>
                        <th>Title</th>
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>Inquiry Type</th>
                        <th>Urgency</th>
                        <th>Status</th>
                        <th>Handled By</th>
                        <th>Details</th>
                        
				    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($ticketData as $key => $value){
                                $id = $value['ticketID'];
                                $token = $value['token'];
                                $dateAdded = $value['dateAdded'];
                                $title = $value['ticketTitle'];
                                $customerName = $value['customerName'];
                         
                                $productName = $value['productName'];
                                $inquiryType = $value['inquiryType'];
                                $urgency = $value['urgency'];
                                $description = $value['description'];
                                $status = $value['status'];
                                $handledBy = $value['userID'];

                                echo "<tr>";
                                echo "<td>".$id."</td>";
                                echo "<td>".$token."</td>";
                                echo "<td>".$dateAdded."</td>";
                                echo "<td>".$title."</td>";
                                echo "<td>".$customerName."</td>";
                              
                                
                                echo "<td>".$productName."</td>";
                                echo "<td>".$inquiryType."</td>";
                                echo "<td>".$urgency."</td>";
                                if($status==1){
                                    echo "<td><b>Open</b></td>";
                                }
                                elseif($status==2){
                                    echo "<td><b>Ongoing</b></td>";
                                }
                                elseif($status==3){
                                    echo "<td><b>Closed</b></td>";
                                }
                                //echo "<td><b>".$status."</b></td>";
                                //echo "<td>".$handledBy."</td>";
                                if($handledBy == null){
                                    echo "<td><i>";
                                    echo "Not Yet";
                                    echo "</i></td>";
                                }
                                else{
                                    echo "<td>".$value['userID']."</td>";
                                }
                                echo '<td><a class="btn btn-primary" name="btnDetail" href="'.base_url().'index.php/SpvController/spvTicketDetails/'.$value['ticketID'].'">';
                                echo '<span class="fa fa-pencil"></span>';
                                echo '   Details';
                                echo '</a></td>';
                                
                                echo "</tr>";

                            }
                        ?>
                    </tbody>
                </table>
    </div>
</body>

</html>