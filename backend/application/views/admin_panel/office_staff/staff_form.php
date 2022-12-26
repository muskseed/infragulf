<!DOCTYPE html>
<html>   
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= COMPANY_NAME; ?> | Team Form</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- All CSS and JS File -->
  <?php $this->load->view('admin_panel/common_file/header'); ?>
  
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bower_components/select2/dist/css/select2.min.css">
  <style type="text/css">
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
        width: 100%;
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
        <li><a href="<?php echo base_url(); ?>admin_panel/office_staff"><?php echo $this->session->userdata('module_name'); ?></a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title"><?php echo $this->session->userdata('module_name'); ?> Form</h3>

         </div>
         <div class="box-body">

            <!-- Container of Form -->
               <?php
               //form open
                  $form_attributes = array('class' => 'form-horizontal', 'id' => 'contact_form', 'method' => 'post');

                  echo form_open_multipart(isset($edit_data[0]['id']) ? 'admin_panel/office_staff/form_action/'.$edit_data[0]['id'] : 'admin_panel/office_staff/form_action', $form_attributes);

               ?>
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">Member Name:<span style="color: red;">*</span></label>

                            <div class="col-md-8">
                            <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo isset($edit_data[0]['full_name']) ? $edit_data[0]['full_name'] : ''; ?>" placeholder="Enter Name">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">Email ID:<span style="color: red;">*</span></label>

                            <div class="col-md-8">
                            <input type="text" class="form-control" name="email_id" id="email_id" value="<?php echo isset($edit_data[0]['email_id']) ? $edit_data[0]['email_id'] : ''; ?>" placeholder="Enter Email ID">
                            </div>
                        </div>
                    </div>
                </div>  

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">Mobile Number:<span style="color: red;">*</span></label>

                            <div class="col-md-8">
                            <input type="text" class="form-control" name="mobile_number" id="mobile_number" value="<?php echo isset($edit_data[0]['mobile_number']) ? $edit_data[0]['mobile_number'] : ''; ?>" placeholder="Enter Mobile Number">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">Password :<span style="color: red;">*</span></label>

                            <div class="col-md-8">
                            <input type="text" class="form-control" name="password" id="password" value="<?php echo isset($edit_data[0]['password']) ? $edit_data[0]['password'] : ''; ?>" placeholder="Enter Password">
                            </div>
                        </div>
                    </div>
                </div>  

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group col-md-6">
                            <label class="col-md-4 control-label">Designation:</label>

                            <div class="col-md-8">
                            <input type="text" class="form-control" name="designation" id="designation" value="<?php echo isset($edit_data[0]['designation']) ? $edit_data[0]['designation'] : ''; ?>" placeholder="Enter Designation">
                            </div>
                        </div>

                    </div>
                </div>  
                  
                
                <div class="row">
                  <!-- Button -->
                   <div class="form-group">
                     <label class="control-label"></label>
                     <div class="col-md-6 col-md-offset-6">
                       <button type="submit" class="btn btn-primary pull-right" >Save <span class="glyphicon glyphicon-send"></span></button>
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
<script src="<?php echo base_url(); ?>bower_components/select2/dist/js/select2.full.min.js"></script>
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

            name: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            mobile: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            whatsapp: {
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
</script>

</body>
</html>
