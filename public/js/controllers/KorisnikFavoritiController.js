var app = angular.module('easypick');

app.controller('KorisnikFavoritiController', function( KorisnikFavoritiService, $routeParams) {
  // Call the async method and then do stuff with what is returned inside our own then function
  var easypick=this;
  easypick.oglasi=[];
  KorisnikFavoritiService.async($routeParams.id).then(function(data) {
    easypick.oglasi=data;
    
          
  });
  
}); 
 