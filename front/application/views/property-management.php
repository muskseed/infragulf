<!doctype html>
<html lang="en">
  <head>   
    <title>Property Management</title>
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


  <section class="banner-section property-management p-relative bg-dark p-tb-7">
    
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <div class="hading-section">
              <h1 class="title">Property management <span>in Dubai</span></h1>
              <p class="title-text mt-1">
                We are passionate about real estate, and we are even more passionate about our clients, which is why we ensure that you receive tailored solutions to suit your needs.
              </p>              
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
            <li>Property management</li>
            
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="prepation-state p-tb-4">
    <div class="container">      
    
      <div class="row mt-2 reverse-collumn">
        <div class="col-lg-6 lg-mt-1">          
            <div>
              <p>
                We recognize your need to find a tenant who will take care of the property as well as you did. So, it is even more crucial for us to make sure that every tenant we place on your property has been qualified thoroughly by our property managers.
              </p>           
              <p class="mt-1">
                And lastly, our variable pricing allows us to work with a wide range of budgets. So if you require any property management services in Dubai, please contact us so that we can provide you with a tailored service.
              </p>
              <div class="mt-2
              ">
                <a href="<?php echo BASE_URL; ?>sell" class="btn btn-border">Contact Us</a>
              </div>
          </div>
        </div>
        <div class="col-lg-6">
          <img class="img-fluid br-2" src="<?php echo BASE_URL; ?>assets/images/property-managment/propert-m-2.jpg">
        </div>
      </div>
      
     
      
      <div class="row mt-3">
        <div class="col-lg-12">
          <div class="b-bottm"></div>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-lg-12">
          <div class="hading-section text-center">
            <h3 class="title">Our Property <span>Management Service</span></h3>
          </div>
        </div>
      </div>
      <div class="row mt-2">
        <div class="col-lg-3 col-sm-6">
          <div class="fig-details m-0 p-15 pr-box-m">
            <img src="<?php echo BASE_URL; ?>assets/images/property-managment/pr-m-1.svg">
            <h3 class="mt-2">Free casual letting service</h3>
              <p class="mt-1">For property owners who manage their own properties;  this service includes pre-inspection of the properties with photos when you rent it out.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="fig-details m-0 p-15 pr-box-m">
            <img src="<?php echo BASE_URL; ?>assets/images/property-managment/pr-m-2.svg">
            <h3 class="mt-2">Inspection-only service</h3>
              <p class="mt-1">For property owners who want to maintain their own properties but don't have the time to perform routine inspections.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="fig-details m-0 p-15 pr-box-m">
            <img src="<?php echo BASE_URL; ?>assets/images/property-managment/pr-m-3.svg">
            <h3 class="mt-2">Tribunal assistance service</h3>
              <p class="mt-1">For property owners who need help arranging and attending tenancy hearings but wish to continue managing their properties on their own.</p>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6">
          <div class="fig-details m-0 p-15 pr-box-m">
            <img src="<?php echo BASE_URL; ?>assets/images/property-managment/pr-m-4.svg">
            <h3 class="mt-2">Property maintenance service</h3>
              <p class="mt-1">For owners who use their home as a vacation retreat, we ensure that your property is ready for your arrival and will handle any property-related matters while you are away.</p>
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
  

  </body>
</html>