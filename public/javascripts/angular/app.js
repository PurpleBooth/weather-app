'use strict';

var weatherApp = angular.module('weatherApp', [
    'ngResource'
]);

weatherApp.factory('Weather', ['$resource',
    function ($resource) {
        return $resource('api/v1/:location', {'location': '@id'});
    }]);

weatherApp.controller('IndexController', ['$scope', 'Weather', function ($scope, Weather) {
    $scope.weatherText = "Unknown";

    $scope.updateWeather = function (location) {
        Weather.get({'location':location}, function(weather) {
            $scope.weatherText = weather.description;
        }, function(errorResult) {
            if(errorResult.status === 404) {
                $scope.weatherText = "Unknown";
            }
        });
    }
}]);
