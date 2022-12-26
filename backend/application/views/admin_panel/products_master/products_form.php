<!DOCTYPE html>
<html>   
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= COMPANY_NAME; ?> | Property Form</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- All CSS and JS File -->
  <?php $this->load->view('admin_panel/common_file/header'); ?>
  
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
  <!-- JS Tree -->
  <link rel="stylesheet" href="https://static.jstree.com/3.0.9/assets/dist/themes/default/style.min.css">
  <style type="text/css">
    .container {
      margin-top: 20px;
    }

    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

    #img-upload{
      /*width: 200px;*/
      /*height: 200px;*/
      /* padding-left: 18px; */
      /*margin-left: 193px;*/
    }
  </style>  
</head> 
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <!-- Header and Sidebar Conent -->
  <?php $this->load->view('admin_panel/common_file/sidebar'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Property
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>admin_panel/Products">Property</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Property Form</h3>

         </div>
         <div class="box-body">

            <!-- Container of Form -->
               <?php
               //form open
                  $form_attributes = array('class' => 'form-horizontal', 'id' => 'contact_form', 'method' => 'post','autocomplete'=>'off');

                  echo form_open_multipart(isset($edit_data[0]['id']) ? 'admin_panel/Products/form_action/'.$edit_data[0]['id'] : 'admin_panel/Products/form_action', $form_attributes);

               ?>

                <div class="row">
                  <div class="col-md-12">
                      <div class="form-group col-md-6">
                        <label for="" class="col-md-4 control-label">Type :<span style="color: red;">*</span></label>

                        <div class="col-md-8">
                          <select name="business_type" id="business_type" class="form-control selectpicker business_type">
                              <option value=''> Select Type</option>
                              <option value="buy" <?php echo $edit_data[0]['business_type'] == 'buy' ? 'selected' : ''; ?>>Buy</option>
                              <option value="rent" <?php echo $edit_data[0]['business_type'] == 'rent' ? 'selected' : ''; ?>>Rent</option>
                          </select>
                          <span id="business_type-error" style="color: red;"></span>
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                            <label for="" class="col-md-4 control-label">Property Type :<span style="color: red;">*</span></label>

                            <div class="col-md-8">
                                <select name="property_type" id="property_type" class="form-control selectpicker property_type select2">
                                    <option value="">Select Property</option>
                                    <?php 
                                      if($mode == 'add'){
                                        foreach ($property_type as $v_key => $v_value){
                                            echo '<option value="'.$v_value['id'].'">'.$v_value['property_name'].'</option>';
                                          }
                                      }else{
                                          foreach ($property_type as $ve_key => $ve_value){
                                              $selected = $edit_data[0]['property_type'] == $ve_value['id'] ? 'selected' : '';
                                              echo '<option value="'.$ve_value['id'].'" '.$selected.'>'.$ve_value['property_name'].'</option>';
                                          }
                                        }
                                    ?>
                                </select>
                                <span id="property_type-error" style="color: red;"></span>
                            </div>
                        </div>

                  </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        
                      <div class="form-group col-md-6">
                        <label class="col-md-4 control-label">Price :<span style="color: red;">*</span></label>

                        <div class="col-md-8">
                          <input type="text" class="form-control" name="price" id="price" value="<?php echo isset($edit_data[0]['price']) ? $edit_data[0]['price'] : ''; ?>" placeholder="Enter Price">
                          <span id="price-error" style="color: red;"></span>
                        </div>
                      </div>

                        <div class="form-group col-md-6">
                          <label class="col-md-4 control-label">Location :<span style="color: red;">*</span></label>

                          <div class="col-md-8">
                            <input type="text" class="form-control" name="area" id="area" value="<?php echo isset($edit_data[0]['area']) ? $edit_data[0]['area'] : ''; ?>" placeholder="Enter Location">
                            <span id="area-error" style="color: red;"></span>
                          </div>
                        </div> 
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">

                      <div class="form-group col-md-6">
                            <label for="" class="col-md-4 control-label">Region :<span style="color: red;">*</span></label>

                            <div class="col-md-8">
                                <select name="region" id="region" class="form-control selectpicker region select2">
                                    <option value="">Select Region</option>
                                    <?php 
                                      if($mode == 'add'){
                                        foreach ($region as $v_key => $v_value){
                                            echo '<option value="'.$v_value['id'].'">'.$v_value['name'].'</option>';
                                          }
                                      }else{
                                          foreach ($region as $ve_key => $ve_value){
                                              $selected = $edit_data[0]['region'] == $ve_value['id'] ? 'selected' : '';
                                              echo '<option value="'.$ve_value['id'].'" '.$selected.'>'.$ve_value['name'].'</option>';
                                          }
                                        }
                                    ?>
                                </select>
                                <span id="region-error" style="color: red;"></span>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label class="col-md-4 control-label">Property Title :<span style="color: red;">*</span></label>

                          <div class="col-md-8">
                            <input type="text" class="form-control" name="property_title" id="property_title" value="<?php echo isset($edit_data[0]['property_title']) ? $edit_data[0]['property_title'] : ''; ?>" placeholder="Enter Property Title">
                            <span id="property_title-error" style="color: red;"></span>
                          </div>
                        </div> 
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-6">
                          <label class="col-md-4 control-label">Price per Sq ft.:<span style="color: red;">*</span></label>

                          <div class="col-md-8">
                            <input type="text" class="form-control" name="price_sq_ft" id="price_sq_ft" value="<?php echo isset($edit_data[0]['price_sq_ft']) ? $edit_data[0]['price_sq_ft'] : ''; ?>" placeholder="Enter Price Sq Ft">
                            <span id="price_sq_ft-error" style="color: red;"></span>
                          </div>
                        </div> 

                        <div class="form-group col-md-6">
                          <label class="col-md-4 control-label">Rera Number :</label>

                          <div class="col-md-8">
                            <input type="text" class="form-control" name="rera_no" id="rera_no" value="<?php echo isset($edit_data[0]['rera_no']) ? $edit_data[0]['rera_no'] : ''; ?>" placeholder="Enter Rera Number">
                          </div>
                        </div> 
                    </div>
                </div>
                
                <div class="row">
                  <div class="col-md-12">

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Ref. Number :</label>

                      <div class="col-md-8">
                        <input type="text" class="form-control" name="ref_no" id="ref_no" value="<?php echo isset($edit_data[0]['ref_no']) ? $edit_data[0]['ref_no'] : ''; ?>" placeholder="Enter Ref. Number">
                      </div>
                    </div>

                      <div class="form-group col-md-6">
                        <label for="" class="col-md-4 control-label">Furnish Type :</label>

                        <div class="col-md-8">
                          <select name="furnishing" id="furnishing" class="form-control selectpicker furnishing">
                              <option value=''> Select Type</option>
                              <option value="furnished" <?php echo $edit_data[0]['furnishing'] == 'furnished' ? 'selected' : ''; ?>>Furnished</option>
                              <option value="semi_furnished" <?php echo $edit_data[0]['furnishing'] == 'semi_furnished' ? 'selected' : ''; ?>>Semi-Furnished</option>
                              <option value="unfurnished" <?php echo $edit_data[0]['furnishing'] == 'unfurnished' ? 'selected' : ''; ?>>UnFurnished</option>
                          </select>
                        </div>
                      </div>
                  </div>
                </div>
                                        
                <div class="row">
                  <div class="col-md-12">

                      <div class="form-group col-md-6">
                            <label for="" class="col-md-4 control-label">Project Featured :<span style="color: red;">*</span></label>

                            <div class="col-md-8">
                                <select name="project_feature[]" id="project_feature" multiple class="form-control selectpicker project_feature select2">
                                    <?php 
                                      if($mode == 'add'){
                                        foreach ($project_feature as $v_key => $v_value){
                                            echo '<option value="'.$v_value['id'].'">'.$v_value['name'].'</option>';
                                          }
                                      }else{
                                          $project_feature_data = $edit_data[0]['project_feature'];
                                          $project_feature_data = explode(',' , $project_feature_data);
                                          foreach ($project_feature as $ve_key => $ve_value){
                                              $selected = in_array($ve_value['id'] , $project_feature_data) ? 'selected' : '';
                                              echo '<option value="'.$ve_value['id'].'" '.$selected.'>'.$ve_value['name'].'</option>';
                                          }
                                        }
                                    ?>
                                </select>
                                <span id="project_feature-error" style="color: red;"></span>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="" class="col-md-4 control-label">Amenities :<span style="color: red;">*</span></label>

                            <div class="col-md-8">
                                <select name="amenities_include[]" id="amenities_include" class="form-control selectpicker amenities_include select2" multiple>
                                    <?php 
                                      if($mode == 'add'){
                                        foreach ($amenities as $v_key => $v_value){
                                            echo '<option value="'.$v_value['id'].'">'.$v_value['name'].'</option>';
                                          }
                                      }else{
                                          $amenities_include_data = $edit_data[0]['amenities_include'];
                                          $amenities_include_data = explode(',' , $amenities_include_data);
                                          foreach ($amenities as $ve_key => $ve_value){
                                              $selected = in_array($ve_value['id'] , $amenities_include_data) ? 'selected' : '';
                                              echo '<option value="'.$ve_value['id'].'" '.$selected.'>'.$ve_value['name'].'</option>';
                                          }
                                        }
                                    ?>
                                </select>
                                <span id="amenities_include-error" style="color: red;"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-12">

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Property Area :<span style="color: red;">*</span></label>

                      <div class="col-md-8">
                        <input type="text" class="form-control" name="area_sqft" id="area_sqft" value="<?php echo isset($edit_data[0]['area_sqft']) ? $edit_data[0]['area_sqft'] : ''; ?>" placeholder="Enter Property Area">
                        <span id="area_sqft-error" style="color: red;"></span>
                      </div>
                    </div> 

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Bed Room :<span style="color: red;">*</span></label>

                      <div class="col-md-8">
                        <input type="text" class="form-control" name="bedroom" id="bedroom" value="<?php echo isset($edit_data[0]['bedroom']) ? $edit_data[0]['bedroom'] : ''; ?>" placeholder="Enter Bed room">
                        <span id="bedroom-error" style="color: red;"></span>
                      </div>
                    </div>  
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Bath :<span style="color: red;">*</span></label>

                      <div class="col-md-8">
                        <input type="text" class="form-control" name="bath" id="bath" value="<?php echo isset($edit_data[0]['bath']) ? $edit_data[0]['bath'] : ''; ?>" placeholder="Enter Bath">
                        <span id="bath-error" style="color: red;"></span>
                      </div>
                    </div> 

                    <div class="form-group col-md-6">
                        <label for="" class="col-md-4 control-label">Agent :<span style="color: red;">*</span></label>

                        <div class="col-md-8">
                            <select name="agent_id" id="agent_id" class="form-control selectpicker agent_id select2">
                                <option value="">Select Agent</option>
                                <?php 
                                  if($mode == 'add'){
                                    foreach ($team as $v_key => $v_value){
                                        echo '<option value="'.$v_value['id'].'">'.$v_value['name'].'</option>';
                                      }
                                  }else{
                                      foreach ($team as $ve_key => $ve_value){
                                          $selected = $edit_data[0]['agent_id'] == $ve_value['id'] ? 'selected' : '';
                                          echo '<option value="'.$ve_value['id'].'" '.$selected.'>'.$ve_value['name'].'</option>';
                                      }
                                    }
                                ?>
                            </select>
                            <span id="agent_id-error" style="color: red;"></span>
                        </div>
                    </div> 
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-12">

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Description :</label>

                      <div class="col-md-8">
                        <textarea name="description" id="description" rows="4" cols="50"><?php echo isset($edit_data[0]['description']) ? $edit_data[0]['description'] : ''; ?></textarea>
                      </div>
                    </div> 


                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Maps :</label>

                      <div class="col-md-8">
                        <textarea name="maps" id="maps" rows="4" cols="50"><?php echo isset($edit_data[0]['maps']) ? $edit_data[0]['maps'] : ''; ?></textarea>
                      </div>
                    </div> 
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    
                  <?php if($mode == 'edit'){ ?>
                    <div class="form-group col-md-6">
                      <a href="<?= base_url(); ?>admin_panel/Products/upload_image/<?= $edit_data[0]['id'] ?>" class="btn btn-primary" >Upload Images</a>
                    </div>
                  <?php } ?>
                    <div class="form-group col-md-6">
                      <input type="hidden" name="submit_type" value="" id="submit_type">
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-12">
                    <!-- Button -->
                     <div class="form-group">
                       <label class="control-label"></label>
                       <div class="col-md-6 col-md-offset-6">
                         <button type="submit" class="btn btn-primary" name="save_exit" id="save_exit" style="text-align: center;">Save<span class="glyphicon glyphicon-send"></span></button>
                         <!-- <button type="submit" class="btn btn-primary pull-right" name="save_next" id="save_next"  style="margin: 0 5px 0 0;">Save & Next <span class="glyphicon glyphicon-send"></span></button> -->
                       </div>
                     </div>
                  </div>
                </div>
               

              <?php echo form_close(); ?>          
          
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer">
          Footer
        </div> -->
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('admin_panel/common_file/common_footer'); ?>

  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php $this->load->view('admin_panel/common_file/footer_script'); ?>

<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- JS Tree -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.0.9/jstree.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/jstree/jstree.min.js"></script>

<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });
</script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>


