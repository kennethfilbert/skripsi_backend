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
        show_notifications();
            show_feedback_notifications();

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
                            if(data.length>0){
                                for(i=0;i<data.length;i++){
                                    
                                    html += '<a class="dropdown-item" href="<?php echo base_url().'index.php/UserController/viewNotifs/';?>'+data[i].ticketID+'">'+
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
                                    
                                    html += '<a class="dropdown-item" href="<?php echo base_url().'index.php/UserController/viewFeedbackNotifs/';?>'+data[i].ticketID+'">'+
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
    </script>
</head>
<body class="backgrnd">
    <nav class="navbar sticky-top navbar-expand-lg bg-dark"> 
        <?php echo '<a class="navbar-brand" href="'.base_url().'index.php/UserController/dashboard','">';
                echo 'MMG SUPPORT'; 
                echo '</a>'; ?>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <?php
                            $loggedInUser = $this->session->userdata['isUserLoggedIn']['userID'];
                            echo '<a class="nav-link" href="'.base_url().'index.php/UserController/myTickets/'.$loggedInUser.'">My Tickets</a>';
                        ?>
                    </li>
                    </ul>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            New Tickets: <span class="label label-pill label-danger" id="ticket-count" style="border-radius:10px;"></span>
                        </button>
                        
                        <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuButton" id="ticket-list">
                            
                        </div>
                    </div>
                </div>
                    <?php
                        echo '<a style="color: white; margin-left: 1%; margin-right: 1%">'.$this->session->userdata['isUserLoggedIn']['userName'].'</a>';
                        echo '<a href="'.base_url().'index.php/UserController/logout','">';
                        echo '<span class="fa fa-power-off"></span>';
                        echo '   Sign Out';
                        echo '</a>';
                    ?>
                
            </div>
    </nav>
    <div class="container bg-light">
        <h1>Ticket Details</h1>
        <hr>
            <div class="dropdown" style="margin-bottom:3%">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    New Feedbacks: <span class="label label-pill label-danger" id="feedback-count" style="border-radius:10px;"></span>
                </button>
                
                <div class="feedback-dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuButton" id="feedback-list">
                    
                </div>
            </div>
            <?php
                /*if(!empty($success_msg)){
                    echo '<div style="color: blue;"
                        <h3 class="statusMsg">'.$success_msg.'</h3></div>';
                }elseif(!empty($error_msg)){
                    echo ' <div style="color: red;">
                        <h3 class="statusMsg">'.$error_msg.'</h3></div>';
                }*/
                echo '<h3 style="color:blue">'.$this->session->flashdata('success').'</h3>';
                        
            ?>  
            <ul class="list-group">
                <li class="list-group-item"><?php echo "Ticket ID: ".$details[0]['ticketID'];?></li>
                <li class="list-group-item"><?php echo "Token #: ".$details[0]['token'];?></li>
                <li class="list-group-item"><?php echo "Date Added: ".$details[0]['dateAdded'];?></li>
                <li class="list-group-item"><?php echo "Title/General Idea: ".$details[0]['ticketTitle'];?></li>
                <li class="list-group-item"><?php echo "Customer Name: ".$details[0]['customerName'];?></li>
                <li class="list-group-item"><?php echo "Customer Email: ".$details[0]['customerEmail'];?></li>
                <li class="list-group-item"><?php echo "Customer Phone No.: ".$details[0]['customerPhone'];?></li>
                <li class="list-group-item"><?php echo "Product Name: ".$details[0]['productName'];?></li>
                <li class="list-group-item"><?php echo "Inquiry Type: ".$details[0]['inquiryType'];?></li>
                <li class="list-group-item"><?php echo "Urgency: ".$details[0]['urgency'];?></li>
                <li class="list-group-item">
                    <?php 
                        if($details[0]['status']==1){
                            echo "Status: <b>Open</b>";
                        }
                        if($details[0]['status']==2){
                            echo "Status: <b>Ongoing</b>";
                        }
                        if($details[0]['status']==3){
                            echo "Status: <b>Closed</b>";
                        }
                    ?>
            
                </li>
                <li class="list-group-item">
                    <?php echo "Handled By: ";
                        if($details[0]['userID'] == null){
                            echo "<i>";
                            echo "Not Yet";
                            echo "</i>";
                        }
                        else{
                            echo $userDetails[0]['userName'];
                        }

                    ?>
                </li>
                <li class="list-group-item"><?php echo "Date Updated: ".$details[0]['dateUpdated'];?></li>
                <li class="list-group-item"><?php echo "Description: ".$details[0]['description'];?></li>
                <li class="list-group-item"><?php 
                    if($details[0]['approved']==1)
                        echo "Approved: Yes";
                    else 
                        echo "Approved: No";
                ?></li>
                <li class="list-group-item"><?php echo "Feedback: ".$details[0]['feedback'];?></li>
                
                <li class="list-group-item">Screenshot: <br><?php echo '<img src="'.$details[0]['picturePath'].'" style="width:60%">'; ?> </li>
                <?php
                    if($details[0]['status']==1){
                        echo '<li class="list-group-item">';
                        echo '<a class="btn btn-primary" href="'.base_url().'index.php/UserController/takeTicket/'.$details[0]['ticketID'].'">Handle Ticket</a>';
                        echo '</li>';
                    }
                    else{
                        echo '<li class="list-group-item">';
                        echo '<button class="btn btn-primary" disabled>Ticket Handled!</button>';
                        echo '</li>';
                    }
                ?>
               
            </ul>
    </div>
    
</body>
</html>