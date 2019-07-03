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
			//$(document).ready(function(){
			//	$('#changelog').DataTable();
			//});

	</script>
</head>
<body>
    <div class="wrapper">
            <nav id="sidebar">
                <div class="sidebar-header">
                <?php
                    echo '<a href="'.base_url().'index.php/Main/dashboard">';
                    echo '<img src="http://159.89.197.191/~careermmg/assets/mmg.png" style=" display: block;
                        margin-left: auto;
                            margin-right: auto;
                            width: 70%">';
                    echo '</a>';
                ?>
                <p style="text-align:center">SUPPORT</p>;
                </div>
                
            
                <ul class="list-unstyled components" style="margin-left: 3%; margin-right: 3%">   
                <p style="text-align:center"><b>Actions</b></p>
                <hr>
                    <li style="background: white; padding:5%; border-radius:25px">
                        <?php
                            echo '<a href="'.base_url().'index.php/Main/homepage">';
                            echo '<span class="fa fa-home"></span>';
                            echo "   Submit a Ticket";
                            echo '</a>';
                        ?>
                    </li>
                    <hr>
                    <li style="background: white; padding:5%; border-radius:25px">
                        <?php
                            $loggedInUser = $this->session->userdata['isUserLoggedIn']['customerID'];
                            //echo $this->session->userdata('isUserLoggedIn');
                            echo '<a href="'.base_url().'index.php/Main/profile/'.$loggedInUser.'">';
                            echo '<span class="fa fa-user"></span>';
                            echo '   My Profile';
                            echo '</a>';
                        ?>
                    </li>
                    <hr>
                    <li style="background: white; padding:5%; border-radius:25px">
                        <?php
                            echo '<a href="'.base_url().'index.php/Main/contactUs','">';
                            echo '<span class="fa fa-info-circle"></span>';
                            echo '   Contact Us';
                            echo '</a>';
                        ?>
                    </li>
                    <hr>
                    <li style="background: white; padding:5%; border-radius:25px">
                        <?php
                            echo '<a href="'.base_url().'index.php/Main/logout','">';
                            echo '<span class="fa fa-power-off"></span>';
                            echo '   Sign Out';
                            echo '</a>';
                        ?>
                    </li>
                    <hr>
                </ul>
                <footer>
                    <div class="footer-copyright text-center py-3">© PT Mitra Mentari Global
                        <p>2019</p>
                    </div>
                </footer>
            </nav>

            <div style="margin:2%;">
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
                <li class="list-group-item"><?php echo "Ticket Number: ".$details[0]['token'];?></li>
                <li class="list-group-item"><?php echo "Date Added: ".$details[0]['dateAdded'];?></li>
                <li class="list-group-item"><?php echo "Ticket Title: ".$details[0]['ticketTitle'];?></li>
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
                            echo $adminDetails[0]['userName'];
                        }

                    ?>
                </li>
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
                
                <li class="list-group-item" >Screenshot: <br>
                    <img id="screenShot" src='<?php echo "".$details[0]['picturePath']."";?>' class="abs" style="width:60%">  
                    <br><a href='<?php echo "".$details[0]['picturePath']."";?>'>View full size</a>
                </li>
            </ul>
            
            <div id="imgModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01">

            </div>


        </div>
        <div class="container-sm" style="margin:3%;  border-left: 1px solid black; padding-left: 5%">
        <h4>Changelog / Work History</h4>
            <table id="changelog" class='table table-striped table-bordered' cellspacing='0' style="margin-top:3%">
                <thead>
                <tr>
                        <th>Changelog ID</th>
                        <th>Ticket ID</th>
                        <th>Worked By</th>
                        <th>Date Updated</th>
                        <th>Description</th>
                      
				    </tr>
                </thead>
                <tbody>
                <?php 
                    if($changelog == false){
                        echo "<tr>";
                        echo '<td rowspan="5"> No Data Yet </td>';
                        echo "</tr>";
                    }
                    else{
                        foreach($changelog as $key => $value){
                            $changeId = $value['changeID'];
                            $ticketId = $value['ticketID'];
                            $workedBy = $value['userID'];
                            $dateUpdated = $value['dateUpdated'];
                            $description = $value['description'];
                            
    
                                    echo "<tr>";
                                    echo "<td>".$changeId."</td>";
                                    echo "<td>".$ticketId."</td>";
                                    if($workedBy == null){
                                        echo "<td><i>";
                                        echo "Not Yet";
                                        echo "</i></td>";
                                    }
                                    else{
                                        echo "<td>".$adminDetails[0]['userName']."</td>";
                                    }
                                    echo "<td>".$dateUpdated."</td>";
                                    echo "<td>".$description."</td>";
                                    echo "</tr>";
    
                         }
                         
                    }
                    
                   
                ?>             
                </tbody>
            </table>
            <?php
                if($details[0]['status'] == 3 && $details[0]['approved']==null && $details[0]['feedback']==null){
                    echo "Were you satisfied with the changes made? <br>";
                    //echo '<a class="btn btn-primary" style="margin:2%" name="btnYes" href="'.base_url().'index.php/Main/ticketDetails/'.$value['ticketID'].'">';
                    echo form_open_multipart('Main/addFeedback/'.$details[0]['ticketID']); 
                        echo '<form role="form" class="form-horizontal" action=""  method="post" style="margin: 3%">';
                            echo '<div class="form-group">';
                                echo '<input type="radio" name="feedRadio" value=1 required="">';
                                echo "Yes<br>";
                                //echo '<a class="btn btn-danger" name="btnNo" href="'.base_url().'index.php/Main/ticketDetails/'.$value['ticketID'].'">';
                                echo '<input type="radio" name="feedRadio" value=0 required="">';
                                echo "No<br>";
                            echo '</div>';
                            echo '<div class="form-group">';
                                echo '<label for="feedbackText">Please give your feedback below:</label><br>';
                                echo '<textarea name="feedbackText" class="form-group" rows="10" cols="60" required=""></textarea>';
                            echo '</div>';
                            echo '<input class="btn btn-primary" type="submit" value="Submit Your Feedback">';
                        echo '</form>';
                    echo form_close();
                    
                }
                elseif($details[0]['approved']!=null && $details[0]['feedback']!=null){
                    echo '<p><b>Thank you for your feedback!</b></p>';
                }
            ?>
        </div>
    </div>
</body>

</html>