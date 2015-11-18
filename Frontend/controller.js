/**
 * Created by D062427 on 11.11.2015.
 */

/** Angular controller **/
(function() {
    var myApp = angular.module('myApp', []);

    myApp.controller('CoverflowController', ['$scope', '$log','$http', function($scope, $log, $http) {
        $log.log("hallo");
        var controller = this;
        var videos = [];

        $http.get('videoproperties.json').success(function(data){
            controller.videos = data;
            $log.log("loaded videoproperties.json");
        });
        $log.log("was");
    }]);
})();


