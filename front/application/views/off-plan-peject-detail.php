<!doctype html>
<html lang="en">
  <head>   
    <title>Off Plan Project</title>
    <meta name="description" content="">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php 
      $this->load->view('common_file/style');
    ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  </head>
  <body>
  
<?php 
  $this->load->view('common_file/header');
?>


  <section class="banner-section bg-dark p-relative">
    <div class="owl-slider">
      <div id="carousel" class="owl-carousel">
        <?php 
            foreach($image_data AS $i_value){
        ?>
                <div class="item">
                    <img src="<?php echo ADMIN_URL.PRODUCT_ZOOM_IMAGE.$i_value['image_name']; ?>" alt="">
                </div>
        <?php
            }
        ?>
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
            
            <li><a href="#"><?php echo $region_data[0]['name']; ?></a></li>
            <li><a href="#"><?php echo $fetch_data['area']; ?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="property-detail-secion p-tb-2">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="pr-deatils">
            <h2 class="title-2">AED <?php echo $fetch_data['price']; ?></h2>
            <h1 class="title-3 mt-1"><?php echo $fetch_data['property_title']; ?></h1>

            <div class="pro-add mt-1">
              <img src="<?php echo BASE_URL; ?>assets/images/location-icon.svg">
              <span><?php echo $fetch_data['area']; ?></span>
            </div>
            <!-- <div class="pro-add mt-1 flex-wrap">              
              <span><?php echo $property_type[0]['property_name']; ?></span>
              <ul>
                <li><img src="<?php echo BASE_URL; ?>assets/images/location-icon.svg"></li>
                <li><img src="<?php echo BASE_URL; ?>assets/images/bed-icon.svg"></li>
                <li><img src="<?php echo BASE_URL; ?>assets/images/bath-icon.svg"></li>
              </ul>
            </div> -->
            <div class="mt-2">
               <div class="share-box p-relative">                
                <a class="share-items" href="javascript:void(0)">
                  <img src="<?php echo BASE_URL; ?>assets/images/share-icon.svg"> <span>Share this property</span>
                </a>                
                <div class="social active">
                  <div class="social__item">
                    <span data-social="fb">
                       <img src="<?php echo BASE_URL; ?>assets/images/social/fb-icon.svg">
                    </span>
                  </div>
                  
                  <div class="social__item">
                    <span data-social="tw">
                      <img src="<?php echo BASE_URL; ?>assets/images/social/twitter-icon.svg">
                    </span>
                  </div>
                  <div class="social__item">
                    <span data-social="ln">
                      <img src="<?php echo BASE_URL; ?>assets/images/social/linkedin-icon.svg">
                    </span>
                  </div>                  
                </div>   
              </div>   
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          
        </div>
        <div class="col-lg-4">
          <div class="fig-details m-0 sticky-top">
            <div class="dt-wrapper">
              <h2 class="title-2"><?php echo $fetch_data['property_title']; ?></h2>
              <div class="prop-name mt-1">
                <p>Studio, 1, 2, 3 and 4 Bedrooms Apartment in Elitz by Danube</p>
              </div>
              <div class="mt-1">
                <a target="_blank" class="btn btn-border d-block" href="<?php echo ADMIN_URL.MARKETING.$fetch_data['broucher_file']; ?>">
                  Download Brochure
                </a>
              </div>
            </div>
            
          </div>
        </div>
      </div>
      <div class="row mt-2">
        <!-- <div class="col-lg-4">
          <div class="lg-mt-1">
            <h3 class="title-3">
              Features & Amenities
            </h3>
            <ul class="pr-list list-show mt-1">
              <li><span>Rukan Community, Dubai</span></li>
              <li><span>$256</span></li>
              <li><span>1851563134</span></li>
              <li><span>infg-3462113</span></li>
              <li><span>Unfurnished</span></li>
            </ul>
          </div>
        </div> -->
        <div class="col-lg-4">
          <div class="lg-mt-1">
            <h3 class="title-3">
              Project features
            </h3>
            
            <ul class="pr-list list-show mt-1">
                <?php 
                foreach($project_feature AS $pf_value){
                ?>
                    <li><span><?php echo $pf_value['name']; ?></span></li>
                <?php
                }
                ?>
            </ul>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="lg-mt-1">
            <h3 class="title-3">
              Amenities Include
            </h3>
            <ul class="pr-list list-show mt-1">
                <?php 
                foreach($amenities_include AS $ai_value){
                ?>
                    <li><span><?php echo $ai_value['name']; ?></span></li>
                <?php
                }
                ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-lg-12">
          <div class="lg-mt-1">
            <h3 class="title-3 mb-1">
              Description
            </h3>
            <p class="pr-list">
              <?php 
                echo $fetch_data['description'];
              ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

<section class="down-payment">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h3 class="title-3 mb-1 text-center">
            Payment Plan
          </h3>
        <div class="down_pay text-center">
          <?php echo $fetch_data['payment_desc']; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="dev-info mt-3">
  <div class="container">
    <div class="row text-center">
      <div class="col-lg-4">
        <div class="down_pay text-center">
          <p>Est. Completion</p>
          <h3><?php echo $fetch_data['est_completion']; ?></h3>
        </div>
      </div>
      <div class="col-lg-4 lg-mt-1">
        <div class="down_pay text-center">
          <p>Developer</p>
          <h3><?php echo $fetch_data['developer']; ?></h3>
        </div>
      </div>
      <div class="col-lg-4 lg-mt-1">
        <div class="down_pay text-center">
          <p>Title Type</p>
          <h3><?php echo $fetch_data['title_type']; ?></h3>
        </div>
      </div>
    </div>
  </div>
</section>

  <section class="map-area-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="map-box">
              <?php 
                echo $fetch_data['maps'];
              ?>
                  
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
                      <span id="name-error" style="color: red;"></span>
                    </div>
                    <div class="form-input">
                      <input class="form-control" type="email" placeholder="Email" id="email" name="email" required>
                      <span id="email-error" style="color: red;"></span>
                    </div>
                    <div class="form-input">
                      <input class="form-control" type="number" placeholder="Mobile" id="mobile" name="mobile" required>
                      <span id="mobile-error" style="color: red;"></span>
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


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="https://rawgit.com/Belyash/jquery-social-buttons/master/src/jquery.social-buttons.min.js"></script>

<script type="text/javascript">
  $(function () {
  $("[data-social]").socialButtons({
    url: "https://belyash.github.io"
  });
});
</script>


  <script type="text/javascript">
    jQuery("#carousel").owlCarousel({
      autoplay: true,
      lazyLoad: true,
      loop: true,
      rewind: true,
      margin: 20,
       /*
      animateOut: 'fadeOut',
      animateIn: 'fadeIn',
      */
      responsiveClass: true,
      autoHeight: true,
      autoplayTimeout: 3000,
      smartSpeed: 800,
      nav: true,
      responsive: {
        0: {
          items: 1
        },

       

        1366: {
          items: 1
        }
      }
    });
    $(".owl-slider .owl-prev").html('<img class="img-fluid" src="<?php echo BASE_URL; ?>assets/images/left-arrow.svg" />');
    $(".owl-slider .owl-next").html('<img class="img-fluid" src="<?php echo BASE_URL; ?>assets/images/right-arrow.svg" />');


    $(".share-items").on("click", function(){
      $(this).siblings(".social").toggleClass("active");
    });

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
          url : "<?php echo base_url(); ?>home/register",
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