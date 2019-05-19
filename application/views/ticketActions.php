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
                <a href ="#" class= "my-2 my-lg-0">
                    <button style="margin-right:20px">Notifications: </button>

                    <?php
                                echo '<a href="'.base_url().'index.php/UserController/logout','">';
                                echo '<span class="fa fa-power-off"></span>';
                                echo '   Sign Out';
                                echo '</a>';
                    ?>
                </a>
            </div>
    </nav>
<div class="container">
        <div class="row">
        <div class="col-sm-6">
            <h1>Ticket Details</h1>
                <?php
                    /*if(!empty($success_msg)){
                        echo '<div style="color: blue;"
                            <h3 class="statusMsg">'.$success_msg.'</h3></div>';
                    }elseif(!empty($error_msg)){
                        echo ' <div style="color: red;">
                            <h3 class="statusMsg">'.$error_msg.'</h3></div>';
                    }*/
                    if($this->session->flashdata('success')!=null){
                        echo '<p style="color:blue">'.$this->session->flashdata('success').'</p>';
                    }
                    elseif($this->session->flashdata('fail')!=null){
                        echo '<p style="color:red">'.$this->session->flashdata('fail').'</p>';
                    }
                            
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
                    
                    <li class="list-group-item">Screenshot: <br><?php echo '<img src="'.$details[0]['picturePath'].'" style="width:60%">'; ?> 
                        <br><a href='<?php echo "".$details[0]['picturePath']."";?>'>View full size</a>
                    </li>
                    
                    
                </ul>
        </div>
        <div class="col-sm-6">
            <h1>Actions</h1>

            <?php echo form_open('UserController/updateTicket/'.$details[0]['ticketID']); ?>
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="changes">Changes Made</label>
                        <textarea  class="form-group" rows="10" cols="80" name="changes" required=""></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" required="">
                            <option value=2>Ongoing</option>
                            <option value=3>Closed</option>
                            <option value=1>Open</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submitChanges" class="btn-primary" value="Submit Changes"/>
                    </div>
                </form>
                <?php echo form_close(); ?>
           
            
            <p><strong>Changelog</strong></p>
            <table id="changelog" class='table table-striped table-bordered' cellspacing='0' style="margin-top:3%">
                <thead>
                <tr>
                        <th>Changelog ID</th>
                        <th>Ticket ID</th>
                        <th>Worked By</th>
                        <th>Date Updated</th>
                        <th>Status</th>
                        <th>Description</th>
                        
				    </tr>
                </thead>
                <tbody>
                <?php 
                    if($changelog == false){
                        echo "<tr>";
                        echo "<td> No Data Yet </td>";
                        echo "</tr>";
                    }
                    else{
                        foreach($changelog as $key => $value){
                            $changeId = $value['changeID'];
                            $ticketId = $value['ticketID'];
                            $workedBy = $value['userID'];
                            $dateUpdated = $value['dateUpdated'];
                            $status = $value['status'];
                            $description = $value['description'];
                            
    
                                    echo "<tr>";
                                    echo "<td>".$changeId."</td>";
                                    echo "<td>".$ticketId."</td>";
                                    echo "<td>".$workedBy."</td>";
                                    echo "<td>".$dateUpdated."</td>";
                                    if($status==1){
                                        echo "<td><b>Open</b></td>";
                                    }
                                    elseif($status==2){
                                        echo "<td><b>Ongoing</b></td>";
                                    }
                                    elseif($status==3){
                                        echo "<td><b>Closed</b></td>";
                                    }
                                    echo "<td>".$description."</td>";
                                    
                                    
                                    echo "</tr>";
    
                         }
                    }
                   
                ?>             
                </tbody>
            </table>
            <p><strong>Customer Feedback</strong></p>
            <ul>
            <?php
                if($details[0]['approved']==0){
                    echo '<li>Approved: <b><i>Not Yet</i></b></li>';
                }else{
                    echo '<li>Approved: <b>Approved</b></li>';
                }
                
                if($details[0]['feedback']==null){
                    echo '<li>Feedback: <i>No Feedback Yet</i></li>';
                }else{
                    echo '<li>Feedback: '.$details[0]['feedback'].'</li>';
                }
                
            ?>
            </ul>
        </div>
        
    </div>
</div>

</body>

<footer class="page-footer" style="padding-top: 10%">
         <div class="footer-copyright text-center py-3">© PT Mitra Mentari Global
           <p>2019</p>
        </div>
</footer>

</html>