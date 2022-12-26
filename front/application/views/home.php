<!doctype html>
<html lang="en">
  <head>   
    <title>InfraGulf Properties - Rent, Buy & Sell Luxurious Spaces in Dubai</title>
    <meta name="description" content="We are one of the leading property management companies, offering a full range of luxurious flats and apartments for rent, buy, and sell in Dubai.">
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


  <section class="banner-section p-relative line-height-0">
    <video id="video" class="video-bg" autoplay="autoplay" loop muted>
      <source src="<?php echo BASE_URL; ?>assets/images/video/home-page-video.mp4?ver=0.2" type="video/mp4">
      <source src="<?php echo BASE_URL; ?>assets/images/video/home-page-video.mp4?ver=0.2" type="video/ogg">
      Your browser does not support the video tag.
    </video>
    <div class="video-wrapper">
      <div class="m-auto">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-center">
                <div class="hading-section"> 
                  <h1 class="title">Providing Seamless Property Solutions <span class="text-gradient">in the City of Dubai</span></h1>
                  <p class="title-text mt-1">Find new & featured properties today!</p>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-lg-8 m-auto">
                        <div class="search-box mt-3">
                          <div class="flex-wrap">
                            <input autocomplete="off" type="search" name="search" id="search" placeholder="City, Address, Neighbourhood, Zip Code">
                            <button class="ml-auto s-icon"><img src="<?php echo BASE_URL; ?>assets/images/brand-search.svg" class="search icon"> </button>
                          </div>
                          <div id="searchBox" class="search-mode d-none">
                            <div class="tag-overflow" id="search_property">
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>    
  </section>

  <section class="our-properties p-tb-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="hading-section text-center">
            <h2 class="title">
              Our <span class="text-gradient">Properties</span>
            </h2>
          </div>
          <div class="tab-section mt-1">
            <ul class="tab-list text-center">
              <li>
                <a class="active" href="#buyProperties">Buy</a>
              </li>
              <li>
                <a href="#rentProperties">Rent</a>
              </li>
            </ul>
            <div class="tab-items-list mt-2">
              <div class="tab-item active" id="buyProperties">
                <div class="container-fluid">
                  <div class="row mob-scroll">
                    <?php 
                      foreach($buy_data AS $b_value){
                    ?>
                        <div class="col-lg-4">
                          <a href="<?php echo base_url(); ?>product_details/property/<?php echo $b_value['id']; ?>" class="card">
                            <figure>
                              <img class="img-fluid" src="<?php echo ADMIN_URL.PRODUCT_THUMB_IMAGE.$b_value['image_name']; ?>">
                            </figure>
                            <div class="fig-details">
                              <div class="dt-wrapper">
                                <div class="flex-wrap">
                                  <div class="tag">
                                    <?php echo $b_value['property_type']; ?>
                                  </div>
                                  <div class="ml-auto">
                                    <div class="price">
                                      <?php echo $b_value['price']; ?> AED
                                    </div>
                                  </div>
                                </div>
                                <div class="prop-name mt-1">
                                  <h3><?php echo $b_value['property_title']; ?></h3>
                                </div>
                                <div class="pro-add mt-1">
                                  <img src="<?php echo BASE_URL; ?>assets/images/location-icon.svg">
                                  <span><?php echo $b_value['area']; ?></span>
                                </div>
                              </div>
                              <div class="pro-details">
                                <div class="container-fluid">
                                  <div class="row">
                                    <div class="col-4">
                                      <div class="pro-details-items">
                                        <img src="<?php echo BASE_URL; ?>assets/images/bed-icon.svg"> <span><?php echo $b_value['bedroom']; ?> Beds</span>
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="pro-details-items">
                                        <img src="<?php echo BASE_URL; ?>assets/images/bath-icon.svg"> <span><?php echo $b_value['bath']; ?> Bath</span>
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="pro-details-items">
                                        <img src="<?php echo BASE_URL; ?>assets/images/area-icon.svg"> <span><?php echo $b_value['area_sqft']; ?> sqft</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="type-tag">
                              <?php echo $b_value['business_type']; ?>
                            </div>
                          </a>
                        </div>
                    <?php
                      }
                    ?>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="text-center">
                        <a href="<?php echo BASE_URL; ?>buy" class="btn btn-border">View All</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-item" id="rentProperties">
                <div class="container-fluid">
                  <div class="row mob-scroll">
                  <?php 
                      foreach($rent_data AS $r_value){
                    ?>
                        <div class="col-lg-4">
                          <a href="<?php echo base_url(); ?>product_details/property/<?php echo $r_value['id']; ?>" class="card">
                            <figure>
                              <img class="img-fluid" src="<?php echo ADMIN_URL.PRODUCT_THUMB_IMAGE.$r_value['image_name']; ?>">
                            </figure>
                            <div class="fig-details">
                              <div class="dt-wrapper">
                                <div class="flex-wrap">
                                  <div class="tag">
                                    <?php echo $r_value['property_type']; ?>
                                  </div>
                                  <div class="ml-auto">
                                    <div class="price">
                                      <?php echo $r_value['price']; ?> AED
                                    </div>
                                  </div>
                                </div>
                                <div class="prop-name mt-1">
                                  <h3><?php echo $r_value['property_title']; ?></h3>
                                </div>
                                <div class="pro-add mt-1">
                                  <img src="<?php echo BASE_URL; ?>assets/images/location-icon.svg">
                                  <span><?php echo $r_value['area']; ?></span>
                                </div>
                              </div>
                              <div class="pro-details">
                                <div class="container-fluid">
                                  <div class="row">
                                    <div class="col-4">
                                      <div class="pro-details-items">
                                        <img src="<?php echo BASE_URL; ?>assets/images/bed-icon.svg"> <span><?php echo $r_value['bedroom']; ?> Beds</span>
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="pro-details-items">
                                        <img src="<?php echo BASE_URL; ?>assets/images/bath-icon.svg"> <span><?php echo $r_value['bath']; ?> Bath</span>
                                      </div>
                                    </div>
                                    <div class="col-4">
                                      <div class="pro-details-items">
                                        <img src="<?php echo BASE_URL; ?>assets/images/area-icon.svg"> <span><?php echo $r_value['area_sqft']; ?> sqft</span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="type-tag">
                              <?php echo $r_value['business_type']; ?>
                            </div>
                          </a>
                        </div>
                    <?php
                      }
                    ?>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="text-center">
                        <a href="<?php echo BASE_URL; ?>rent" class="btn btn-border">View All</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>     
    </div>
  </section>

  <?php 
  if(!empty($off_plan)){
  ?>
  
  <section class="off-plan-project p-tb-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <div class="hading-section">
              <h1 class="title">Off Plan Projects <span class="text-gradient">In Dubai</span></h1>                        
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-2 mob-scroll">
        <?php 
        foreach($off_plan AS $o_value){
        ?>
          <div class="col-lg-4">
            <a href="<?php echo base_url(); ?>Offplane/details/<?php echo $o_value['id']; ?>"><img class="off-plan-img img-fluid" src="<?php echo ADMIN_URL.PRODUCT_THUMB_IMAGE.$o_value['image_name']; ?>"></a>
          </div>
        <?php
        }
        ?>
        
      </div>
    </div>
  </section>
  <?php
  }
  ?>
  <section class="testimonoals-section p-tb-4 d-none">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <div class="hading-section">
              <h1 class="title">Our Client <span class="text-gradient">Reviews</span></h1>                        
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3 mob-scroll">
        <?php 
          foreach($client_reviews AS $cr_value){
        ?>
            <div class="col-lg-4">
              <div class="dark-card text-center">
                <img src="<?php echo ADMIN_URL.BANNER_UPLOAD_PATH.$cr_value['image_name']; ?>">
                <div class="mt-2">
                  <h4><?php echo $cr_value['name']; ?></h4>
                  <p class="font14 brand-color"><?php echo $cr_value['city']; ?></p>
                </div>
                <div class="mt-2">
                  <p>
                    <?php echo $cr_value['review']; ?>
                  </p>
                </div>
              </div>
            </div>
        <?php
          }
        ?>
      </div>
    </div>
  </section>

  <section class="expert-section p-tb-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <div class="hading-section">
              <h1 class="title">Meet the <span class="text-gradient">Team</span></h1>                      
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-2">
        <div id="ourExpert" class="owl-carousel">
          <?php 
          foreach($experts AS $e_value){
        ?>
          <div class="item">
            <div class="col-lg-12">
              <div class="img-card p-relative">
                <a href="<?php echo BASE_URL; ?>about-agent/<?php echo $e_value['id']; ?>" class="exp-img">
                  <img class="img-fluid" src="<?php echo ADMIN_URL.BANNER_UPLOAD_PATH.$e_value['image_name']; ?>" align="expert 1">
                </a>
                <div class="exp-action text-center">
                  <h4><?php echo $e_value['name'];?></h4>
                  <p><?php echo $e_value['designation']; ?></p>
                  <div class="act-list mt-1">
                    <a href="tel:<?php echo $e_value['mobile']; ?>">
                      <img src="<?php echo BASE_URL; ?>assets/images/call-full-icon.svg">
                    </a>
                    <a href="mailto:<?php echo $e_value['email']; ?>">
                      <img src="<?php echo BASE_URL; ?>assets/images/email-icon.svg">
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=<?php echo $e_value['whatsapp']; ?>&text=Hi, I have a few questions. Can you help?">
                      <img src="<?php echo BASE_URL; ?>assets/images/whatsapp-icon.svg">
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
          }
        ?>
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
              <h1 class="title">Get in touch <span class="text-gradient">with us</span></h1>   
              <p class="title-text">And Our Specialists Will Contact You</p>                   
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-5 m-auto">
                
                <div class="form-box mt-2">
                  <div class="hading-section text-center">
                    <h3 class="title-2">Drop your contact details below </h3>
                    <p class="mt-1">we’ll get in touch with you</p>
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
                      <button type="button" id="submit_form" class="btn btn-border d-block">Submit</button>
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

  <section id="loader" class="d-none">
    <div class="loading">
      <span class="loader-2"> </span>
    </div>
  </section>

