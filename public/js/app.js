
(function() {

var oglas = angular.module('oglas', ['ngAnimate', 'ui.bootstrap']);

oglas.config( function($httpProvider)
{
  delete $httpProvider.defaults.headers.common['X-Requested-With'];
});

})();

(function(){

  var app = angular.module('easypick', ['vcRecaptcha', 'ngRoute', 'ui.bootstrap', 'pascalprecht.translate', 'oglas', 'ngFileUpload', 'cloudinary']);

  

  // configure our routes
    app.config(function($routeProvider, $httpProvider, $translateProvider) {
        $routeProvider

            .when('/login', {
                templateUrl : 'login-form.html',
                controller  : 'LoginController'
            })

            .when('/register', {
                templateUrl : 'register-form.html',
                controller  : 'LoginController'
            })

            .when('/reset', {
                templateUrl : 'pass-reset-form.html',
                controller  : 'LoginController'
            })
            
            .when('/korisnik/:id', {
                controller:'KorisnikController',
                templateUrl:'views/korisnik.html'
            })
          
          .when('/profil', {
                controller:'TrenutniKorisnikController',
                templateUrl:'views/mojprofil.html'})

            .when('/oglas', {
                templateUrl : 'novi-oglas.html',
                controller  : 'OglasController'
            })

            .when('/oglass', {

                templateUrl : 'dodajoglas.html',
                controller  : 'prikazioglasController',
                controllerAs: 'prikazi'
            })

            .when('/oglas/:id', {
               templateUrl : 'oglasdetaljno.html',
                controller  : 'detaljnooglasController',
                controllerAs: 'detaljno'

            })

            .when('/poruke', {
                templateUrl : 'inbox.html',
                controller: 'inboxController'
            })

            .when('/pretraga', {
                templateUrl : 'pretraga.html',
                controller: 'pretragaController'
            });

            
        // Registruj interceptor.    
        $httpProvider.interceptors.push('AuthInterceptor');

        $translateProvider.translations('en', translationsEN);
        $translateProvider.translations('cro', translationsBHS);
        $translateProvider.preferredLanguage('cro');
        $translateProvider.fallbackLanguage('cro');

    });
    
    
    app.config(['cloudinaryProvider', function (cloudinaryProvider) {
        cloudinaryProvider
        .set("cloud_name", "dntilajra")
        .set("upload_preset", "x1rpxcm3");
    }]);
    
      

    //Interceptor koji svakom requestu u header dodaje token
    app.factory('AuthInterceptor', function ($window, $q) {
      return {
          request: function(config) {
              config.headers = config.headers || {};
              if ($window.localStorage.getItem('token')) {
                  config.headers.Authorization = 'Bearer ' + $window.localStorage.getItem('token');
              }
              return config || $q.when(config);
          },
          response: function(response) {
              if (response.status === 401) {
                  // TODO: Redirect user to login page.
              }
              return response || $q.when(response);
          }
      };
    });


  app.controller('ResetController', ['$http', function($http){
    this.user={};
    this.resetPass= function() {
      $http.post('http://localhost:8000/password/email', {email:this.user.email});  
    };
    
  }]);
  
  app.controller('porukaController', ['PorukaService','$http', '$window', '$routeParams', '$scope', function(PorukaService, $http, $window, $routeParams, $scope){
      
      this.poruka={};
      
      this.posalji= function() {
        
        PorukaService.async(this.poruka.tekst, $routeParams.id).then(function(data) {});
        //$http.post(urlBase, {tekst: this.poruka.tekst, korisnik2_id: $routeParams.id}); 
        $scope.showTheForm=false;
         
        
      };
       
    }]);


    var translationsEN = {
    OGLASI: 'Listings',
    PRIJAVA: 'Login',
    PRETRAGA: 'Search',
    PROFIL: 'My profile',
    OBJAVA: 'Post a listing'
  };
   
  var translationsBHS= {
    OGLASI: 'Oglasi',
    PRIJAVA: 'Prijava',
    PRETRAGA: 'Pretraga',
    PROFIL: 'Moj Profil',
    OBJAVA: 'Upis oglasa'
  };
  
  
  
  app.directive('messageForm', function() {
    return {
      restrict: 'E',
      templateUrl: 'message-form.html'
   };
   });

})(); 

