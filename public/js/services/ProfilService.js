var app = angular.module('easypick');

app.factory('ProfilService', ['$http', '$window', function($http, $window) {
  var ProfilService = {
    async: function() {
      
      var urlBase = 'http://localhost:8000/korisnik?token=';
      // $http returns a promise, which has a then function, which also returns a promise
      var promise = $http.get(urlBase + $window.localStorage.token).then(function (response) {
        // The then function here is an opportunity to modify the response
        console.log(response);
        // The return value gets picked up by the then in the controller.
        return response.data;
      });
      // Return the promise to the controller
      return promise;
    }
  };
  return ProfilService;
}]);