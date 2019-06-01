<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ticket Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
    <script>
         $(document).ready(function(){
            $('#ticketList').dataTable();

            show_notifications();
            show_feedback_notifications();

            function show_notifications(){
                $.ajax({
                    type: 'ajax',
                    url:<?php echo '"'.base_url().'index.php/SpvController/loadNotifs'.'"'?>,
                    async: true,
                    dataType:'json',
                    success:function(data)
                    {
                            var html ='';
                            var i;
                            var notifAmount= data.length;
                            if(data.length>0){
                                for(i=0;i<data.length;i++){
                                    
                                    html += '<a class="dropdown-item" href="<?php echo base_url().'index.php/SpvController/viewNotifs/';?>'+data[i].ticketID+'">'+
                                    '<strong>New Ticket available</strong><br>'+
                                    '<strong>Title: '+data[i].ticketTitle+'</strong><br>'+
                                    'Urgency: <em>'+data[i].urgency+'</em><br>'+
                                    '<small>Cust: <em>'+data[i].customerName+'</em></small><br>'+
                                    '<small>Delegated By: <em>'+data[i].delegatedBy+'</em></small>'+
                                    ' <hr></a>';
                                            
                                }
                             $('#ticket-list').html(html);
                       
                            $('#ticket-count').html(data.length);
                        }
                        else{
                            html += "<p>No New Notifications</p>";
                            $('#ticket-list').html(html);
                            $('#ticket-count').html(0);
                        }
                    }
                });    
            }

            function show_feedback_notifications(){
                $.ajax({
                    type: 'ajax',
                    url:<?php echo '"'.base_url().'index.php/UserController/loadFeedbackNotifs'.'"'?>,
                    async: true,
                    dataType:'json',
                    success:function(data)
                    {
                            var html ='';
                            var i;
                            var notifAmount= data.length;
                            if(data.length>0){
                                for(i=0;i<data.length;i++){
                                    
                                    html += '<a class="dropdown-item" href="<?php echo base_url().'index.php/SpvController/viewFeedbackNotifs/';?>'+data[i].ticketID+'">'+
                                    '<strong>New Feedback Received</strong><br>'+
                                    '<strong>Title: '+data[i].ticketTitle+'</strong><br>'+
                                    'Urgency: <em>'+data[i].urgency+'</em><br>'+
                                    '<small>Cust: <em>'+data[i].customerName+'</em></small><br>'+
                                    '<small>Approved: <em>'+data[i].approved+'</em></small><br>'+
                                    ' <hr></a>';
                                            
                                }
                             $('#feedback-list').html(html);
                       
                            $('#feedback-count').html(data.length);
                        }
                        else{
                            html += "<p>No New Notifications</p>";
                            $('#feedback-list').html(html);
                            $('.feedback-count').html(0);
                        }
                    }
                });    
            }

                $(document).on("click", "#dropdownMenuButton", function(){
                    
                });
            });

         
    </script>
</head>

<body class="backgrnd">
<nav class="navbar sticky-top navbar-expand-lg bg-dark"> 
       <?php echo '<a class="navbar-brand" href="'.base_url().'index.php/SpvController/dashboard','">';
            echo 'MMG SUPPORT'; 
            echo '</a>'; ?>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <?php
                        //$loggedInUser = $this->session->userdata['isUserLoggedIn']['userID'];
                        echo '<a class="nav-link" href="'.base_url().'index.php/SpvController/dashboard','">Home</a>';
                    ?>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">My Tickets<span class="sr-only">(current)</span></a>
                </li>                
            </ul>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        New Tickets: <span class="label label-pill label-danger" id="ticket-count" style="border-radius:10px;"></span>
                    </button>
                    
                    <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuButton" id="ticket-list">
                        
                    </div>
                </div>

                <?php
                    echo '<a style="color: white; margin-left: 1%">'.$this->session->userdata['isUserLoggedIn']['userName'].'</a>';
                    echo '<a href="'.base_url().'index.php/UserController/logout','" style="margin-left: 3%">';
                    echo '<span class="fa fa-power-off"></span>';
                    echo '    Sign Out';
                    echo '</a>';
                ?>
            
        </div>
    </nav>

    <div class="container bg-light">
        <h1>All Handled Tickets</h1>
        <hr>
        <div class="dropdown" style="margin-bottom:3%">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                New Feedbacks: <span class="label label-pill label-danger" id="feedback-count" style="border-radius:10px;"></span>
            </button>
            <div class="feedback-dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuButton" id="feedback-list">
                    
            </div>
        </div>
        <table id="ticketList" class='table table-striped table-bordered' cellspacing='0'>
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
                        <th>Details & Actions</th>
                        
				    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if($ticketData==null){

                            }
                            else{
                                foreach($ticketData as $key => $value){
                                    $id = $value['ticketID'];
                                    $token = $value['token'];
                                    $dateAdded = $value['dateAdded'];
                                    $dateFinished = $value['dateUpdated'];
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
                                    if($handledBy == null){
                                        echo "<td><i>";
                                        echo "Not Yet";
                                        echo "</i></td>";
                                    }
                                    else{
                                        echo "<td>".$value['userName']."</td>";
                                    }
                                    echo '<td><a class="btn btn-primary" name="btnDetail" href="'.base_url().'index.php/SpvController/ticketActions/'.$value['ticketID'].'">';
                                    echo '<span class="fa fa-pencil"></span>';
                                    echo '   Actions';
                                    echo '</a></td>';
                                    
                                    echo "</tr>";
    
                                }
                            }
                            
                        ?>
                    </tbody>
                </table>

    </div>
</body>

</html>