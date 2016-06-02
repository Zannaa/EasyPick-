/*(function() {

var oglas = angular.module('oglas', ['ngAnimate']);

oglas.config( function($httpProvider)
{


	delete $httpProvider.defaults.headers.common['X-Requested-With'];
}


	);







 
oglas.directive('slider', function ($timeout) {
  return {
    restrict: 'AE',
    replace: true,
    scope:{
        images: '='
    },
    link: function (scope, elem, attrs) {
    
        scope.currentIndex=0;

        scope.next=function(){
            scope.currentIndex<scope.images.length-1?scope.currentIndex++:scope.currentIndex=0;
            console.log("pozvano");
        }; 
        
        scope.prev=function(){
            scope.currentIndex>0?scope.currentIndex--:scope.currentIndex=scope.images.length-1;
        };
        
        scope.$watch('currentIndex',function(){
            scope.images.forEach(function(image){
                image.visible=false;
            });
            scope.images[scope.currentIndex].visible=true;
        });
        
        /* Start: For Automatic slideshow*/
        
       /* var timer;
        
        var sliderFunc=function(){
            timer=$timeout(function(){
                scope.next();
                timer=$timeout(sliderFunc,5000);
            },5000);
        };
        
        sliderFunc();
        
        scope.$on('$destroy',function(){
            $timeout.cancel(timer);
        });
        
        /* End : For Automatic slideshow*/
        
    /*},
    templateUrl:'/easypick/templateurl.html'
  }
});
})();
(function() {

var navigacija = angular.module('navigacija', ['ngRoute', 'oglas']);



 navigacija.config(function($routeProvider) {
        $routeProvider

            // route for the home page
          

            // route for the about page
            .when('/oglas', {
                templateUrl : '/easypick/dodajoglas.html',
                controller  : 'prikazioglasController',
                controllerAs: 'prikazi'
            }).when('/oglas/:id', {
            	 templateUrl : '/easypick/oglasdetaljno.html',
                controller  : 'detaljnooglasController',
                controllerAs: 'detaljno'

            })


            ;
            

            // route for the contact page
          
    });

  navigacija.controller('mainController', ['$scope' ,  function($scope){
      $scope.message = 'Everyone come and see how good I look!';
    }]);

    navigacija.controller('oglasController', ['$scope' ,function($scope) {
        $scope.message = 'Ovdje mozete pregledati oglase.';
    }]);

   


    
  }  )();
*/




 



