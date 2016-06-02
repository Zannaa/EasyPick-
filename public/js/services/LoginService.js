var app = angular.module('easypick');

app.factory('LoginService', function($http, $window) {
  var LoginService = {
    async: function(user_data) {
      
      var urlBase = 'http://localhost:8000/prijava';
      // $http returns a promise, which has a then function, which also returns a promise
      var promise = $http.post(urlBase, user_data).then(function (response) {
        // The then function here is an opportunity to modify the response
        console.log(response);
        // The return value gets picked up by the then in the controller.
        return response.data;
      });
      // Return the promise to the controller
      return promise;
    }
  };
  return LoginService;
});