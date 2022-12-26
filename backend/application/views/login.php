<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Login Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>
      *, *::before, *::after {
        box-sizing: border-box;
    }
    body{
        background: #f5f5f5;
        margin: 0;
        font-family: 'Montserrat', sans-serif;
      }
      .container-box {
        text-align: center;
        display: flex;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        max-height: 100%;
        overflow: auto;
        padding: 70px 0 30px 0;
    }
        .box-inner{
            width: 500px;
    margin: auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 3px 3px 6px 0px rgb(0 0 0 / 5%);
    -moz-box-shadow: 3px 3px 6px 0px rgb(0 0 0 / 5%);
    padding: 20px 30px;
        }
        /* .cn_logo img {
    max-width: 100%;
    object-position: center;
    object-fit: cover;
    height: 100%;
} */
.cn_logo {
    width: 110px;
    height: 110px;
    margin: 0 auto;
    border-radius: 100%;
    background: #f5f5f5;
    display: block;
    overflow: hidden;
    border: solid 1px #f5f5f5;
    margin-top: -80px;
    margin-bottom: 20px;
}
.form-input {
    width: 100%;
    border: solid 1px #9d9d9d;
    transition: 0.5s all;
    font-size: 16px;
    padding: 0 10px;
    background: #fff;
    border-radius: 5px;
    height: 44px;
    font-weight: 400;
    font-size: 16px;
}
.input-area {
    position: relative;
    margin-bottom: 25px;
}
.input-area:last-child {
    margin-bottom: 0;
}
.input-label {
    top: -10px;
    font-size: 13px;
    z-index: 2;
    width: auto;
    font-weight: bold;
    margin: 0;
    position: absolute;
    background: #fff;
    transition: 0.3s all;
    height: 18px;
    left: 7px;
    padding: 0 4px;
    white-space: nowrap;
}

.btn-primary {
    color: #fff;
    background-color: #6f42c1;
    border-color: #6f42c1;
}

.btn-primary:hover {
    color: #fff;
    background-color: #5b30ac;
    border-color: #5b30ac;
}

.btn {
    padding: 8px 15px;
    border-radius: 5px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    border: solid 1px #6f42c1;
    transition: 0.5s all;
    box-shadow: 0px 0px 5px 2px rgb(217 196 255);
    -moz-box-shadow: 0px 0px 5px 2px rgb(217 196 255);
    display: inline-block;
    font-size: 18px;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}
.alert {
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}
.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}
.alert-warning {
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeeba;
}

.heading-tb-2 h2 {
    font-size: 30px;
    font-weight: 600;
    margin: 0 0 10px 0;
}

.heading-tb-2 p {
    margin: 0;
    font-size: 14px;
    color: #000;
}

@media(max-width:499px){
    .box-inner{width: 100%;}
    .container-box{
        padding: 70px 10px 30px 10px;
    }
}

.cn_logo img {
    vertical-align: middle;
    width: 93px;
    padding: 52px 0 0 0;
}

  </style>
</head>
<body>
    <div class="container-box">
       <di class="box-inner">
           <div>
            <div class="cn_logo">
                <img src="<?php echo base_url(); ?>assets/logo.png" />
            </div>
            <form class="form-signin" method="POST" action="<?php echo base_url();?>Login/login_check">
                <div class="cn_form">
                    <div class="input-area">
                        <!-- <div class="alert alert-success" role="alert">
                            This is a success alert—check it out!
                          </div> -->
                        <?php if($expired_sub == 1){
                        ?>
                            <div class="alert alert-danger" role="alert">
                                Your Subscription has expired, please renew it!
                            </div>
                        <?php
                        }else{
                            if($days_left <= 30){
                        ?>
                                <div class="alert alert-danger" role="alert">
                                    Your Subscription will expire after <?php echo $days_left; ?> days!
                                </div>
                        <?php
                            }
                        ?>
                        <?php
                        }
                        ?>
                        <?php if(!empty($this->session->flashdata('error_login'))) {?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $this->session->flashdata('error_login'); ?>
                                </div>
                        <?php
                        }
                        ?>
                          <!-- <div class="alert alert-warning" role="alert">
                            This is a warning alert—check it out!
                          </div> -->
                    </div>
                    <?php if($expired_sub == 0){
                    ?>
                        <div class="input-area">
                            <div class="heading-tb-2">
                                <h2>Login</h2>
                                <p>Fill details to Login your account</p>
                            </div>
                        </div>
                        <div class="input-area">                    
                            <input type="tex" class="form-input" id="inputEmail" name="mobile_number" required />  
                            <label class="input-label">User Name</label>                  
                        </div>
                        <div class="input-area">                    
                            <input type="password" class="form-input" id="inputPassword" name="password" required />  
                            <label class="input-label">Password</label>                  
                        </div>
                        
                        <div class="input-area">
                            <button class="btn btn-primary" type="submit">Submit</button>             
                        </div>
                    <?php }
                    ?>
                </div>
            </form>
           </div>
       </di>
    </div>

</body>
</html>
