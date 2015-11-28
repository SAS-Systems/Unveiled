/**
 * Created by D062427 on 28.11.2015.
 */
var app = angular.module('toastApp', ['ngAnimate',
    'ngSanitize','ngToast']);

app.controller('toastCtrl', function(ngToast) {
    ngToast.create('a toast message...');


});

$scope.showSample = function() {
    ngToast.create('a toast message...');}