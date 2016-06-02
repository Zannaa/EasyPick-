var app = angular.module('easypick');

app.controller('OglasController', ['$http', '$window', '$log', '$location', 'Upload', '$scope', function($http, $window, $log, $location, Upload, $scope){
    
    this.oglas = {};

    this.drzave = ['Bosna i Hercegovina', 'Hrvatska', 'Crna Gora', 'Srbija'];
    
        
    $scope.uploadFiles=function(files){
      $window.localStorage.setItem('imageId1', "");
      $window.localStorage.setItem('imageId2', "");
      $window.localStorage.setItem('imageId3', "");
      $window.localStorage.setItem('imageId4', "");
      $scope.files=files;
      if (files && files.length){
        var i=1;
        angular.forEach(files, function(file) {
          
          Upload.upload({
          
          url: "https://api.cloudinary.com/v1_1/dntilajra/upload",
              data: {
                upload_preset: 'x1rpxcm3',
                tags: 'myphotoalbum',
                context: 'photo=123',
                file: file
              },
        }).progress(function(evt) {
          console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
          $scope.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        }).success(function(data, status, headers, config) {
          // file is uploaded successfully
          $window.localStorage.setItem('imageId'+[i].toString(), data.public_id);
          i++;
          console.log(data);
        });
          
        }, this);               
        
          
        
      }
    }

    this.objaviOglas = function(){

      var data = {
      'naziv': this.oglas.naslov,
      'status_oglasa':'aktivan',
      'tip_oglasa': this.oglas.tip,
      'povrsina' : this.oglas.povrsina,
      'cijena': this.oglas.cijena,
      'stanje' : this.oglas.stanje,
      'drzava' : this.oglas.drzava,
      'grad' : this.oglas.grad,
      'adresa' : this.oglas.adresa,
      'voda': this.oglas.voda,
      'struja': this.oglas.struja,
      'internet': this.oglas.internet,
      'grijanje': this.oglas.grijanje,
      'kablovska': this.oglas.kablovska,
      'telefon': this.oglas.telefon,
      'garaza': this.oglas.garaza,
      'slika1': $window.localStorage.getItem('imageId1'),
      'slika2': $window.localStorage.getItem('imageId2'),
      'slika3': $window.localStorage.getItem('imageId3'),
      'slika4': $window.localStorage.getItem('imageId4')

    }

    $http.post('http://localhost:8000/oglasi', data).success(function(data){
        
      alert("Oglas unesen");
      $log.debug(angular.toJson(data, true));
      $window.localStorage.removeItem('imageId1');
      $window.localStorage.removeItem('imageId2');
      $window.localStorage.removeItem('imageId3');
      $window.localStorage.removeItem('imageId4');
        //vrati se na pocetnu str
        $location.path('/');
            
      })
      .error(function () {
            $log.debug(angular.toJson(data, true));
            
        });
    };
}]);