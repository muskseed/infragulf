<!doctype html>
<html lang="en">
  <head>   
    <title>Rent Luxury Villas, Apartments in Dubai at Affordable Prices</title>
    <meta name="description" content="Wish to rent luxurious villas, vista homes, apartments in Dubai? We have a wide selection of properties at affordable prices just for you. Call +971 52 194 0000 now.">
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


  <section class="banner-section p-relative bg-dark p-tb-4">
    
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <div class="hading-section">
              <h1 class="title">Rent <span>Properties at any time</span></h1>
              <p class="title-text mt-1">Browse without difficulty and find your new home in Dubai. We have a variety of new and featured properties for you to rent at any time - including studio apartments, two-bedroom units, and more.</p>              
            </div>
          </div>
        </div>
      </div>
    </div>   
  </section>


  <section class="products-section p-tb-4">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">

          <div class="sidebar" id="sortBox">
            <div class="toggle-menu active" onclick="closeFilter()">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="pro-overflow">
                <?php 
                if(!empty($region_data)){
                ?>
                  <div class="pro-tag">
                    <div class="tag-main active bg-dark">
                      <div class="flex-wrap flex-center">
                        <h3>Location</h3>
                        <div class="ml-auto">
                          <img width="20" height="20" src="<?php echo BASE_URL; ?>assets/images/arrow-up-icon.svg">
                        </div>
                      </div>
                    </div>
                    <div class="tag-list active bg-dark">
                      <div class="tag-overflow">
                        <?php 
                        $region_request = $_GET['region_call'];
                        $region_request = explode(',' , $region_request);
                        foreach($region_data AS $r_value){
                        ?>
                          <div class="tag-sl">
                            <label>
                              <input type="checkbox" value="<?php echo $r_value['id']; ?>" class="region_call" <?php echo in_array($r_value['id'] , $region_request) ? 'checked' : ''; ?>> <span><?php echo $r_value['name']; ?></span>
                            </label>
                          </div>
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
                  <?php 
                if(!empty($property_data)){
                ?>
                  <div class="pro-tag">
                    <div class="tag-main active bg-dark">
                      <div class="flex-wrap flex-center">
                        <h3>Property Type</h3>
                        <div class="ml-auto">
                          <img width="20" height="20" src="<?php echo BASE_URL; ?>assets/images/arrow-up-icon.svg">
                        </div>
                      </div>
                    </div>
                    <div class="tag-list active bg-dark">
                      <div class="tag-overflow">
                        <?php 
                        $property_request = $_GET['property_call'];
                        $property_request = explode(',' , $property_request);
                        foreach($property_data AS $p_value){
                        ?>
                        <div class="tag-sl">
                          <label>
                            <input type="checkbox" value="<?php echo $p_value['id']; ?>" class="property_call" <?php echo in_array($p_value['id'] , $property_request) ? 'checked' : ''; ?>> <span><?php echo $p_value['property_name']; ?></span>
                          </label>
                        </div>
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
                  <div class="pro-tag">
                    <div class="tag-main active bg-dark">
                      <div class="flex-wrap flex-center">
                        <h3>Price Range</h3>
                        <div class="ml-auto">
                          <img width="20" height="20" src="<?php echo BASE_URL; ?>assets/images/arrow-up-icon.svg">
                        </div>
                      </div>
                    </div>
                    <?php 
                    $price_request = $_GET['price_range'];
                    $price_request = explode(',' , $price_request);
                    ?>
                    <div class="tag-list active bg-dark">
                      <div class="tag-overflow">
                        <div class="tag-sl">
                          <label>
                            <input type="checkbox" value="1" class="price_range" <?php echo in_array('1' , $price_request) ? 'checked' : ''; ?>> <span>Below 10000 AED</span>
                          </label>
                        </div>
                        <div class="tag-sl">
                          <label>
                            <input type="checkbox" value="2" class="price_range" <?php echo in_array('2' , $price_request) ? 'checked' : ''; ?>> <span>10001 - 20000 AED</span>
                          </label>
                        </div>
                        <div class="tag-sl">
                          <label>
                            <input type="checkbox" value="3" class="price_range" <?php echo in_array('3' , $price_request) ? 'checked' : ''; ?>> <span>20001 - 30000 AED</span>
                          </label>
                        </div>
                        <div class="tag-sl">
                          <label>
                            <input type="checkbox" value="4" class="price_range" <?php echo in_array('4' , $price_request) ? 'checked' : ''; ?>> <span>30001 - 40000 AED</span>
                          </label>
                        </div>
                        <div class="tag-sl">
                          <label>
                            <input type="checkbox" value="5" class="price_range" <?php echo in_array('5' , $price_request) ? 'checked' : ''; ?>> <span>Above 40001 AED</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php 
                  if(!empty($bed_data)){
                  ?>
                    <div class="pro-tag">
                      <div class="tag-main active bg-dark">
                        <div class="flex-wrap flex-center">
                          <h3>Bedrooms</h3>
                          <div class="ml-auto">
                            <img width="20" height="20" src="<?php echo BASE_URL; ?>assets/images/arrow-up-icon.svg">
                          </div>
                        </div>
                      </div>
                      <div class="tag-list active bg-dark">
                        <div class="tag-overflow">
                          <?php 
                          $bedroom_request = $_GET['bedroom_call'];
                          $bedroom_request = explode(',' , $bedroom_request);
                          foreach($bed_data AS $bd_value){
                          ?>
                          <div class="tag-sl">
                            <label>
                              <input type="checkbox" value="<?php echo $bd_value['bedroom']; ?>" class="bedroom_call" <?php echo in_array($bd_value['bedroom'] , $bedroom_request) ? 'checked' : ''; ?>> <span><?php echo $bd_value['bedroom']; ?></span>
                            </label>
                          </div>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row flex-center">
            <div class="col-lg-6">
              <!-- <p>1 to 20 of 229 properties</p> -->
            </div>
            <div class="col-lg-6">
              <div class="filter-list p-relative text-right">
                <button class="btn btn-border sort-btn mr-1" onclick="sortFunc()">
                  <img src="<?php echo BASE_URL; ?>assets/images/sort-icon.svg">
                  <span class="sort-text">Filter</span>
                </button>
                <button class="btn btn-border filter-btn">
                  <img src="<?php echo BASE_URL; ?>assets/images/filter-icon.svg">
                  <span class="filter-text">Sort</span>
                </button>
                <ul class="filter-box text-left">
                  <li>
                    <a value="Newest"  href="<?php echo base_url(); ?>rent?sort_by=newest">Newest</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url(); ?>rent?sort_by=high_low" value="Price (High - Low)">Price (High - Low)</a>
                  </li>
                  <li>
                    <a href="<?php echo base_url(); ?>rent?sort_by=low_high" value="Price (Low - High)">Price (Low - High)</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row mt-1">
          <?php 
            foreach($return_data AS $value){
            ?>
              <div class="col-lg-6">
                <a href="<?php echo base_url(); ?>product_details/property/<?php echo $value['id']; ?>" class="card">
                  <figure>
                    <img class="img-fluid" src="<?php echo ADMIN_URL.PRODUCT_THUMB_IMAGE.$value['image_name']; ?>">
                  </figure>
                  <div class="fig-details">
                    <div class="dt-wrapper">
                      <div class="flex-wrap">
                        <div class="tag">
                          <?php echo $value['property_type']; ?>
                        </div>
                        <div class="ml-auto">
                          <div class="price">
                            <?php echo $value['price']; ?> AED
                          </div>
                        </div>
                      </div>
                      <div class="prop-name mt-1">
                        <h3><?php echo $value['property_title']; ?></h3>
                      </div>
                      <div class="pro-add mt-1">
                        <img src="<?php echo BASE_URL; ?>assets/images/location-icon.svg">
                        <span><?php echo $value['area']; ?></span>
                      </div>
                    </div>
                    <div class="pro-details">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-4">
                            <div class="pro-details-items">
                              <img src="<?php echo BASE_URL; ?>assets/images/bed-icon.svg"> <span><?php echo $value['bedroom']; ?> Beds</span>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="pro-details-items">
                              <img src="<?php echo BASE_URL; ?>assets/images/bath-icon.svg"> <span><?php echo $value['bath']; ?> Bath</span>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="pro-details-items">
                              <img src="<?php echo BASE_URL; ?>assets/images/area-icon.svg"> <span><?php echo $value['area_sqft']; ?> sqft</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="type-tag">
                    <?php echo $value['business_type']; ?>
                  </div>
                </a>
              </div>
            <?php
            }
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
  <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>
  

  <script>
    $(".region_call , .property_call , .price_range , .bedroom_call").click(function(){

      var region_call = $('.region_call:checkbox:checked').map(function() {
          return this.value;
      }).get();
      region_call = region_call.join(",");
      // console.log(region_call);

      var property_call = $('.property_call:checkbox:checked').map(function() {
          return this.value;
      }).get();
      property_call = property_call.join(",");
      // console.log(property_call);

      var price_range = $('.price_range:checkbox:checked').map(function() {
          return this.value;
      }).get();
      price_range = price_range.join(",");
      // console.log(price_range);

      var bedroom_call = $('.bedroom_call:checkbox:checked').map(function() {
          return this.value;
      }).get();
      bedroom_call = bedroom_call.join(",");
      bedroom_call = encodeURIComponent(bedroom_call);
      // console.log(bedroom_call);

      window.location = "<?php echo base_url(); ?>rent?region_call="+region_call+"&property_call="+property_call+"&price_range="+price_range+"&bedroom_call="+bedroom_call;
    })
  </script>
  </body>
</html>