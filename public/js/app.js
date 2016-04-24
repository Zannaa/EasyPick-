(function(){
  var app = angular.module('easypick', ['vcRecaptcha']);

   app.controller('NavigationController', function(){

   		this.form = 0;

   		this.isSelected = function(form){
   			return this.form === form;
   		};

   		this.selectForm = function(form){
   			this.form = form;
   		};
   		
   });

   app.controller('LoginController', [ 'vcRecaptchaService', '$http', '$window', '$log', function(vcRecaptchaService, $http, $window, $log) {
    //brisanje tokena na refresh zbog testa
    $window.localStorage.removeItem('token');
    this.user = {};
    this.user.tip = 'korisnik1';

    this.publicKey = "6LfQyB0TAAAAAFrPuH1kkbtrup-M2fKDM4CZrXFU";

    this.login = function() {


    	var data = { email: this.user.email, password: this.user.password};

    	$http.post('http://localhost:8000/prijava', data).success(function(data){
    		$window.localStorage.setItem('token', data.token);
            $log.debug(angular.toJson(data, true));
            
    	})
    	.error(function () {
            $window.localStorage.removeItem('token');
            $log.debug(angular.toJson(data, true));

        });
    };

    this.register = function(){
    	
    	var response = vcRecaptchaService.getResponse();

    	if(vcRecaptchaService.getResponse() === ""){
    		//if string is empty
            
        }

       	else{

            var data = {  
                'name':this.user.name,
                'email':this.user.email,
                'password':this.user.password,
                'drzava': this.user.grad,
                'grad': this.user.grad,
                'telefon': this.user.telefon,
                'g-recaptcha-response':vcRecaptchaService.getResponse()  //send g-captcah-reponse to our server
        	}
        }

    	$http.post('http://localhost:8000/korisnici', data).success(function(data){
    		
    		if(response.error === 0){

                alert("Successfully verified and signed up the user");
                $window.localStorage.setItem('token', data.token);
            	$log.debug(angular.toJson(data, true));
            }
            else{

                alert("User verification failed");
            } 		
            
    	})
    	.error(function () {
            $window.localStorage.removeItem('token');
            $log.debug(angular.toJson(data, true));

        });
    };

    this.reset = function(form){
    	if(form.$valid){

    	}
    };

    this.typeOfUser = function() {
    	
    	if(this.user.tip == 'korisnik1')
    		return false;
    	else return true;
    };

    this.isAuthed = function(){

    	var token = $window.localStorage.getItem('token');
    	$log.debug(angular.toJson(token, true));
    	return token ? true : false;
    };

  }]);

  app.directive('loginForm', function() {
    return {
      restrict: 'E',
      templateUrl: 'login-form.html'
   };

  });

    app.directive('passResetForm', function() {
    return {
      restrict: 'E',
      templateUrl: 'pass-reset-form.html'
   };
   
  });

  app.directive('registerForm', function() {
    return {
      restrict: 'E',
      templateUrl: 'register-form.html'
   };
   
  });

})();