<!--   <div class="st-modal" data-modal="formModal">
    <div class="ds-card-box">
      <div class="square-card">
        <div class="ds-close">
          <img src="<?php echo BASE_URL; ?>assets/images/close-icon.svg">
        </div>
        <div class="md-body">
          <div>
              <div class="hading-section text-center">
                <h3 class="title-2">Drop your contact details below </h3>
                <p>We’ll get in touch with you</p>
              </div>
              <form class="mt-1">
                <div class="form-input">
                  <input class="form-control" type="text" placeholder="Name" id="name_modal" name="name_modal" required>
                  <span id="name_modal-error" style="color: red;font-size: 12px;"></span>
                </div>
                <div class="form-input">
                  <input class="form-control" type="email" placeholder="Email" id="email_modal" name="email_modal" required>
                  <span id="email_modal-error" style="color: red;font-size: 12px;"></span>
                </div>
                <div class="form-input">
                  <input class="form-control" type="number" minlength="10" maxlength="10" placeholder="Mobile" id="mobile_modal" name="mobile_modal" required>
                  <span id="mobile_modal-error" style="color: red;font-size: 12px;"></span>
                </div>
                <div class="form-input">                      
                  <textarea class="form-control" placeholder="How can we help you?" id="help" name="help"></textarea>
                  <span id="mobile-error" style="color: red;font-size: 12px;"></span>
                </div>
                <div class="form-input">
                  <button type="button" id="submit_modal" class="btn btn-primary d-block">Submit</button>
                  <span id="submit_modal-error" style="color: rebeccapurple;"></span>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div> -->

  <div class="chat-area">
    <div class="chat-box">
      <div>
        <div class="hading-section text-center">
          <h3 class="title-2">Drop your contact details below </h3>
          <p>We’ll get in touch with you</p>
        </div>
        <form class="mt-1">
          <div class="form-input">
            <input class="form-control" type="text" placeholder="Name" id="name_modal" name="name_modal" required>
            <span id="name_modal-error" style="color: red;font-size: 12px;"></span>
          </div>
          <div class="form-input">
            <input class="form-control" type="email" placeholder="Email" id="email_modal" name="email_modal" required>
            <span id="email_modal-error" style="color: red;font-size: 12px;"></span>
          </div>
          <div class="form-input">
            <input class="form-control" type="number" minlength="10" maxlength="10" placeholder="Mobile" id="mobile_modal" name="mobile_modal" required>
            <span id="mobile_modal-error" style="color: red;font-size: 12px;"></span>
          </div>
          <div class="form-input">                      
            <textarea class="form-control" placeholder="How can we help you?" id="help" name="help"></textarea>
            <span id="mobile-error" style="color: red;font-size: 12px;"></span>
          </div>
          <div class="form-input">
            <button type="button" id="submit_modal" class="btn btn-border d-block">Submit</button>
            <span id="submit_modal-error" style="color: rebeccapurple;"></span>
          </div>
        </form>
    </div>
    </div>
    <div class="chat-icons">
      <img src="<?php echo BASE_URL; ?>assets/images/chat-icon.svg" />
    </div>
  </div>

  <?php 
  $this->load->view('common_file/footer');
  ?>
      
  
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    var form_session = "<?php echo $this->session->userdata('form_session'); ?>";
    // console.log('form'+form_session);
  </script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script type="text/javascript">
    jQuery("#ourExpert").owlCarousel({      
      lazyLoad: true,
      loop: false,
      rewind: false,
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
        768: {
          items: 2
        },
       992: {
          items: 3
        },

        1366: {
          items: 4
        }
      }
    });
    $(".owl-slider .owl-prev").html('<img class="img-fluid" src="<?php echo BASE_URL; ?>assets/images/left-arrow.svg" />');
    $(".owl-slider .owl-next").html('<img class="img-fluid" src="<?php echo BASE_URL; ?>assets/images/right-arrow.svg" />');
  </script>

  <script>
    $(document).ready(function() {

    });

    $("#submit_modal").click(function(){
      $("#name_modal-error").text(' ');
      $("#email_modal-error").text(' ');
      $("#mobile_modal-error").text(' ');
      var name_modal = $("#name_modal").val();
      var email_modal = $("#email_modal").val();
      var mobile_modal = $("#mobile_modal").val();
      var name_id = 'name_modal';
      var email_id = 'email_modal';
      var mobile_id = 'mobile_modal';
      var submit_id = 'submit_modal';
      refister_function(name_modal , email_modal , mobile_modal , name_id , email_id , mobile_id , submit_id);
    })


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

    $("#search").keyup(function(){
      var search = $("#search").val();
      $.ajax({
        url : "<?php echo base_url(); ?>home/search_property",
        type: "POST",
        data: {search : search},
        dataType: "html",
        beforeSend: function() {
          $("#loader").show();
        },
        success: function(html){

          

          $("#loader").hide();
          $("#search_property").html(html);
          $("#searchBox").fadeIn();
          $("#search").parents(".search-box").addClass("active");
          // console.log(html);
        }
      });

      
    })

    $(document).mouseup(function(e) 
    {
        var container = $("#searchBox");       
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            container.hide();
            container.parents(".search-box").removeClass("active");
        }
    });



  </script>

  <script>
    
    $(".chat-icons").on("click", function(){
      if($(this).children("img").attr("src")=="<?php echo BASE_URL; ?>assets/images/chat-icon.svg"){
        $(this).children("img").attr("src", "<?php echo BASE_URL; ?>assets/images/close-big-icon.svg");
      }else{
        $(this).children("img").attr("src", "<?php echo BASE_URL; ?>assets/images/chat-icon.svg");
      }

      $(".chat-box").slideToggle("fast");

    });

    setTimeout(function () {
      $(".chat-icons img").attr("src", "<?php echo BASE_URL; ?>assets/images/close-big-icon.svg");
        $(".chat-box").slideDown("fast");
    }, 10000);
  </script>
  </body>
</html>