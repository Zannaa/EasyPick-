var app = angular.module('easypick');

app.controller('TrenKorisnikFavoritiController', function(FavoritiTrenutnogService, $routeParams) {
  // Call the async method and then do stuff with what is returned inside our own then function
  var easypick=this;
  easypick.oglasi=[];
  FavoritiTrenutnogService.async().then(function(data) {
    easypick.oglasi=data;
    
          
  });
  
}); 
 