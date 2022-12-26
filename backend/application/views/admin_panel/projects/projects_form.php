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
        Projects
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>admin_panel/Projects">Projects</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Projects Form</h3>

         </div>
         <div class="box-body">

            <!-- Container of Form -->
               <?php
               //form open
                  $form_attributes = array('class' => 'form-horizontal', 'id' => 'contact_form', 'method' => 'post','autocomplete'=>'off');

                  echo form_open_multipart(isset($edit_data[0]['id']) ? 'admin_panel/Projects/form_action/'.$edit_data[0]['id'] : 'admin_panel/Projects/form_action', $form_attributes);

               ?>


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
                            <input type="text" class="form-control" name="location" id="location" value="<?php echo isset($edit_data[0]['location']) ? $edit_data[0]['location'] : ''; ?>" placeholder="Enter Location">
                            <span id="location-error" style="color: red;"></span>
                          </div>
                        </div> 
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group col-md-6">
                          <label class="col-md-4 control-label">Project Status:<span style="color: red;">*</span></label>

                          <div class="col-md-8">
                            <input type="text" class="form-control" name="project_status" id="project_status" value="<?php echo isset($edit_data[0]['project_status']) ? $edit_data[0]['project_status'] : ''; ?>" placeholder="Enter Project Status">
                            <span id="project_status-error" style="color: red;"></span>
                          </div>
                        </div> 

                       
                    </div>
                </div>
                
                

                <div class="row">
                  <div class="col-md-12">
                    
                  <?php if($mode == 'edit'){ ?>
                    <div class="form-group col-md-6">
                      <a href="<?= base_url(); ?>admin_panel/Projects/upload_image/<?= $edit_data[0]['id'] ?>" class="btn btn-primary" >Upload Images</a>
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
    var price = $("#price").val();
    var project_status = $("#project_status").val();
    var location = $("#location").val();
    var submit_flag           = 1;

    if(!price){
      submit_flag = 0;
      $("#price-error").text('Please Enter Price');
      e.preventDefault();
    }

    if(!project_status){
      submit_flag = 0;
      $("#project_status-error").text('Please Enter Project Status');
      e.preventDefault();
    }

    if(!location){
      submit_flag = 0;
      $("#location-error").text('Please Enter Location');
      e.preventDefault();
    }

    if(submit_flag == 1){
        $("#submit_type").val(2);
        $("#contact_form").submit();
    }
  });

  function remove_error_function(){

    $("#price-error").text(' ');
    $("#project_status-error").text(' ');
    $("#location-error").text(' ');
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
