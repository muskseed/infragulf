<!doctype html>
<html lang="en">
  <head>   
    <title>Get the Best Sell Price for Luxury Villas, Apartments in Dubai</title>
    <meta charset="utf-8">
    <meta name="description" content="Wish to sell your luxurious villas, vista homes, apartments in Dubai? Get the best prices for your properties with us. Call +971 52 194 0000 now.">
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
              <h1 class="title">Sell <span>Properties</span></h1>
              <p class="title-text mt-1">With years of experience in the industry, we represent sellers and buyers for residential, investment and commercial properties. We will guide you through the entire process from beginning to end.</p>              
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
            <li>Sell</li>
            
          </ul>
        </div>
      </div>
    </div>
  </section>


  <section class="sell-form-section p-tb-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <div class="hading-section">
              <h1 class="title">Fill out <span>the form</span></h1>   
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
                    <h3 class="title-2">Drop your contact details below</h3>
                    <p class="mt-1">We’ll get in touch with you</p>
                  </div>
                  <form class="mt-3">
                    <div class="form-input">
                      <input class="form-control" type="text" placeholder="Name" id="name" name="name" required>
                      <span id="name-error" style="color: red;font-size: 12px;"></span>
                    </div>
                    <div class="form-input">
                      <input class="form-control" type="email" placeholder="Email" id="email" name="email" required>
                      <span id="email-error" style="color: red;font-size: 12px;"></span>
                    </div>
                    <div class="form-input">
                      <input class="form-control" type="number" placeholder="Mobile" id="mobile" name="mobile" required>
                      <span id="mobile-error" style="color: red;font-size: 12px;"></span>
                    </div>
                    <div class="form-input">                      
                      <textarea class="form-control" placeholder="How can we help you?" id="help" name="help"></textarea>
                      <span id="mobile-error" style="color: red;font-size: 12px;"></span>
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


  <section class="prepation-state p-tb-4 bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
           <div class="hading-section text-center">
            <h2 class="title">
              Preparation <span>state</span>
            </h2>
            <p class="title-text">After You Contact Us</p>
          </div>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-lg-6">
          <figure class="pre-box">
            <img class="img-fluid" src="<?php echo BASE_URL; ?>assets/images/photo-graphy.png">
            <figcaption>
              <h3>Videography</h3>
              <p>
                Get the widest range of property marketing services, from gorgeous 360-degree virtual tours to high-quality video content. Let us capture your property's beauty and make it shine.
              </p>
            </figcaption>
          </figure>
        </div>
        <div class="col-lg-6">
          <figure class="pre-box">
            <img class="img-fluid" src="<?php echo BASE_URL; ?>assets/images/video-graphy.png">
            <figcaption>
              <h3>Photography</h3>
              <p>
                Get high-quality photos of your properties at the best angles. Schedule a call with us, and let us take care of all the heavy lifting for you; we’ll make your property stand out in the market.
              </p>
            </figcaption>
          </figure>
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
              window.location.href='Thanks'
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