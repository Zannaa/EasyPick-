<!DOCTYPE html>
<html ng-app="easypick">
<head>
    <!-- load bootstrap and fontawesome via CDN -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />
    <!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" /> !-->
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/custom.css" />
    <link rel="stylesheet" type="text/css" href="css/korisnik.css" />
    <!-- Angular i Angular-route via CDN -->
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-route.js"></script>
    <!-- UI Bootstrap for Angular -->
    <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-1.3.2.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="js/app.js"></script>
    <!-- reCaptcha -->
    <script type="text/javascript" src="js/angular-recaptcha.min.js"></script>
    <script type="text/javascript" src="js/angular-translate.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&render=explicit"
            async defer></script>
    <!--<script src="https://code.angularjs.org/1.3.14/angular-animate.js"></script>!-->

    <script src="bower_components/lodash/lodash.js"></script>
    <script src="bower_components/cloudinary-core/cloudinary-core.js"></script>
    <script src="bower_components/cloudinary_ng/js/angular.cloudinary.js"></script>
    <!-- angular file upload -->
    <script src="bower_components/ng-file-upload/ng-file-upload.min.js"></script>
    <script src="bower_components/ng-file-upload/ng-file-upload-shim.min.js"></script>

    <!-- Controllers -->
    <script type="text/javascript" src="js/controllers/mainController.js"></script>
    <script type="text/javascript" src="js/controllers/KorisnikController.js"></script>
    <script type="text/javascript" src="js/controllers/TrenutniKorisnikController.js"></script>
    <script type="text/javascript" src="js/controllers/KorisnikOglasiController.js"></script>
    <script type="text/javascript" src="js/controllers/TrenKorisnikOglasiController.js"></script>
    <script type="text/javascript" src="js/controllers/KorisnikFavoritiController.js"></script>
    <script type="text/javascript" src="js/controllers/inboxController.js"></script>
    <script type="text/javascript" src="js/controllers/noviOglasController.js"></script>
    <script type="text/javascript" src="js/controllers/loginController.js"></script>
    <script type="text/javascript" src="js/controllers/TrenKorisnikFavoritiController.js"></script>
    <script type="text/javascript" src="js/controllers/pretragaController.js"></script>

    <!-- Services -->
    <script type="text/javascript" src="js/services/KorisnikService.js"></script>
    <script type="text/javascript" src="js/services/ProfilService.js"></script>
    <script type="text/javascript" src="js/services/KorisnikOglasiService.js"></script>
    <script type="text/javascript" src="js/services/OglasiTrenutnogService.js"></script>
    <script type="text/javascript" src="js/services/LoginService.js"></script>
    <script type="text/javascript" src="js/services/KorisnikFavoritiService.js"></script>
    <script type="text/javascript" src="js/services/FavoritiTrenutnogService.js"></script>

    <script type="text/javascript" src="js/services/PorukaService.js"></script>


    <script src="js/prikazioglasController.js"></script>
    <link rel="stylesheet" type="text/css" href="css/oglas.css" />
</head>
<body ng-controller="mainController as mainCtrl" class="glavna">
<header>
    <nav class="navbar navbar-default ">
        <div class="container-fluid menuboja">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand " href="#" >EasyPick</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right" ng-controller="LoginController as loginCtrl">

                    <li class="slova" ><button class="btn btn-primary btn-xs " ng-click="changeLanguage('cro')" >BHS</button></li>
                    <li><button class="btn btn-primary btn-xs" ng-click="changeLanguage('en')">EN</button></li>
                    <li ng-show="mainCtrl.userLoggedIn()"><a  href="#oglass">Naslovnica</a></li>
                    <li ng-show="mainCtrl.userLoggedIn()"><a  href="#oglas" translate>OBJAVA</a></li>
                    <li><a  href="#pretraga" translate>PRETRAGA</a></li>
                    <li ng-hide="mainCtrl.userLoggedIn()"><a   href="#login" translate>PRIJAVA</a></li>
                    <li ng-show="mainCtrl.userLoggedIn()"><a  href="#profil" translate>PROFIL</a></li>
                    <li ng-show="mainCtrl.userLoggedIn()"><a  href="#poruke">Moje poruke</a></li>
                    <li ng-show=" mainCtrl.userLoggedIn() && loginCtrl.isAdmin"><a href="" ng-click="mainCtrl.redirectToPanel()">Admin ploca</a></li>
                    <li ng-show="mainCtrl.userLoggedIn()"><a id="odj" href="#" ng-click="mainCtrl.logout()">Odjavi se</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

</header>

<!-- MAIN CONTENT AND INJECTED VIEWS -->
<div id="main">

    <div class="container">
        <!-- angular templating -->
        <!-- this is where content will be injected -->
        <div ng-view></div>
    </div>

</div>

</body>
</html>
