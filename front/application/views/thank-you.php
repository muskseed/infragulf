<!doctype html>
<html lang="en">
  <head>   
    <title>Thank you</title>
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php 
      $this->load->view('common_file/style');
    ?>
    <style type="text/css">
      .checkmark__circle {
  stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke-miterlimit: 10;
    stroke: var(--white);
    fill: var(--gray);
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark {
 width: 76px;
    height: 76px;
    border-radius: 50%;
    display: block;
    stroke-width: 2;
    stroke: var(--white);
    stroke-miterlimit: 10;
    margin: auto;
    box-shadow: inset 0px 0px 0px #7ac142;
    animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    background: var(--dark-gray);
}

.checkmark__check {
  transform-origin: 50% 50%;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

.title{color: var(--white);}

@keyframes stroke {
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes scale {
  0%, 100% {
    transform: none;
  }
  50% {
    transform: scale3d(1.1, 1.1, 1);
  }
}
@keyframes fill {
  100% {
    box-shadow: inset 0px 0px 0px 30px #7ac142;
  }
}
    </style>
  </head>
  <body>
  



  <section class="p-relative bg-dark p-tb-7">
    
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <div class="brand">
              <a href="<?php echo BASE_URL; ?>">
                <img width="281" height="47" class="img-fluid" src="<?php echo BASE_URL; ?>assets/images/infra-gulf-white-logo.svg?ver=0.2" align="Infra Gulf">
              </a>
            </div>
            <div class="hading-section">
              <svg class="checkmark mt-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
              </svg>
              <h1 class="title mt-2">Thank <span>you</span></h1>
              <p class="title-text mt-1">We have received your details and our Customer Support will get in touch with you!</p>              
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
          <ul class="breadcrumb text-center">
            <li>
              <a href="<?php echo BASE_URL; ?>">
                <img src="<?php echo BASE_URL; ?>assets/images/home-icon.svg">
              </a>
            </li>
            <li>Thank you</li>
            
          </ul>
        </div>
      </div>
    </div>
  </section>


  
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

      <script>
    var form_session = "<?php echo $this->session->userdata('form_session'); ?>";
    // console.log('form'+form_session);
  </script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>
  

  </body>
</html>