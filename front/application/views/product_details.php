<!doctype html>
<html lang="en">
  <head>   
    <title><?php echo $fetch_data['property_title']; ?> | Infra Gulf</title>
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
            <li><a href="#"><?php echo $property_type[0]['property_name']; ?></a></li>
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
            <div class="pro-add mt-1 flex-wrap">              
              <span><?php echo $property_type[0]['property_name']; ?></span>
              <ul>
                <li><img src="<?php echo BASE_URL; ?>assets/images/location-icon.svg"></li>
                <li><img src="<?php echo BASE_URL; ?>assets/images/bed-icon.svg"></li>
                <li><img src="<?php echo BASE_URL; ?>assets/images/bath-icon.svg"></li>
              </ul>
            </div>
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
          <ul class="pr-list">
            <li>Location: <span><?php echo $fetch_data['area']; ?></span></li>
            <li>Price per Sq.Ft: <span>AED <?php echo $fetch_data['price_sq_ft']; ?></span></li>
            <li>RERA No: <span><?php echo $fetch_data['rera_no']; ?></span></li>
            <li>Ref No: <span><?php echo $fetch_data['ref_no']; ?></span></li>
            <li>Furnishing: <span><?php echo strtoupper($fetch_data['furnishing']); ?></span></li>
          </ul>
        </div>
        <div class="col-lg-4">
          <div class="fig-details m-0">
            <div class="dt-wrapper">
              <div class="flex-wrap flex-center">
                <div>
                  <img class="owner-img" src="<?php echo ADMIN_URL.BANNER_UPLOAD_PATH.$agent_data[0]['image_name']; ?>">
                </div>
                <div class="ml-1">
                  <div class="price">
                    <?php echo $agent_data[0]['name']; ?>
                  </div>
                  <div class="tag">
                  Agent
                </div>
                </div>
              </div>
              <div class="flex-wrap flex-center mt-1">
                <div>
                    <?php 
                     $url_qrcode = 'https://chart.googleapis.com/chart?chs=90x90&cht=qr&chl='.$agent_data[0]['mobile'].'&choe=UTF-8';
                    ?>
                  <img class="qr-code" src="<?php echo $url_qrcode; ?>">
                </div>
                <div class="ml-1">
                  <p>
                    Scane QR to get Mobile contact details
                  </p>
                </div>
              </div>
              <div class="prop-name mt-1">
                <p>Or Get Availability via WhatsApp</p>
              </div>
              <div class="mt-1">
                <a class="btn btn-primary d-block btn-whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $agent_data[0]['whatsapp']; ?>&text=Hi, I have a few questions. Can you help?">
                  <img src="<?php echo BASE_URL; ?>assets/images/whatsapp-white.svg"> WhatsApp
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
  

 <?php 
 $this->load->view('common_file/footer');
 ?>
      
  
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>
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




   
  </script>

  <script type="text/javascript" src="https://rawgit.com/Belyash/jquery-social-buttons/master/src/jquery.social-buttons.min.js"></script>

<script type="text/javascript">

  var url      = window.location.href;  


  $(function () {
  $("[data-social]").socialButtons({
    url: url
  });
});

   $(".share-items").on("click", function(){
      $(this).siblings(".social").toggleClass("active");
    });

</script>

  
  

  </body>
</html>