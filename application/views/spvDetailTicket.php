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
<body>
    <nav class="navbar sticky-top navbar-expand-lg bg-dark"> 
        <?php echo '<a class="navbar-brand" href="'.base_url().'index.php/SpvController/dashboard','">';
                echo 'MMG SUPPORT'; 
                echo '</a>'; ?>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                
                    <li class="nav-item">
                        <a class="nav-link" href="#">Manage Users</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="#">Manage Customers</a>
                    </li>
                </li>
                </ul>
                    <?php
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
                            echo $userDetails[0]->userName;
                        }

                    ?>
                </li>
                <li class="list-group-item"><?php echo "Description: ".$details[0]['description'];?></li>
                
                <li class="list-group-item">Screenshot: <br><?php echo '<img src="'.$details[0]['picturePath'].'" style="width:60%">'; ?> </li>
                </ul>
                    <?php
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
                            <input type="submit" name="delegateBtn" class="btn-primary" value="Delegate Ticket">
                        </div>
                    </form>
                    <?php
                        echo form_close();
                    ?>
               
            
    </div>
    
</body>
</html>