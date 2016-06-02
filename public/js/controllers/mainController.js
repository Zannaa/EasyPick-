var app = angular.module('easypick');

app.controller('mainController', [ '$window', '$scope', '$translate', '$http', '$log', function($window, $scope, $translate, $http, $log){

    this.userLoggedIn = function(){
    var token = $window.localStorage.getItem('token');
    return token ? true : false;
    };

    $scope.changeLanguage = function (langKey) {
    $translate.use(langKey);
    };

    this.redirectToPanel = function() {
      $window.location.href = 'admin.html';
    };

    this.logout = function(){
      $window.localStorage.removeItem('token');
      $window.localStorage.removeItem('user_id');
    };

   }]);