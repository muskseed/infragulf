<!doctype html>
<html lang="en">
  <head>   
    <title>Projects</title>
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


  <section class="banner-section project p-relative bg-dark p-tb-7">
    
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <div class="hading-section">
              <h1 class="title">Real Estate <span>Projects In Dubai</span></h1>
              <p class="title-text mt-1">See Dubai's hottest residential and commercial real estate projects</p>              
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
            <li>Projects</li>
            
          </ul>
        </div>
      </div>
    </div>
  </section>


  <section class="products-section p-tb-4">
    <div class="container">
      <div class="row">
        <?php 
        if(!empty($final_data)){
          foreach($final_data AS $f_key => $f_value){
        ?>
            
            <div class="col-lg-4">
            
              <div class="card">
                <figure>
                <a href="<?php echo base_url(); ?>Offplane/details/<?php echo $f_value['id']; ?>">
                <img class="img-fluid pr-img" src="<?php echo ADMIN_URL.PRODUCT_THUMB_IMAGE.$f_value['image_name']; ?>">
                </a>
                </figure>
                <div class="fig-details">
                  <div class="dt-wrapper p-15">
                  
                    <div class="text-right">
                      <span class="tag">
                        <?php echo $f_value['project_status']; ?>
                      </span>
                    </div> 
                    <div class="prop-name mt-1">
                        <h3><?php echo $f_value['property_title']; ?></h3>
                      </div>  
                    <div class="price flex-wrap">
                      <small>Price From</small>
                      <div class="ml-auto"><?php echo $f_value['price']; ?> AED</div>
                    </div>     
                                       
                    <div class="pro-add mt-1">
                      <img src="<?php echo BASE_URL; ?>assets/images/location-icon.svg">
                      <span><?php echo $f_value['location']; ?></span>
                    </div>
                  </div>              
                </div>            
              </div>
            </div> 
        <?php
          }
        }
        ?>
               
      </div> 
    </div>
  </section>

 <?php 
 $this->load->view('common_file/footer');
 ?>
      
  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>
  

  </body>
</html>