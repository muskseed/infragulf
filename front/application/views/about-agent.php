<!doctype html>
<html lang="en">
  <head>   
    <title>About Agent</title>
    <meta charset="utf-8">              
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php 
      $this->load->view('common_file/style');
    ?>    
  </head>
  <body>
  
  <?php 
  $this->load->view('common_file/header');
  ?>

  <section class="banner-section sell-section p-relative bg-dark p-tb-7">
    
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <div class="hading-section">
              <div class="profile-img">
                <img class="img-fluid" src="<?php echo ADMIN_URL.BANNER_UPLOAD_PATH.$team_data[0]['image_name']; ?>" align="expert 1">
              </div>
              <h1 class="title"><span><?php echo $team_data[0]['name']; ?></span></h1>
                     
            </div>
          </div>
        </div>
      </div>
    </div>   
  </section>

  <section class="property-breadcrumb">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <ul class="breadcrumb">
            <li>
              <a href="<?php echo BASE_URL; ?>">
                <img src="<?php echo BASE_URL; ?>assets/images/home-icon.svg">
              </a>
            </li>
            <li><?php echo $team_data[0]['name']; ?></li>
            
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="property-detail-secion p-tb-2">
    <div class="container">
      <div class="row">        
        <div class="col-lg-4">
          <div class="fig-details m-0">
            <div class="dt-wrapper abt-agent">
              <div class="img-card p-relative">
                  <div class="exp-img agent-img">
                    <img class="img-fluid" width="344" height="220" src="<?php echo ADMIN_URL.BANNER_UPLOAD_PATH.$team_data[0]['image_name']; ?>" align="expert 1">
                  </div>
                  <div class="exp-action text-center">
                    <h4><?php echo $team_data[0]['name']; ?></h4>
                    <div class="act-list mt-1">
                      <a href="tel:<?php echo $team_data[0]['mobile']; ?>">
                        <img src="<?php echo BASE_URL; ?>assets/images/call-full-icon.svg">
                      </a>
                      <a href="mailto:<?php echo $team_data[0]['email']; ?>">
                        <img src="<?php echo BASE_URL; ?>assets/images/email-icon.svg">
                      </a>
                      <!-- <a href="https://api.whatsapp.com/send?phone=<?php echo $team_data[0]['whatsapp']; ?>&text=Hi, I have a few questions. Can you help?">
                        <img src="<?php echo BASE_URL; ?>assets/images/whatsapp-icon.svg">
                      </a> -->
                    </div>
                  </div>
                </div>                           
              <div class="mt-1">
                <a class="btn btn-primary d-block btn-whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $team_data[0]['whatsapp']; ?>&text=Hi, I have a few questions. Can you help?">
                  <img src="<?php echo BASE_URL; ?>assets/images/whatsapp-white.svg"> WhatsApp
                </a>
              </div>
            </div>          
          </div>
        </div>
        <div class="col-lg-8">
          <div class="lg-mt-1"> 
            <h3 class="title-3 mb-1">
              About Me
            </h3>           
            <p class="pr-list">
              <?php echo $team_data[0]['description']; ?>
            </p>
          </div>
        </div>
      </div>            
    </div>
  </section>
    <section class="get-in-touch-section p-tb-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <div class="hading-section">
              <h1 class="title">Get in touch <span>with us</span></h1>   
              <p class="title-text">And Our Specialists Will Contact You</p>                   
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-5 m-auto">
                
                <div class="form-box mt-3">
                  <div class="hading-section text-center">
                    <h3 class="title-2">Quick Response Guaranteed</h3>
                    <p class="mt-1">Reference site about Lorem Ipsum, giving information on its origins</p>
                  </div>
                  <form class="mt-3">
                    <div class="form-input">
                      <input class="form-control" type="text" placeholder="Name" id="name" name="name" required>
                      <span id="name-error" style="color: white;"></span>
                    </div>
                    <div class="form-input">
                      <input class="form-control" type="email" placeholder="Email" id="email" name="email" required>
                      <span id="email-error" style="color: white;"></span>
                    </div>
                    <div class="form-input">
                      <input class="form-control" type="number" placeholder="Mobile" id="mobile" name="mobile" required>
                      <span id="mobile-error" style="color: white;"></span>
                    </div>
                    <div class="form-input">
                      <button type="button" id="submit_form" class="btn btn-primary d-block">Submit</button>
                      <span id="submit_form-error" style="color: green;"></span>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

 <?php 
 $this->load->view('common_file/footer');
 ?>
      
  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>
  
  <script>
    $("#submit_form").click(function(){
      $("#name-error").text(' ');
      $("#email-error").text(' ');
      $("#mobile-error").text(' ');
      var name_modal = $("#name").val();
      var email_modal = $("#email").val();
      var mobile_modal = $("#mobile").val();
      var name_id = 'name';
      var email_id = 'email';
      var mobile_id = 'mobile';
      var submit_id = 'submit_form';
      // console.log(email_modal);
      refister_function(name_modal , email_modal , mobile_modal , name_id , email_id , mobile_id , submit_id);
    })
    function refister_function(name_modal , email_modal , mobile_modal , name_id , email_id , mobile_id , submit_id){
      var submit_flag = 1;

      if(!name_modal){
        submit_flag = 0;
        $("#"+name_id+"-error").text('Please Enter Name');
      }

      if(!email_modal){
        submit_flag = 0;
        $("#"+email_id+"-error").text('Please Enter Email');
      }

      if(!mobile_modal){
        submit_flag = 0;
        $("#"+mobile_id+"-error").text('Please Enter Mobile');
      }

      if(submit_flag == 1){
        $.ajax({
          url : "<?php echo base_url(); ?>sell/register",
          type: "POST",
          data: {name_modal : name_modal , email_modal : email_modal , mobile_modal : mobile_modal},
          dataType: "json",
          beforeSend: function() {
            $("#loader").show();
          },
          success: function(result){
            $("#loader").hide();
            if(result.status == 'success'){
              // $("#"+submit_id+"-error").text(result.msg);
              // window.setTimeout(function(){location.reload()},5000)
              window.location.href='<?php echo base_url(); ?>Thanks'
            }else{
              $("#"+submit_id+"-error").text(result.msg);
            }
          }
        });
      }
    }
  </script>
  </body>
</html>