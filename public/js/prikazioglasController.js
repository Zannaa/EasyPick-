angular.module('oglas').controller('prikazioglasController', ['$http','$scope', '$window' , '$log', function( $http, $scope, $window, $log){


var controller=this;
controller.oglasi=[] ;
 

$http({method:'GET', url:'http://localhost:8000/oglasi'}).success(function(data){
	controller.oglasi=data;  
  $scope.totalItems = controller.oglasi.length;
  $scope.currentPage = 1;
  $scope.itemsPerPage=8;


  $scope.setPage = function (pageNo) {
    $scope.currentPage = pageNo;
  };

  $scope.pageChanged = function() {
    $log.log('Page changed to: ' + $scope.currentPage);
  };

  $scope.maxSize = 5;
  $scope.bigTotalItems = 175;
  $scope.bigCurrentPage = 1;
	
	console.log(data);

  $scope.$watch("currentPage + numPerPage", function() {
    var begin = (($scope.currentPage - 1) * $scope.numPerPage)
    , end = begin + $scope.numPerPage;

    
  });
}); 





}   ]);


angular.module("oglas").controller('detaljnooglasController',  ['$http', '$scope','$routeParams','$window', '$timeout' ,function ($http, $scope, $routeParams, $window, $timeout) {
   
var controller=this;




$http({method:'GET', url:'http://localhost:8000/oglasi/'+$routeParams.id}).success(function(data){
	controller.oglas=data;
    $scope.oglasi=data.naziv;
	console.log(data);
    console.log($scope.oglasi);

    var newWidth = 600 + slides.length + 1;
    slides.push({
      image: controller.oglas.slika1,
      text: ['Nice image','Awesome photograph','That is so cool','I love that'][slides.length % 4],
      id: currIndex++
    });
     slides.push({
      image: controller.oglas.slika2,
      text: ['Nice image','Awesome photograph','That is so cool','I love that'][slides.length % 4],
      id: currIndex++
    });
      slides.push({
      image: controller.oglas.slika3,
      text: ['Nice image','Awesome photograph','That is so cool','I love that'][slides.length % 4],
      id: currIndex++
    });
       slides.push({
      image: controller.oglas.slika4,
      text: ['Nice image','Awesome photograph','That is so cool','I love that'][slides.length % 4],
      id: currIndex++
    });

       $http({method:'GET', url:'http://localhost:8000/korisnici/'+controller.oglas.autor_id}).success(function(data2){
       controller.autor=data2;
       console.log(data);
       console.log(controller.autor);

       });
        
        $http({method:'GET', url:'http://localhost:8000/oglasi/'+controller.oglas.id+'/lokacija'}).success(function(data2){
       controller.lokacija=data2;
       console.log(data);
       console.log(controller.autor);

       });

}); 



 $scope.myInterval = 5000;
  $scope.noWrapSlides = false;
  $scope.active = 0;
  var slides = $scope.slides = [];
  var currIndex = 0;

  $scope.addSlide = function() {
    var newWidth = 600 + slides.length + 1;
    slides.push({
      image: 'http://lorempixel.com/' + newWidth + '/300',
      text: ['Nice image','Awesome photograph','That is so cool','I love that'][slides.length % 4],
      id: currIndex++
    });
  };

  

  $scope.randomize = function() {
    var indexes = generateIndexesArray();
    assignNewIndexesToSlides(indexes);
  };

  /*for (var i = 0; i < 4; i++) {
    $scope.addSlide();
  } */
   // $scope.addSlide2();

  // Randomize logic below

  function assignNewIndexesToSlides(indexes) {
    for (var i = 0, l = slides.length; i < l; i++) {
      slides[i].id = indexes.pop();
    }
  }

  function generateIndexesArray() {
    var indexes = [];
    for (var i = 0; i < currIndex; ++i) {
      indexes[i] = i;
    }
    return shuffle(indexes);
  }

  // http://stackoverflow.com/questions/962802#962890
  function shuffle(array) {
    var tmp, current, top = array.length;

    if (top) {
      while (--top) {
        current = Math.floor(Math.random() * (top + 1));
        tmp = array[current];
        array[current] = array[top];
        array[top] = tmp;
      }
    }

    return array;
  }
    

  
  $scope.posaljiporuku=function(id)
 {   console.log("poruka");
      var urlBase = 'http://localhost:8000/poruke';
        $http.post(urlBase, {tekst: this.sadrzaj, korisnik2_id: id});  
        this.sadrzaj = {};
 }



 


}]) 


