var app = angular.module('easypick');

//kontroler za pretragu oglasa
app.controller('pretragaController', ['$scope', '$location', function($scope, $location){

$scope.min_povrsina = 0;
$scope.max_povrsina = 100;
$scope.min_cijena = 0;
$scope.max_cijena = 1000;

//filteri za pretragu oglasa
$scope.minCijena = function(oglas){
  return oglas.cijena >= $scope.min_cijena;
};

$scope.maxCijena = function(oglas){
  return oglas.cijena <= $scope.max_cijena;
};

$scope.minPovrsina = function(oglas){
  return oglas.povrsina >= $scope.min_povrsina;
};

$scope.maxPovrsina = function(oglas){
  return oglas.povrsina <= $scope.max_povrsina;
};

}]);

