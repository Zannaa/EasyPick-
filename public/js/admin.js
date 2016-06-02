
(function() {

var admin = angular.module('admin', ['ngRoute', 'ui.bootstrap', 'chart.js']);

admin.config(function($routeProvider, $httpProvider) {
        $routeProvider

            .when('/korisnici', {
                templateUrl : 'admin_korisnici.html',
                controller  : 'AKorisniciController'
            }).when('/oglasi', {
                templateUrl : 'admin_oglasi.html',
                controller  : 'AOglasiController'
            }).when('/korisnik/:id', {
                controller:'AKorisnikController',
                templateUrl:'admin_korisnik.html'
            }).when('/uredikorisnika/:id', {
                  templateUrl : 'admin_uredi.html',
                  controller  : 'AUrediController'


            }).when('/chartovi',
                {
                	templateUrl: 'chartovi.html',
                	controller:'PrikaziChartController'
                }
            ).when('/registracije',
              {
              	   templateUrl: 'registracije.html',
                	controller:'PrikaziRegistracijeController'

              }
              ).when('/verifikovani',
              {
              	   templateUrl: 'views/statistikaVerifikovanih.html',
                	controller:'StatistikaVerifikovanihController'

              }
              ).when('/reg',
              {
              	   templateUrl: 'views/statistikaRegistracije.html',
                	controller:'RegPoMjesecuController'

              }
            ).when('/oglasiChart',
              {
                   templateUrl: 'oglasi-chart.html',
                   controller:'PrikaziOglasChartController'

              }
            ).when('/prijaveChart',
              {
                   templateUrl: 'prijave-chart.html',
                   controller:'PrikaziPrijaveChartController'

              }
            );

          // Registruj interceptor.    
          $httpProvider.interceptors.push('AuthInterceptorAdmin');

        }).config(['ChartJsProvider', function (ChartJsProvider) {
    // Configure all charts 
    ChartJsProvider.setOptions({
      chartColors: ['#FF5252', '#FF8A80'],
      responsive: false
    });
    // Configure all line charts 
    ChartJsProvider.setOptions('line', {
      datasetFill: false
    }); }]);

   //Interceptor koji svakom requestu u header dodaje token
    admin.factory('AuthInterceptorAdmin', function ($window, $q) {
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
            

admin.controller('AKorisniciController', ['$http','$scope', '$window' , '$log', function( $http, $scope, $window, $log){
    
      
  $scope.korisnici = {};

  $http.get('http://localhost:8000/korisnici').success(function(data){
        
      $scope.korisnici = data; 
       $scope.totalItems = $scope.korisnici.length;
  $scope.currentPage = 1;
  $scope.itemsPerPage=10;


  $scope.setPage = function (pageNo) {
    $scope.currentPage = pageNo;
  };

  $scope.pageChanged = function() {
    $log.log('Page changed to: ' + $scope.currentPage);
  };

  $scope.maxSize = 5;
  $scope.bigTotalItems = 175;
  $scope.bigCurrentPage = 1;
	
	

  $scope.$watch("currentPage + numPerPage", function() {
    var begin = (($scope.currentPage - 1) * $scope.numPerPage)
    , end = begin + $scope.numPerPage;

    
  });
    
      $log.debug(angular.toJson($scope.korisnici, true));
            
      })
      .error(function () {
            

       });

      $scope.izbrisikorisnika=function(id) {
$http.delete('http://localhost:8000/korisnici/'+id).success(function(){
	console.log("izbirsano");
	 }).error(function(response){  console.log(id);}) ;

};
    


     $scope.banujkorisnika=function(id) {
$http.post('http://localhost:8000/korisnici/ban/'+id).success(function(){
	console.log("izbirsano");
	 }).error(function(response){  console.log(id);}) ;

};


$scope.odbanujkorisnika=function(id) {
$http.delete('http://localhost:8000/korisnici/ban/'+id).success(function(){
	console.log("izbirsano");
	 }).error(function(response){  console.log(id);}) ;



};


  }]);


admin.controller('AOglasiController', ['$http','$scope', '$window' , '$log', function( $http, $scope, $window, $log){
    
      
  $scope.oglasi= {};

  $http.get('http://localhost:8000/oglasi').success(function(data){
        
      $scope.oglasi = data; 
       $scope.totalItems = $scope.oglasi.length;
  $scope.currentPage = 1;
  $scope.itemsPerPage=10;


  $scope.setPage = function (pageNo) {
    $scope.currentPage = pageNo;
  };

  $scope.pageChanged = function() {
    $log.log('Page changed to: ' + $scope.currentPage);
  };

  $scope.maxSize = 5;
  $scope.bigTotalItems = 175;
  $scope.bigCurrentPage = 1;
	
	

  $scope.$watch("currentPage + numPerPage", function() {
    var begin = (($scope.currentPage - 1) * $scope.numPerPage)
    , end = begin + $scope.numPerPage;

    
  });
    
      $log.debug(angular.toJson($scope.oglasi, true));
            
      })
      .error(function () {
            

       });
    
    
$scope.izbrisioglas=function(id) {
$http.delete('http://localhost:8000/oglasi/'+id).success(function(){
	console.log("izbirsano");
	 }).error(function(response){  console.log(id);}) ;

};
  }]);



 



 admin.controller('AKorisniciController', ['$http','$scope', '$window' , '$log', function( $http, $scope, $window, $log){
    
      
  $scope.korisnik = {};

  $http.get('http://localhost:8000/korisnici').success(function(data){
        
      $scope.korisnici = data; 
       $scope.totalItems = $scope.korisnici.length;
  $scope.currentPage = 1;
  $scope.itemsPerPage=10;


  $scope.setPage = function (pageNo) {
    $scope.currentPage = pageNo;
  };

  $scope.pageChanged = function() {
    $log.log('Page changed to: ' + $scope.currentPage);
  };

  $scope.maxSize = 5;
  $scope.bigTotalItems = 175;
  $scope.bigCurrentPage = 1;
	
	

  $scope.$watch("currentPage + numPerPage", function() {
    var begin = (($scope.currentPage - 1) * $scope.numPerPage)
    , end = begin + $scope.numPerPage;

    
  });
    
      $log.debug(angular.toJson($scope.korisnici, true));
            
      })
      .error(function () {
            

       });

      $scope.izbrisikorisnika=function(id) {
$http.delete('http://localhost:8000/korisnici/'+id).success(function(){
	console.log("izbirsano");
	 }).error(function(response){  console.log(id);}) ;

};
    


     $scope.banujkorisnika=function(id) {
$http.post('http://localhost:8000/korisnici/ban/'+id).success(function(){
	console.log("izbirsano");
	 }).error(function(response){  console.log(id);}) ;

};


$scope.odbanujkorisnika=function(id) {
$http.delete('http://localhost:8000/korisnici/ban/'+id).success(function(){
	console.log("izbirsano");
	 }).error(function(response){  console.log(id);}) ;



};

    
  }]);


 admin.controller('AKorisnikController', ['$http','$scope', '$routeParams', function( $http, $scope,  $routeParams){
    
      
  $scope.korisnik = {};

  
$http.get('http://localhost:8000/korisnici/'+$routeParams.id).success(function(data){
	   $scope.korisnik = data; 
	console.log("prikazano");
	 }).error(function(response){  console.log(id);}) ;




}]);
  
   admin.controller('AUrediController', ['$scope', '$http','$routeParams', function($scope, $http, $routeParams){
    
       
      $scope.user=this;
 
$http.get('http://localhost:8000/korisnici/'+$routeParams.id).success(function(data){
	  
	   $scope.user=data;
	         
      if ($scope.user.dodatno_korisnik==null)
      $scope.tip=0;
    
	            
	console.log("prikazano");
	 }).error(function(response){  console.log(id);}) ;

$scope.register=function(){
	var data = {  
		         
                'name':$scope.user.name,
                'email':$scope.user.email,
                'password':$scope.user.password,
                'drzava': $scope.user.drzava,
                'grad': $scope.user.grad,
                'telefon': $scope.user.telefon
                
          }


          var urlBase = 'http://localhost:8000/korisnici/'+$scope.user.id;
        $http.put(urlBase, data).success(function(response) {

        	console.log("Response" + response);
        });  



};
$scope.dodajadmina=function(id) {
	console.log(id);
$http.post('http://localhost:8000/korisnici/admini/'+id).success(function(){
	console.log("dodano");
	 }).error(function(response){  console.log(id);}) ;

};
    
$scope.oduzmiadmina=function(id) {
$http.delete('http://localhost:8000/korisnici/admini/'+id).success(function(){
	console.log("izbrisan admin");
	 }).error(function(response){  console.log(id);}) ;

};

 
}
  


]);


  admin.controller('PrikaziChartController', ['$scope', '$http','$timeout', function( $scope, $http, $timeout){

  	var d = new Date();
   var n = d.getDay();
   
   $scope.oglasi=this;



   $http({method:'GET', url:'http://localhost:8000/oglasi'}).success(function(data){

     $scope.oglasi=data;
      $scope.dani = [];
      $scope.dani.splice(0, 0, 0);
      $scope.dani.splice(1, 0, 0);
      $scope.dani.splice(2, 0, 0);
      $scope.dani.splice(3, 0, 0);
      $scope.dani.splice(4, 0, 0);
      $scope.dani.splice(5, 0, 0);
      $scope.dani.splice(6, 0, 0);
      

     


      
      angular.forEach($scope.oglasi, function(value,key) {
      	var d =new Date(value.datum_objave);
      	var n=d.getDay();

      	if(n==0)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[0]+1;
      		$scope.dani.splice(0, 1, dodaj );
      		 
      	} 
        else	if(n==1)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[1]+1;
      		$scope.dani.splice(1, 1, dodaj );
      		 
      	} 
      		else if(n==2)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[2]+1;
      		$scope.dani.splice(2, 1, dodaj );
      		 
      	} 
        
        

      	else if(n==3)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[3]+1;
      		$scope.dani.splice(3, 1, dodaj );
      		 console.log($scope.dani.length);
      		 
      	} 
      		else if(n==4)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[4]+1;
      		$scope.dani.splice(4, 1, dodaj );
      		console.log($scope.dani.length);
      		 
      	} 
      		else if(n==5)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[5]+1;
      		$scope.dani.splice(5, 1, dodaj );
      		 
      	} 
      		else if(n==6)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[6]+1;
      		$scope.dani.splice(6, 1, dodaj );
      		 
      	} 
      	 });

           $scope.labels = ["Ponedjeljak", "Utorak", "Srijeda", "Četvrtak", "Petak", "Subota", "Nedjelja"];
        
          $scope.series = ['Series A'];
          console.log("Postovi"+$scope.dani.join());
           
         $scope.data=[
    [$scope.dani[1], 
     $scope.dani[2], 
     $scope.dani[3], 
     $scope.dani[4],
     $scope.dani[5], 
     $scope.dani[6],
     $scope.dani[0]]
  ]; 
      	  
   
     

     });
       


    
   



}]);   

  admin.controller('PrikaziRegistracijeController', ['$scope', '$http','$timeout', function( $scope, $http, $timeout){

  	var d = new Date();
   var n = d.getDay();
   
   $scope.registracije=this;



   $http({method:'GET', url:'http://localhost:8000/korisnici'}).success(function(data){

     $scope.registracije=data;
      $scope.dani = [];
      $scope.dani.splice(0, 0, 0);
      $scope.dani.splice(1, 0, 0);
      $scope.dani.splice(2, 0, 0);
      $scope.dani.splice(3, 0, 0);
      $scope.dani.splice(4, 0, 0);
      $scope.dani.splice(5, 0, 0);
      $scope.dani.splice(6, 0, 0);
      

     


      
      angular.forEach($scope.registracije, function(value,key) {
      	var d =new Date(value.created_at);
      	var n=d.getDay();

      	if(n==0)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[0]+1;
      		$scope.dani.splice(0, 1, dodaj );
      		 
      	} 
        else	if(n==1)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[1]+1;
      		$scope.dani.splice(1, 1, dodaj );
      		 
      	} 
      		else if(n==2)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[2]+1;
      		$scope.dani.splice(2, 1, dodaj );
      		 
      	} 
        
        

      	else if(n==3)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[3]+1;
      		$scope.dani.splice(3, 1, dodaj );
      		 console.log($scope.dani.length);
      		 
      	} 
      		else if(n==4)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[4]+1;
      		$scope.dani.splice(4, 1, dodaj );
      		console.log($scope.dani.length);
      		 
      	} 
      		else if(n==5)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[5]+1;
      		$scope.dani.splice(5, 1, dodaj );
      		 
      	} 
      		else if(n==6)  {
             console.log("n="+ n);
            var dodaj=$scope.dani[6]+1;
      		$scope.dani.splice(6, 1, dodaj );
      		 
      	} 
      	 });

           $scope.labels = ["Ponedjeljak", "Utorak", "Srijeda", "Četvrtak", "Petak", "Subota", "Nedjelja"];
        
          $scope.series = ['Series A'];
          console.log("Postovi"+$scope.dani.join());
           
         $scope.data=[
    [$scope.dani[1], 
     $scope.dani[2], 
     $scope.dani[3], 
     $scope.dani[4],
     $scope.dani[5], 
     $scope.dani[6],
     $scope.dani[0]]
  ]; 
      	  
   
     

     });
  }]);

  
  admin.controller('PrikaziOglasChartController', ['$scope', '$http', '$timeout', function( $scope, $http, $timeout){
   
    $scope.oglasi= {};
    $scope.labels = [];
    $scope.series = ['Series C'];
    var mjeseci = [12];
    for(i=0; i < 12; i++){
      mjeseci[i] = 0;
    }

    $http.get('http://localhost:8000/oglasi').success(function(data){

      $scope.oglasi=data;
        
      angular.forEach($scope.oglasi, function(value,key) {

        var date = new Date(value.datum_objave);
        var month = date.getMonth();
        mjeseci[month]++;
  
      });

      $scope.labels = ["Januar", "Februar", "Mart", "April", "Maj", "Juni", "Juli", "August", "Septembar", "Oktobar", "Novembar", "Decembar"];
         
    })

    .error(function () {
      console.log("Http get oglasi greska");
    });

    $scope.data=[mjeseci];
        
  }]);

  admin.controller('PrikaziPrijaveChartController', ['$scope', '$http', '$timeout', function( $scope, $http, $timeout){
   
    $scope.prijave= {};
    $scope.labels = [];
    $scope.series = ['Series C'];
    var mjeseci = [12];
    for(i=0; i < 12; i++){
      mjeseci[i] = 0;
    }

    $http.get('http://localhost:8000/prijava/info').success(function(data){

      $scope.prijave=data;
        
      angular.forEach($scope.prijave, function(value,key) {

        var date = new Date(value.login_time);
        var month = date.getMonth();
        mjeseci[month]++;
  
      });

      $scope.labels = ["Januar", "Februar", "Mart", "April", "Maj", "Juni", "Juli", "August", "Septembar", "Oktobar", "Novembar", "Decembar"];
         
    })

    .error(function () {
      console.log("Prijave Chart greska");
    });

    $scope.data=[mjeseci];
        
  }]);
 
 
 
 
 admin.controller('StatistikaVerifikovanihController', ['$scope', '$http','$timeout', function( $scope, $http, $timeout){

   
   $scope.verifikovani=this;



   $http({method:'GET', url:'http://localhost:8000/korisnici'}).success(function(data){

     $scope.verifikovani=data;
      var i=1;
      var k=1;
      var j=$scope.verifikovani.length;  
      angular.forEach($scope.verifikovani, function(file) {
      	 if(file.verifikovan) i++;
         if(file.ban) k++;          
      	 });
         i--;
         k--;

           $scope.labels = ["Verifikovani korisnici", "Banovani korisnici", "Ukupno korisnika"];
        
       
         $scope.data=
          [i, k, j]
         ;   
     

     });


}]); 




admin.controller('RegPoMjesecuController', ['$scope', '$http', '$timeout', function( $scope, $http, $timeout){
   
    $scope.users= {};
    $scope.labels = [];
    
    var mjeseci = [12];
    for(i=0; i < 12; i++){
      mjeseci[i] = 0;
    }

    $http.get('http://localhost:8000/korisnici').success(function(data){

      $scope.users=data;
        
      angular.forEach($scope.users, function(mjesec) {

        var date = new Date(mjesec.created_at);
        var month = date.getMonth();
        mjeseci[month]++;
  
      });

      $scope.labels = ["Januar", "Februar", "Mart", "April", "Maj", "Juni", "Juli", "August", "Septembar", "Oktobar", "Novembar", "Decembar"];
         
    })

    .error(function () {
      console.log("Http get korisnici greska");
    });

    $scope.data=[mjeseci];
        
  }]);

})();