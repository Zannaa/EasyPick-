var app = angular.module('easypick');

   app.controller('LoginController', [ 'vcRecaptchaService', '$http', '$window', '$log', '$location','$scope', 'Upload',  function(vcRecaptchaService, $http, $window, $log, $location, $scope, $upload) {
    
    this.user = {};
    this.user.tip = 'korisnik1';
    this.isAdmin = {};

    this.publicKey = "6LfQyB0TAAAAAFrPuH1kkbtrup-M2fKDM4CZrXFU";

    this.login = function() {

      var data = { email: this.user.email, password: this.user.password};
      var id = {};
      this.isAdmin = false;

      $http.post('http://localhost:8000/prijava', data).success(function(data){
        $window.localStorage.setItem('token', data.token);
        $window.localStorage.setItem('user_id', data.id);
        var id = $window.localStorage.getItem('user_id');
        $http.get('http://localhost:8000/korisnici/' + id).success(function(data){
          if(data.admin == 1)
            this.isAdmin = true;
          })
          .error(function () {
              $log.debug(angular.toJson(data, true));
          });
        $log.debug(angular.toJson(data, true));
        $location.path('/');
            
      })
      .error(function () {
            $window.localStorage.removeItem('token');
            $window.localStorage.removeItem('user_id');
            $log.debug(angular.toJson(data, true));

        });
    
    };

    this.register = function(){
      
      if(vcRecaptchaService.getResponse() === ""){
        //if string is empty
        }

        else{

            console.log("usao u else");
            var data = {  
                'name':this.user.name,
                'email':this.user.email,
                'password':this.user.password,
                'drzava': this.user.grad,
                'grad': this.user.grad,
                'telefon': this.user.telefon,
                'g-recaptcha-response':vcRecaptchaService.getResponse(), //send g-captcah-reponse to our server
                'slika1': $window.localStorage.getItem('imageId') 
            } 
        }
  
      $http.post('http://localhost:8000/korisnici', data).success(function(data){
        
      alert("Successfully verified and signed up the user");
      $window.localStorage.setItem('token', data.token);
      $window.localStorage.setItem('user_id', data.id);
      $window.localStorage.removeItem('imageId');
      $log.debug(angular.toJson(data, true));
            
      })
      .error(function () {
            $window.localStorage.removeItem('token');
            $log.debug(angular.toJson(data, true));

        });
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

     $scope.upload=function(file){
      $window.localStorage.setItem('imageId', "");
        $scope.upload = $upload.upload({
        
        url: "https://api.cloudinary.com/v1_1/dntilajra/upload",
            data: {
              upload_preset: 'x1rpxcm3',
              tags: 'myphotoalbum',
              context: 'photo=123',
              file: file
            },
      }).progress(function(evt) {
        console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
        file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
      }).success(function(data, status, headers, config) {
        // file is uploaded successfully
        $window.localStorage.setItem('imageId', data.public_id);
        
        console.log(data);
      });
    };

  }]);