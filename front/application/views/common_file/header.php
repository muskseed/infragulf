<header>
    <?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
<div class="container">
    <div class="row">
    <div class="col-lg-12">
        <div class="flex-wrap flex-center">
        <div class="brand">
            <a href="<?php echo BASE_URL; ?>">
            <img width="230" height="38" class="img-fluid" src="<?php echo BASE_URL; ?>assets/images/blak-and-white-logo.svg?ver=.03" align="Infra Guilf">
            </a>
        </div>
        <div class="nav ml-auto">
            <div class="toggle-menu toggle-close">
            <span></span>
            <span></span>
            <span></span>
            </div>
            <ul class="navlist flex-wrap flex-center">

            <li class="<?= ($activePage == 'buy') ? 'active':''; ?>">
                <a href="<?php echo BASE_URL; ?>buy">Buy</a>
            </li>
            <li class="<?= ($activePage == 'rent') ? 'active':''; ?>">
                <a href="<?php echo BASE_URL; ?>rent">Rent</a>
            </li>
            <li class="<?= ($activePage == 'sell') ? 'active':''; ?>">
                <a href="<?php echo BASE_URL; ?>sell">Sell</a>
            </li>

            <li class="<?= ($activePage == 'property_management') ? 'active':''; ?>">
                <a href="<?php echo BASE_URL; ?>property_management">Property Management</a>
            </li>

            <li class="<?= ($activePage == 'projects') ? 'active':''; ?>">
                <a href="<?php echo BASE_URL; ?>projects">Projects</a>
            </li>

            <li class="<?= ($activePage == 'design') ? 'active':''; ?>">
                <a href="<?php echo BASE_URL; ?>design">Designs</a>
            </li>
            <li class="<?= ($activePage == 'who') ? 'active':''; ?>">
                <a href="<?php echo BASE_URL; ?>who">About Us</a>
            </li>
            <li>
                <a href="tel:+971521940000"><img src="<?php echo BASE_URL; ?>assets/images/call-icon.svg">Call us</a>
            </li>
            </ul>
        </div>
        </div>
    </div>
    </div>
</div>
</header>