<!-- Image Upload Jquery -->
<script type="text/javascript">
  $(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
    var input = $(this),
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function(event, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
      
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#img-upload').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this);
    });   
  });

  $("#save_exit").click(function(e){
    remove_error_function();
    var business_type   = $("#business_type").val();
    var property_type    = $("#property_type").val();
    var price = $("#price").val();
    var area = $("#area").val();
    var region = $("#region").val();
    var property_title = $("#property_title").val();
    var price_sq_ft = $("#price_sq_ft").val();
    var project_feature = $("#project_feature").val();
    var amenities_include = $("#amenities_include").val();
    var area_sqft = $("#area_sqft").val();
    var bedroom = $("#bedroom").val();
    var bath = $("#bath").val();
    var agent_id = $("#agent_id").val();
    var submit_flag           = 1;

    if(!business_type){
      submit_flag = 0;
      $("#business_type-error").text('Please Select Businees Type');
      e.preventDefault();
    }

    if(!property_type){
      submit_flag = 0;
      $("#property_type-error").text('Please Select Property Type');
      e.preventDefault();
    }

    if(!price){
      submit_flag = 0;
      $("#price-error").text('Please Enter Price');
      e.preventDefault();
    }

    if(!area){
      submit_flag = 0;
      $("#area-error").text('Please Enter Location');
      e.preventDefault();
    }

    if(!region){
      submit_flag = 0;
      $("#region-error").text('Please Enter Region');
      e.preventDefault();
    }

    if(!property_title){
      submit_flag = 0;
      $("#property_title-error").text('Please Enter Property Title');
      e.preventDefault();
    }

    if(!price_sq_ft){
      submit_flag = 0;
      $("#price_sq_ft-error").text('Please Enter Price Sq Ft');
      e.preventDefault();
    }

    if(!project_feature){
      submit_flag = 0;
      $("#project_feature-error").text('Please Enter Select Project Fetures');
      e.preventDefault();
    }

    if(!amenities_include){
      submit_flag = 0;
      $("#amenities_include-error").text('Please Enter Select Amenties');
      e.preventDefault();
    }

    if(!area_sqft){
      submit_flag = 0;
      $("#area_sqft-error").text('Please Enter Area Sqft');
      e.preventDefault();
    }

    if(!bedroom){
      submit_flag = 0;
      $("#bedroom-error").text('Please Enter Bedroom');
      e.preventDefault();
    }

    if(!bath){
      submit_flag = 0;
      $("#bath-error").text('Please Enter Bath');
      e.preventDefault();
    }

    if(!agent_id){
      submit_flag = 0;
      $("#agent_id-error").text('Please Enter Agent');
      e.preventDefault();
    }

    if(submit_flag == 1){
        $("#submit_type").val(2);
        $("#contact_form").submit();
    }
  });

  function remove_error_function(){

    $("#business_type-error").text(' ');
    $("#property_type-error").text(' ');
    $("#price-error").text(' ');
    $("#area-error").text(' ');
    $("#region-error").text(' ');
    $("#property_title-error").text(' ');
    $("#price_sq_ft-error").text(' ');
    $("#project_feature-error").text(' ');
    $("#amenities_include-error").text(' ');
    $("#area_sqft-error").text(' ');
    $("#bedroom-error").text(' ');
    $("#bath-error").text(' ');
    $("#agent_id-error").text(' ');
  }
</script>

<!-- PNotify -->
<script type="text/javascript">
  $(document).ready(function(){
    <?php if ($this->session->flashdata('success') == 'yes') { ?>
      new PNotify({
          title: 'Success!',
          text: 'Property Added Succesfully',
          type: 'success'
      });
    <?php } ?>
    <?php if ($this->session->flashdata('error') == 'no') { ?>
      new PNotify({
          title: 'Error!',
          text: 'Something Went Wrong',
          type: 'error'
      });
    <?php } ?>
  });
</script>
</body>
</html>
