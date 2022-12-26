<!DOCTYPE html>
<html>   
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= COMPANY_NAME; ?> | Upload Image</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- All CSS and JS File -->
  <?php $this->load->view('admin_panel/common_file/header'); ?>
   <style type="text/css">
    .files input {
        outline: 2px dashed #92b0b3;
        outline-offset: -10px;
        -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
        transition: outline-offset .15s ease-in-out, background-color .15s linear;
        padding: 120px 0px 85px 35%;
        text-align: center !important;
        margin: 0;
        width: 100% !important;
    }
    .files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
        -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
        transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
     }
    .files{ position:relative}
    .files:after {  pointer-events: none;
        position: absolute;
        top: 60px;
        left: 0;
        width: 50px;
        right: 0;
        height: 56px;
        content: "";
        background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
        display: block;
        margin: 0 auto;
        background-size: 100%;
        background-repeat: no-repeat;
    }
    .color input{ background-color:#f1f1f1;}
    .files:before {
        position: absolute;
        bottom: 10px;
        left: 0;  pointer-events: none;
        width: 100%;
        right: 0;
        height: 57px;
        content: " or drag it here. ";
        display: block;
        margin: 0 auto;
        color: #2ea591;
        font-weight: 600;
        text-transform: capitalize;
        text-align: center;
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
        <?php echo $this->session->userdata('module_name'); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>admin_panel/<?= $this->session->userdata('module_name'); ?>"><?php echo $this->session->userdata('module_name'); ?></a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Uplaod Broucher</h3>

         </div>
         <div class="box-body">

            <!-- Container of Form -->
            <!-- <div class="container"> -->
               <?php
               //form open
                  $form_attributes = array('class' => 'form-horizontal', 'id' => 'contact_form', 'method' => 'post');

                  echo form_open_multipart('admin_panel/off_plan/broucher_upload_file', $form_attributes);

               ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                              <div class="form-group files">
                                <label>Upload Your File </label>
                                <input type="file" name="product_image" id="product_image" class="form-control" multiple="">
                              </div>
                              <input type="hidden" name="product_id" id="product_id" value="<?= $id; ?>">
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <!-- Button -->
                         <div class="form-group">
                           <label class="control-label"></label>
                           <div class="col-md-6 col-md-offset-6">
                             <button type="submit" class="btn btn-primary" style="text-align: center;">Submit <span class="glyphicon glyphicon-send"></span></button>
                           </div>
                         </div>
                      </div>
                    </div>
                </div>

              <?php echo form_close(); ?>
            <!-- </div>  -->           
                <div class="container">
                    <div class="row">
                        <?php 
                        if(isset($image_name) && !empty($image_name)){
                            foreach ($image_name as $key => $value) {
                        ?>
                            <div class="col-md-3" style="margin: 10px 30px 10px 15px;">
                               <iframe src="<?= BASE_URL.NOTIFICATION.$value['broucher_file']; ?>" width="300" height="300"></iframe>
                            </div>
                        <?php
                            }
                        }
                        ?>
                        
                    </div>
                </div>
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
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>

<script type="text/javascript">
     $(document).ready(function() {
    $('#contact_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            product_image: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            }
        })
        .on('success.form.bv', function(e) {
            $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#contact_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
});


</script>

</body>
</html>
