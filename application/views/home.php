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

            show_notifications();

            function show_notifications(){
                $.ajax({
                    type: 'ajax',
                    url:<?php echo '"'.base_url().'index.php/UserController/loadNotifs'.'"'?>,
                    async: true,
                    dataType:'json',
                    success:function(data)
                    {
                        var html ='';
                        var i;
                        var notifAmount= data.length;
                        for(i=0;i<data.length;i++){
                            
                            html += '<a class="dropdown-item" href="#">'+
                            '<strong>'+data[i].ticketTitle+'</strong><br>'+
                            '<em>'+data[i].urgency+'</em><br>'+
                            '<small><em>'+data[i].customerName+'</em></small>'+
                            ' </a>';
                                    
                        }
                        $('.dropdown-menu').html(html);
                        if(data.length>0){
                            $('.count').html(data.length);
                        }
                        else{
                            $('.count').html(0);
                        }
                    }
                });    
            }

            

            $(document).on("click", "#dropdownMenuButton", function(){
                
             });
        });
    </script>
    
    
</head>
<body>

    <nav class="navbar sticky-top navbar-expand-lg bg-dark"> 
       <?php echo '<a class="navbar-brand" href="'.base_url().'index.php/UserController/dashboard','">';
            echo 'MMG SUPPORT'; 
            echo '</a>'; ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                        <?php
                            $loggedInUser = $this->session->userdata['isUserLoggedIn']['userID'];
                            echo '<a class="nav-link" href="'.base_url().'index.php/UserController/myTickets/'.$loggedInUser.'">My Tickets</a>';
                        ?>
                </li> 
            
            </ul>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Notifications: <span class="label label-pill label-danger count" style="border-radius:10px;"></span>
                </button>
                
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    
                </div>
            </div>


                <?php
                            echo '<a href="'.base_url().'index.php/UserController/logout','" style="margin-left: 3%">';
                            echo '<span class="fa fa-power-off"></span>';
                            echo '   Sign Out';
                            echo '</a>';
                ?>
            </a>
        </div>
    </nav>

    <div class="container bg-light">
        <h1>All Tickets</h1>
        <button id="testBtn">Test</button>
        <?php echo base_url().'index.php/UserController/viewNotifs'?>
        <table id="ticketList" class='table table-striped table-bordered'>
			        <thead>
				    <tr>
                        <th>ID</th>
                        <th>Token</th>
                        <th>Date Added</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        
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
                                $customerName = $value['customerName'];
                                $customerEmail = $value['customerEmail'];
                                $customerPhone = $value['customerPhone'];
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
                                echo "<td>".$customerName."</td>";
                                echo "<td>".$customerEmail."</td>";
                                
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
                                echo "<td>".$handledBy."</td>";
                                echo '<td><a class="btn btn-primary" name="btnDetail" href="'.base_url().'index.php/UserController/ticketDetails/'.$value['ticketID'].'">';
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
<footer class="page-footer" style="padding-top: 10%">
         <div class="footer-copyright text-center py-3">© PT Mitra Mentari Global
           <p>2019</p>
        </div>
</footer>
<script>
    
</script>
</html>