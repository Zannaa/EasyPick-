var app = angular.module('easypick');

app.controller('inboxController', [ '$http', '$window', '$scope', '$log', 'PorukaService', '$location', function($http, $window, $scope, $log, PorukaService, $location){

	$scope.poruke = [];
	$scope.messages = [];
	$scope.showMessageBox = false;
  $scope.poruka={};


	var id = $window.localStorage.getItem('user_id');

	$http.get('http://localhost:8000/poruke/korisnik/' + id).success(function(data){
        
      $scope.poruke = data; 
      $log.debug(angular.toJson($scope.poruke, true));
            
      })
      .error(function () {
            

       });
  	
  	$scope.dajPoruke = function(sen,rec) {

  	  $scope.showMessageBox = true;	
  	  $http.get('http://localhost:8000/poruke/' + sen + '/' + rec).success(function(data){
        
      $scope.messages = data; 

      if($scope.friend(sen))
  	  $scope.poruka.rcv = sen;
  	  else
  	  $scope.poruka.rcv = rec;

      $log.debug(angular.toJson($scope.messages, true));
            
      })
      .error(function () {
            

       });
  	};

  	$scope.friend = function(korisnik_id){

  		var loggedUser = $window.localStorage.getItem('user_id');
  		return loggedUser!=korisnik_id;
  	};

      
	  $scope.posalji = function(korisnik) {
	    
	    PorukaService.async($scope.poruka.tekst, $scope.poruka.rcv).then(function(data) {});
	  $scope.dajPoruke($window.localStorage.getItem('user_id'),$scope.poruka.rcv);
	  $scope.poruka.tekst = "";
	  };

 }]);
