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
                            echo '<a class="nav-link" href="'.base_url().'index.php/SpvController/dashboard">Home</a>';
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php 
                            $loggedInUser = $this->session->userdata['isUserLoggedIn']['userID'];
                            echo '<a class="nav-link" href="'.base_url().'index.php/SpvController/spvTickets/'.$loggedInUser.'">My Tickets</a>';
                        ?>
                    </li> 

                </ul>
                </ul>
                    <?php
                                echo '<a style="color: white; margin-right: 1%">'.$this->session->userdata['isUserLoggedIn']['userName'].'</a>';
                                echo '<a href="'.base_url().'index.php/SpvController/logout','">';
                                echo '<span class="fa fa-power-off"></span>';
                                echo '   Sign Out';
                                echo '</a>';
                    ?>
            </div>
    </nav>
    <div class="container">
        <h1>Ticket Details</h1>
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
                <li class="list-group-item"><?php echo "Ticket #: ".$details[0]['token'];?></li>
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
                <?php
                     $interval = date_diff(date_create($details[0]['dateAdded']), date_create($details[0]['dateUpdated']));
                     $intervalAmount = $interval->format('%R%a');
                ?>
                <li class="list-group-item"><?php echo "Interval between ticket added and last updated: ".$intervalAmount." days";?></li>
                <li class="list-group-item"><?php echo "Description: ".$details[0]['description'];?></li>
                <li class="list-group-item">
                    <?php echo "Customer Feedback: ";
                    
                        if($details[0]['feedback']!=null){
                            echo $details[0]['feedback'];
                        }
                        else echo "<i>No Feedback Yet</i>";
                    ?>
                </li>
                
                <li class="list-group-item">
                    <?php echo "Approval Status: ";
                        if($details[0]['approved'] != null && $details[0]['approved']==1){
                            echo "<i>Approved</i>";
                        }
                        elseif($details[0]['approved'] != null && $details[0]['approved']==0){
                            echo "<i>Not Approved</i>";
                        }
                        else{
                            echo "<i>Not Yet Approved</i>";
                        }
                
                    ?>
                
                <li class="list-group-item">Screenshot: <br><?php echo '<img src="'.$details[0]['picturePath'].'" style="width:60%">'; ?> </li>
                
                    <?php
                        echo '<li class="list-group-item">';
                        echo (form_open('SpvController/delegateTicket/'.$details[0]['ticketID']));
                        if($details[0]['userID']==null){
                            echo '<p>Ticket Not Yet Handled</p>';
                        }
                    ?>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="userID">Delegate Ticket to: </label>
                            <select name="userID" required="">
                                <?php
                                    foreach($availUsers as $key =>$value){
                                        echo '<option value="'.$value['userID'].'">'.$value['userName'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="delegateBtn" class="btn btn-primary" value="Delegate Ticket">
                        </div>
                    </form>
                    <?php
                        echo form_close();
                        echo '</li>';
                        
                        if($details[0]['status']==1){
                            echo '<li class="list-group-item">';
                            echo 'Handle ticket: ';
                            echo '<a class="btn btn-primary" href="'.base_url().'index.php/SpvController/takeTicket/'.$details[0]['ticketID'].'">Handle Ticket</a>';
                            echo '</li>';
                        }
                        else{
                            echo '<li class="list-group-item">';
                            echo 'Handle ticket: ';
                            echo '<button class="btn btn-primary" disabled>Ticket Handled!</button>';
                            echo '</li>';
                        }
               
                    ?>
                </ul>
               
            
    </div>
    
</body>
</html>