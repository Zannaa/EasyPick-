<!DOCTYPE html>
<html ng-app="easypick">
  <head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/custom.css" />
    <!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/angular-recaptcha.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&render=explicit"
  async defer></script>
  </head>
  <body ng-controller="NavigationController as navCtrl">
  <header class="head-default">
    <div class="header-mask"></div>
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
          <a class="navbar-brand" href="#">EasyPick</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li><a href ng-click="navCtrl.selectForm(1)">Prijava</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

  </header>

  <section class="section-login" ng-show="navCtrl.isSelected(1)">
  <login-form></login-form>
  </section>

  <section class="section-password-reset" ng-show="navCtrl.isSelected(2)">
  <pass-reset-form></pass-reset-form>
  </section>

  <section class="section-registration" ng-show="navCtrl.isSelected(3)">
  <register-form></register-form>
  </section>

  </body>
</html>
