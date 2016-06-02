var app = angular.module('easypick');

app.controller('KorisnikOglasiController', function( KorisnikOglasiService, $routeParams) {
  // Call the async method and then do stuff with what is returned inside our own then function
  var easypick=this;
  easypick.oglasi=[];
  KorisnikOglasiService.async($routeParams.id).then(function(data) {
    easypick.oglasi=data;
    
          
  });
  
}); 
 