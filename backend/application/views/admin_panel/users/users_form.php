<!DOCTYPE html>
<html>   
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= COMPANY_NAME; ?> | User Form</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- All CSS and JS File -->
  <?php $this->load->view('admin_panel/common_file/header'); ?>
  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
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
        Customers
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>admin_panel/Users">Customers</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Customers Form</h3>

         </div>
         <div class="box-body">

            <!-- Container of Form -->
               <?php
               //form open
                  $form_attributes = array('class' => 'form-horizontal', 'id' => 'contact_form', 'method' => 'post');

                  echo form_open(isset($edit_data[0]['id']) ? 'admin_panel/Users/form_action/'.$edit_data[0]['id'] : 'admin_panel/Users/form_action', $form_attributes);

               ?>
                <div class="row">

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Mobile Number:<span style="color: red;">*</span></label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                          <input type="text" class="form-control" name="mobile_number"  id="mobile_number" value="<?php echo isset($edit_data[0]['mobile_number']) ? $edit_data[0]['mobile_number'] : ''; ?>" placeholder="Mobile Number">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Password:<span style="color: red;">*</span></label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-ellipsis-h"></i></span>
                          <input type="text" class="form-control" name="password"  id="password" value="<?php echo isset($edit_data[0]['password']) ? $edit_data[0]['password'] : ''; ?>" placeholder="Password">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Email ID:<span style="color: red;">*</span></label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                          <input type="text" class="form-control" name="email_id"  id="email_id" value="<?php echo isset($edit_data[0]['email_id']) ? $edit_data[0]['email_id'] : ''; ?>" placeholder="Enter Email">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label"> Full Name:<span style="color: red;">*</span></label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="text" class="form-control" name="full_name"  id="full_name" value="<?php echo isset($edit_data[0]['full_name']) ? $edit_data[0]['full_name'] : ''; ?>" placeholder="Enter Full Name">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label"> Short Name:<span style="color: red;">*</span></label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="text" class="form-control" name="short_name"  id="short_name" value="<?php echo isset($edit_data[0]['short_name']) ? $edit_data[0]['short_name'] : ''; ?>" placeholder="Enter Short Name">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Company Type:<span style="color: red;">*</span></label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                          <select name="company_type_id" id="company_type_id" class="form-control selectpicker company_type_id">
                            <option></option>
                          <?php foreach($company_type as $value)
                          { 
                            if($edit_data[0]['company_type_id'] == $value['id'])
                            {
                              $selected = 'selected'; 
                            }else{
                              $selected = '';
                            }  
                          ?>
                            <option value="<?php echo $value['id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
                          <?php } ?>
                        </select>
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">User Type:<span style="color: red;">*</span></label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <select name="usertype_id" id="usertype_id" class="form-control selectpicker usertype_id">
                          <?php foreach($usertype_data as $value)
                          { 
                            if($edit_data[0]['usertype_id'] == $value['id'])
                            { 
                              $selected = 'selected';
                            }else{
                              $selected = '';
                            }
                          ?>
                              <option value="<?php echo $value['id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
                          <?php } ?>
                        </select>
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Organisation : </label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
                          <input type="text" class="form-control" name="shop_name"  id="shop_name" value="<?php echo isset($edit_data[0]['shop_name']) ? $edit_data[0]['shop_name'] : ''; ?>" placeholder="Enter Shop Name">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">Pincode:</label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
                          <input type="text" class="form-control" name="pincode"  id="pincode" value="<?php echo isset($edit_data[0]['pincode']) ? $edit_data[0]['pincode'] : ''; ?>" placeholder="Enter Pincode">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label">User Status:</label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="hidden" name="user_status_db" value="<?php echo $edit_data[0]['user_status']; ?>">
                          <select name="user_status" id="user_status" class="form-control selectpicker user_status">
                          <?php foreach($user_status as $value)
                          { 
                            if($edit_data[0]['user_status'] == $value['status'])
                            { 
                              $selected = 'selected';
                            }else{
                              $selected = '';
                            }
                          ?>
                              <option value="<?php echo $value['status']; ?>" <?php echo $selected; ?>><?php echo $value['status']; ?></option>
                          <?php } ?>
                        </select>
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label"> GST:</label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="text" class="form-control" name="gst"  id="gst" value="<?php echo isset($edit_data[0]['gst']) ? $edit_data[0]['gst'] : ''; ?>" placeholder="Enter GST">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label"> Delivery Mode:</label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <select name="delivery_mode" id="delivery_mode" class="form-control selectpicker delivery_mode">
                          <?php foreach($delivery_mode as $value)
                          { 
                            if($edit_data[0]['delivery_mode'] == $value['id'])
                            { 
                              $selected = 'selected';
                            }else{
                              $selected = '';
                            }
                          ?>
                              <option value="<?php echo $value['id']; ?>" <?php echo $selected; ?>><?php echo $value['mode_name']; ?></option>
                          <?php } ?>
                        </select>
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label"> Payment Terms:</label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="text" class="form-control" name="payment_terms"  id="payment_terms" value="<?php echo isset($edit_data[0]['payment_terms']) ? $edit_data[0]['payment_terms'] : ''; ?>" placeholder="Enter Payment Terms">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label"> PAN:</label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="text" class="form-control" name="pan"  id="pan" value="<?php echo isset($edit_data[0]['pan']) ? $edit_data[0]['pan'] : ''; ?>" placeholder="Enter Pan">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label"> Designation:</label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="text" class="form-control" name="designation"  id="designation" value="<?php echo isset($edit_data[0]['designation']) ? $edit_data[0]['designation'] : ''; ?>" placeholder="Enter Designation">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label"> Birthday:</label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="text" class="form-control" name="birthday"  id="birthday" value="<?php echo isset($edit_data[0]['birthday']) ? $edit_data[0]['birthday'] : ''; ?>" placeholder="Enter Birthday">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label class="col-md-4 control-label"> Anniversary Date:</label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="text" class="form-control" name="anniversary_date"  id="anniversary_date" value="<?php echo isset($edit_data[0]['anniversary_date']) ? $edit_data[0]['anniversary_date'] : ''; ?>" placeholder="Enter Anniversary date">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-6"> 
                        <label class="col-md-4 control-label">Country:</label>
                          <div class="selectContainer">
                          <div class="input-group">
                              <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                          <select name="country_id" id="country_id" class="form-control selectpicker country_id">
                           <option value=""></option>
                          </select>
                        </div>
                      </div>
                      </div>

                    <div class="form-group col-md-6"> 
                      <label class="col-md-4 control-label">State:</label>
                        <div class="selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                        <select name="state_id" id="state_id" class="form-control selectpicker state_id">
                        <option value=""></option>
                        </select>
                      </div>
                    </div>
                    </div>

                    <div class="form-group col-md-6"> 
                      <label class="col-md-4 control-label">City:</label>
                        <div class="selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                          <select name="city_id" id="city_id" class="form-control selectpicker city_id">  
                          <option value=""></option>
                          
                          </select>
                        </div>
                      </div>
                    </div>

                    

                    <div class="form-group col-md-4"  id="login_date_div">
                      <label class="col-md-4 control-label"> Enter Access End Date:</label>
                      <div class=" inputGroupContainer">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                          <input type="text" class="form-control" name="login_date"  id="login_date" value="<?php echo isset($edit_data[0]['login_date']) ? $edit_data[0]['login_date'] : ''; ?>" placeholder="Enter Login Date">
                        </div>   
                      </div>
                    </div>

                    <div class="form-group col-md-2"  id="login_time_div">
                      <label class="col-md-8 control-label">Hours: </label>
                      <div class=" inputGroupContainer">
                        <div class="input-group col-md-4">
                          <input type="text" class="form-control" name="login_hours"  id="login_hours" value="<?php echo isset($edit_data[0]['login_hours']) ? $edit_data[0]['login_hours'] : ''; ?>" placeholder="Enter Login Hours">
                        </div>  
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="col-md-6 control-label">Minutes: </label>
                          <div class="input-group col-md-6">
                            <input type="text" class="form-control" name="login_minutes"  id="login_minutes" value="<?php echo isset($edit_data[0]['login_minutes']) ? $edit_data[0]['login_minutes'] : ''; ?>" placeholder="Enter Login Minutes">
                          </div>  
                    </div>
                    <div class="form-group col-md-2">
                        <div class="input-group col-md-4">
                            <select name="clock" id="clock" class="form-control clock">  
                            <option value="am" <?php echo $edit_data[0]['clock'] == 'am' ? 'selected' : ''; ?> >AM</option>
                            <option value="pm" <?php echo $edit_data[0]['clock'] == 'pm' ? 'selected' : ''; ?> >PM</option>
                            </select>
                        </div> 
                    </div>
                    <div class="form-group col-md-2">
                      <?php if($mode == 'edit'){
                      ?>
                        <a href="<?php echo base_url();?>admin_panel/users/assign_collection/<?php echo $edit_data[0]['id']; ?>"> <button type="button" class="btn btn-success">Assign</button></a>
                      <?php  
                      } ?>
                      
                    </div>
                </div>

               <!-- Button -->
               <div class="form-group">
                 <label class="control-label"></label>
                 <div class="col-md-6 col-md-offset-6">
                   <button type="submit" class="btn btn-primary pull-right" >Send <span class="glyphicon glyphicon-send"></span></button>
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
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
   $(function() {
      $( "#birthday").datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#anniversary_date").datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#login_date").datepicker({ dateFormat: 'yy-mm-dd' });
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

            mobile_number: {
                validators: {
                     stringLength: {
                        min: 10,
                    },
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            email_id: {
                validators: {
                     stringLength: {
                        min: 6,
                    },
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            full_name: {
                validators: {
                     stringLength: {
                        min: 4,
                    },
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            client_id: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            company_type_id: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            }
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
<script>
function ajaxCall()
{
  this.send = function(data, url, method, success, type)
  {
    type = type||'json';
    var successRes = function(data)
    {
      success(data);
    };

    var errorRes = function(e)
    {
      console.log(e);
      alert("Error found \nError Code: "+e.status+" \nError Message: "+e.statusText);
    };
    $.ajax({
      url: url,
      type: method,
      data: data,
      success: successRes,
      error: errorRes,
      dataType: type,
      timeout: 60000
    });
  }
}

function locationInfo()
{
    var rootUrl = "<?php echo base_url();?>admin_panel/Clients/get_records";
    var call = new ajaxCall();

  this.getCities = function(id)
  {
    $(".city_id option:gt(0)").remove();
    var url = rootUrl+'?type=getCities&stateId=' + id;
    var method = "post";
    var data = {};
    $('.city_id').find("option:eq(0)").html("Please wait..");
    call.send(data, url, method, function(data)
    {
      $('.city_id').find("option:eq(0)").html("Select City");
      if(data.tp == 1)
      {
        $.each(data['result'], function(key, val)
        {
          var option = $('<option />');
          option.attr('value', key).text(val);
          $('.city_id').append(option);
        });
        $(".city_id").prop("disabled",false);
        <?php if(isset($edit_data[0]['city_id'])){ ?>
          var city_id = <?php echo $edit_data[0]['city_id'];?>;
          // $('.city_id').val(city_id);
          $('.city_id option[value='+city_id+']').prop('selected', 'selected').change();
          // $(".city_id").select2();
        <?php } ?>
      }
      else
      {
        alert(data.msg);
      }
    });
  };

  this.getStates = function(id)
  {
    $(".state_id option:gt(0)").remove(); 
    $(".city_id option:gt(0)").remove(); 
    var url = rootUrl+'?type=getStates&countryId=' + id;
    var method = "post";
    var data = {};
    $('.state_id').find("option:eq(0)").html("Please wait..");
    call.send(data, url, method, function(data)
    {
      $('.state_id').find("option:eq(0)").html("Select State");
      if(data.tp == 1)
      {
        $.each(data['result'], function(key, val)
        {
          var option = $('<option />');
          option.attr('value', key).text(val);
          $('.state_id').append(option);
        });
        $(".state_id").prop("disabled",false);
        <?php if(isset($edit_data[0]['state_id'])){ ?>
          var state_id = <?php echo $edit_data[0]['state_id'];?>;
          // $('.state_id').val(state_id);
          $('.state_id option[value='+state_id+']').prop('selected', 'selected').change();
          // $(".state_id").select2();
        <?php } ?>
      }
      else
      {
        alert(data.msg);
      }
    });
  };

  


  this.getCountries = function()
  {
    var url = rootUrl+'?type=getCountries';
    var method = "post";
    var data = {};
    $('.country_id').find("option:eq(0)").html("Please wait...");
    call.send(data, url, method, function(data)
    {
      $('.country_id').find("option:eq(0)").html("Select Country");
      // console.log(data);
      if(data.tp == 1)
      {
        $.each(data['result'], function(key, val)
        {
          var option = $('<option />');
          option.attr('value', key).text(val);
          $('.country_id').append(option);
        });
        $(".country_id").prop("disabled",false);
        <?php if(isset($edit_data[0]['country_id'])){ ?>
          var country_id = <?php echo $edit_data[0]['country_id'];?>;
          // $('.country_id').val(country_id);
          $('.country_id option[value='+country_id+']').prop('selected', 'selected').change();
          // $(".country_id").select2();
        <?php } ?>
      }
      else
      {
        alert(data.msg);
      }
    });
  };
}

$(document).ready(function(){
  var loc = new locationInfo();
  
  loc.getCountries();

  $(".country_id").on("change",function(ev){
    var countryId = $(this).val();
    if(countryId != '')
    {
      loc.getStates(countryId);
    }
    else
    {
      $(".state_id option:gt(0)").remove();
    }
  });

  $(".state_id").on("change",function(ev){
    var stateId = $(this).val();
    if(stateId != '')
    {
      loc.getCities(stateId);
    }
    else
    {
      $(".city_id option:gt(0)").remove();
    }
  });

  $('.custom_contact_number').keypress(function (e) {
    var regex = new RegExp("^[0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
       return true;
     }
     e.preventDefault();
    return false;
  });

  $('.pincode').keypress(function (e) {
    var regex = new RegExp("^[0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
       return true;
     }
     e.preventDefault();
    return false;
  }); 

});

$("#login_system").change(function(){
  date_wise();
})
$(document).ready(function() {
  date_wise();
})
function date_wise(){
  var login_system  = $("#login_system").val();
  if(login_system == 1){
    $("#login_date_div").show();
    $("#login_time_div").hide();
  }else if(login_system == 2){
    $("#login_date_div").hide();
    $("#login_time_div").show();
  }
}

$("#login_time").keyup(function(){
  var login_time  = $(this).val();
  if(login_time < 13){

  }else{
    alert('Please Enter Number till 12 only');
    $(this).val(' ');
  }
})
</script>
</body>
</html>
