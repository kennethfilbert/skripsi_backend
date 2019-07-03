<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Support</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        echo $js;
		echo $css;
    ?>
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
                <p style="text-align:center">SUPPORT</p>
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
                
        <!--<h1 style="margin-bottom: 100%">This is the home page of the customer side website</h1>-->
            
            <div style="margin:2%;">
                <div class="navbar backgrnd" style="padding-bottom:-5%">
                        <?php 
                            $displayName = $this->session->userdata['isUserLoggedIn']['customerUsername'];
                            echo '<h5>Welcome, '.$displayName.'!</h5>'; 
                        ?>
                        <span class="navbar-text" id="clock"></span>
                </div>
                <?php echo form_open_multipart('Main/addNewTicket'); ?>
                <form role="form" class="form-horizontal" action=""  method="post" style="margin: 3%">
                    
                        <?php
                            
                            if($this->session->flashdata('success')!=null){
                                echo '<p style="color:blue">'.$this->session->flashdata('success').'</p>';
                            }
                            elseif($this->session->flashdata('fail')!=null){
                                echo '<p style="color:red">'.$this->session->flashdata('fail').'</p>';
                            }
    
                        ?>
                     
                        <h2>Contact Info</h2>
                        <h5>Please enter your support details below</h5>
                        <h5>Fields marked with * are required</h5>
                        <hr style="width: 100%; height:20px">
                       
                        <div class="form-group">
                            <label for="name"><b>Name *</b></label>
                            <input type="text" class="form-control" name="name" required="" value="<?php echo $this->session->userdata['isUserLoggedIn']['customerUsername']; ?>">
                            <?php echo form_error('name','<span class="help-block">','</span>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="email"><b>E-mail *</b></label>
                            <input type="text" class="form-control" name="email" required="" value="<?php echo $this->session->userdata['isUserLoggedIn']['customerEmail']; ?>">
                            <?php echo form_error('name','<span class="help-block">','</span>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="phone"><b>Phone no. *</b></label>
                            <input type="text" class="form-control" name="phone" required="" value="<?php echo $this->session->userdata['isUserLoggedIn']['customerPhone']; ?>">
                            <?php echo form_error('name','<span class="help-block">','</span>'); ?>
                        </div>
                        <h2>Ticket Info</h2>
                        <hr style="width: 100%; height:20px">
                        <div class="form-group">
                            <label for="title"><b>Title (general idea) *</b></label>
                            <input type="text" class="form-control" name="title" required="" >
                            <?php echo form_error('name','<span class="help-block">','</span>'); ?>
                        </div>
                        <label for="product"><b>Product *</b></label>
                        <div class="form-group">
                            <select name="product">
                            <?php
                                 foreach($products as $key => $value){
                                    echo '<option value="'.$value['productName'].'">'.$value['productName'].'</option>';
                                 }
                                 
                            ?>
                            <option value="Others">Others/Unrelated</option>
                            </select>
                        </div>
                        <label for="inquiry"><b>Inquiry Type *</b></label>
                        <div class="form-group">
                            <select name="inquiry">
                                
                                <option value="Complaint">Problem report/Complaint</option>
                                <option value="Question">Questions</option>
                                <option value="Critique/Suggestion">Critique/Suggestion</option>
                            </select>
                        </div>
                        <label for="urgency"><b>Urgency *</b></label>
                        <div class="form-group">
                            <select name="urgency">
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>
                            <label for="description"><b>Description *</b></label>
                                <!--<div id="editor" name="description" class="form-group" style="height: 300px; width: 600px">
                                    <textarea name="descriptiontext"></textarea>
                                </div>-->
                            <div class="form-group">
                                <textarea name="descriptiontext" class="form-group" rows="10" cols="90" required=""></textarea>
                            </div>
                            <div class="form-group">
                                <label for="picture">Screenshots (if any) Accepted image formats: .img, .png, .gif</label>
                                <input class="form-control" type="file" name="picture" id="picture" multiple="multiple">
                            </div>
                            <div class="form-group>">
                                <label for="pv">Preview: </label>
                                <img name="pv" id="preview" src="#" style="height:25%; width:25%; margin-bottom: 1%"/>
                             </div>
                            <div class="form-group">
                                <input type="submit" name="confirm" class="btn btn-primary" value="Submit"/>
                            </div>
                    </form>
                    <?php echo form_close(); ?>
            </div>
        </div>
        
        <script>
            var quill = new Quill('#editor', {
                theme: 'snow'
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                    }
                    
                    reader.readAsDataURL(input.files[0]);
                }
            }
    
            $("#picture").change(function(){
                readURL(this);
            });

            var now = new Date(<?php echo time() * 1000 ?>);
            function startInterval(){  
                setInterval('updateTime();', 1000);  
            }
            startInterval();
            function updateTime(){
                var nowMS = now.getTime();
                nowMS += 1000;
                now.setTime(nowMS);
                var clock = document.getElementById('clock');
                if(clock){
                    clock.innerHTML = now.toLocaleString();       
                }
            } 
        </script>
    
</body>
</html>
