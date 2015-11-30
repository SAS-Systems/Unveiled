/**
 * Created by D062427 on 11.11.2015.
 */

/** Angular controller **/
/**(function() {
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
})();**/
loadNavbar = function () {
    if (($.cookie("loginToken")) !== undefined) {
        $("#userMenu").css("visibility", "visible");
        $("#loginPage").css("visibility", "hidden");
    }
    else {
        $("#userMenu").css("visibility", "hidden");
    }
}();

$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal("toggle");
    });

    $("#signupBtn").click(function(){
        $.toaster({ priority:'success',
            title:'Success',
            message: 'message'});
    });

    $("#loginBtn").click(function(){
        var username = $("#usrname");
        var password = $("#psw");

        $.post("../api/login",
            {
                username:username,password:password
            },
            function(data,status)
            {
                console.log(data);
                console.log(status);
            }
        );

    });

    $("#logoutPage").click(function(){
        $("#userMenu").css("visibility","hidden");
        $("#loginPage").css("visibility","visible")
    });

});

