//funciones jquery


$(function () {
    $('map').imageMapResize();
    $(".interactivo-botones .cls-4").on("click", showLightbox);
});

var showLightbox = function () {
    var esto = $(this);
    var id = esto.parent()[0].id;
    $("#light" + id).modal("show");
    var carouselId = "#" + id + "-carousel";
    var carousel = $(carouselId);
    var numero = this.id.replace(id + "-", "");
    carousel.carousel(parseInt(numero));
};

//funciones angular
var app = angular.module('app', ['ui.bootstrap', 'ngAnimate', 'ngTouch']);

// app.controller('Carousel1', function ($scope, $filter) {
//     $scope.active = 0;
//     $scope.slides = [
//         {
//             image: '/assets/images/img_carousel1.png',
//         },
//         {
//             image: '/assets/images/img_carousel1.png',
//         },
//         {
//             image: '/assets/images/img_carousel1.png',
//         },
//         {
//            image: '/assets/images/img_carousel1.png',
//         }
//     ];
//     $scope.setActive = function (active) {
//         $scope.active = active;
//     };
// });

app.controller('Carousel1', ['$scope', '$http', function ($scope, $http) {
    $scope.active = 0;
    // default post header
    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    // send login data
    id = $('#id_prototipo').val().trim();
    $http({
        method: 'patch',
        url: $('#base_url').val().trim() + '/galeria_regular',
        data: $.param({
            _token:$('#token').val().trim(),
            id_prototipo:id
        }),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (data, status, headers, config) {
        // handle success things
        $scope.slides = data; 
    }).error(function (data, status, headers, config) {
        // handle error things
    });
    $scope.setActive = function (active) {
        $scope.active = active;
    };
}]);

app.controller('Carousel2', ['$scope', '$http', function ($scope, $http) {
    $scope.active = 0;
    // default post header
    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    // send login data
    id = $('#id_prototipo').val().trim();
    $http({
        method: 'patch',
        url: $('#base_url').val().trim() + '/galeria_ampliado',
        data: $.param({
            _token:$('#token').val().trim(),
            id_prototipo:id
        }),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (data, status, headers, config) {
        // handle success things
        $scope.slides = data; 
    }).error(function (data, status, headers, config) {
        // handle error things
    });
    $scope.setActive = function (active) {
        $scope.active = active;
    };
}]);

app.controller('Carousel4', ['$scope', '$http', function ($scope, $http) {
    $scope.active = 0;
    // default post header
    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    // send login data
    id = $('#id_desarrollo').val().trim();
    $http({
        method: 'patch',
        url: $('#base_url').val().trim() + '/galeria_desarrollo',
        data: $.param({
            _token:$('#token').val().trim(),
            id_desarrollo:id
        }),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).success(function (data, status, headers, config) {
        // handle success things
        $scope.slides = data; 
    }).error(function (data, status, headers, config) {
        // handle error things
    });
    $scope.setActive = function (active) {
        $scope.active = active;
    };
}]);

app.controller('Carousel3', function ($scope, $filter) {
    $scope.active = 0;
    $scope.slides = [
        {
            image: '/assets/images/slider_sembrado.jpg',
        },
        {
            image: '/assets/images/slider_sembrado.jpg',
        },
        {
            image: '/assets/images/slider_sembrado.jpg',
        },
        {
           image: '/assets/images/slider_sembrado.jpg',
        }
    ];
    $scope.setActive = function (active) {
        $scope.active = active;
    };
});
// app.controller('Carousel4', function ($scope, $filter) {
//     $scope.active = 0;
//     $scope.slides = [
//         {
//             image: '/assets/images/slider_galeria.jpg',
//         },
//         {
//             image: '/assets/images/slider_galeria.jpg',
//         },
//         {
//             image: '/assets/images/slider_galeria.jpg',
//         },
//         {
//            image: '/assets/images/slider_galeria.jpg',
//         }
//     ];
//     $scope.setActive = function (active) {
//         $scope.active = active;
//     };
// });

app.config(function ($interpolateProvider) {
     $interpolateProvider.startSymbol('[[');
     $interpolateProvider.endSymbol(']]');
 });