
var app = angular.module('easypick');

app.controller('KorisnikController', function( KorisnikService, $scope, $routeParams) {
  // Call the async method and then do stuff with what is returned inside our own then function
  var easypick=this;
  easypick.korisnik={};
  KorisnikService.async($routeParams.id).then(function(data) {
    easypick.korisnik=data;
    
    if(easypick.korisnik.verifikovan)
        $scope.verifikacija={"color":"green"};
    if(easypick.korisnik.admin)
        $scope.admin={"color":"#FFCC00"};
    if(easypick.korisnik.ban)
        $scope.ban={"color":"red"};
    
    if(easypick.korisnik.telefon!=null)
        $scope.telefon=easypick.korisnik.telefon;
    
    
    if(easypick.korisnik.grad!=null && easypick.korisnik.drzava!=null)
        $scope.lokacija=easypick.korisnik.drzava +', '+easypick.korisnik.grad;    
    else if(easypick.korisnik.grad!=null)
        $scope.lokacija=easypick.korisnik.grad;
    else if(easypick.korisnik.drzava!=null)
        $scope.lokacija=easypick.korisnik.drzava;
    
  
           
  });
  
}); 
 