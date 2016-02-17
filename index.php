<link rel="stylesheet" href='../resources/bootstrap/css/bootstrap.min.css'>
<link rel='stylesheet' href='../resources/bootstrap/css/bootstrap-theme.min.css'>
<link rel='stylesheet' href='../resources/font-awesome-4.4.0/css/font-awesome.min.css'>
<link rel='stylesheet' href='../resources/jquery/jquery-ui-1.11.4/jquery-ui.min.css'>
<link rel='stylesheet' href='resources/stylesheet.css'>
<script src='../resources/bootstrap/js/jquery.min.js'></script>
<script src='../resources/jquery/jquery-ui-1.11.4/jquery-ui.min.js'></script>
<script src='../resources/bootstrap/js/bootstrap.min.js'></script>
<script src='resources/jquery-stickytabs.js'></script>
<script src='resources/javascript.js'></script>
<link rel="icon" href="resources/img/LIFE_logo_196.png">
<link rel="apple-touch-icon-precomposed" href="resources/img/LIFE_logo_196.png">
<script>
$(document).ready(function(){
        var options = { 
        backToTop: true
    };
    $('.nav-tabs').stickyTabs( options );
    
});
</script>
<?php 
    // Connect to database
    include_once 'db_connect.php'
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">OPAL</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <li class="active"><a href="#">Marriage Retreats <span class="sr-only">(current)</span></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right"> 
          <button type="button" class="btn btn-default navbar-btn">Sign in</button>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class='wrapper'>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#retreat-tab" data-toggle="tab">Retreats</a></li>
        <li role="presentation"><a href="#couple-tab" data-toggle="tab">Couples</a></li>
    </ul>
    <!-- Start Overlay -->
<div id="overlay" onClick='toggleOverlay()'></div>
<!-- End Overlay -->
<!-- Start Special Centered Box -->
<div id="specialBox">
    <i class="fa fa-times-circle-o fa-2x" id="closeButton" onclick="toggleOverlay()"></i>
    <div id='specialBoxWrapper'>
    </div>

</div>
<!-- End Special Centered Box -->
<!-- Begin Tabbed Section -->
    <div class="tab-content">
        <div id='retreat-tab' class='tab-pane fade in active'>
<!-- Retreat Toolbar -->
            <nav class="navbar navbar-default">
                <div class="tool-bar">
                    <button type="button" class="btn btn-primary navbar-btn" onclick="addRetreat()">
                        <i class="fa fa-plus fa-lg"></i> Add Retreat
                    </button>
                    <button type="button" class="btn btn-primary navbar-btn" onclick="deleteRetreat()">
                        <i class="fa fa-plus fa-lg"></i> Delete Retreat
                    </button>
                </div>
            </nav>
<!-- End toolbar -->
          <div id="side-menu">
                <div class="menu-item">
                    <h4><a href="#">Misc Couples</a></h4>
                    <?php
                        include 'retreat_tab/misc_couples.php';
                    ?>
                </div>
            </div>
            <div id='retreatTable'>
                <?php
                    include 'retreat_tab/retreats.php';
                ?>
            </div>
        </div>
        <div id='couple-tab' class='tab-pane fade'>
<!-- Couple Toolbar -->
            <nav class="navbar navbar-default">
                <div class="tool-bar">
                    <button type="button" class="btn btn-primary navbar-btn" onclick="coupleButton('add_couple_form.php')">
                        <i class="fa fa-plus fa-lg"></i> Add Couple
                    </button>
                </div>
            </nav>
<!-- End toolbar -->

            <div>
                <?php
                    include 'couple_tab/couple_info.php';
                ?>
            </div>
        </div>
    </div>
    
</div>