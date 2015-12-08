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
        $("#mediaPage").css("visibility", "visible");
    }
    else {
        $("#userMenu").css("visibility", "hidden");
        $("#mediaPage").css("visibility", "hidden");
        $("#loginPage").css("visibility", "visible");
    }
};


loadAdminSettings = function () {
    if (($.cookie("loginAdmin")) === true) {
        $("#deleteUser").css("visibility", "visible");
    }
    else {
        $("#deleteUser").css("visibility", "hidden");
    }
};

$(document).ready(function(){
    $.getScript('js/apiAdapter.js', function() {
        $("#myBtn").click(function(){
            $("#myModal").modal("toggle");
        });

        $("#signupBtn").click(function(){
            var data = {
                "username": $("#username").val(),
                "email": $("#email").val(),
                "password": $("#passw").val()
            };

            ApiAdapter.doPost("user", data,
                function(result) {
                    $("#mySignUp").modal("toggle");
                    $.toaster({ priority:'success',
                                title:'Success',
                                message: result.errorMsg});

                },
                function(error){
                    $.toaster({ priority:'danger',
                                title: error.error,
                                message: error.errorMsg});
                }
            );
        });

        $("#loginBtn").click(function(){
            var data = {
                "username": $("#usrname").val(),
                "password": $("#psw").val()
            };

            ApiAdapter.doPost("user/login", data,
                function(result) {
                    loadNavbar();
                    loadAdminSettings();
                    $("#myModal").modal("toggle");
                    $.toaster({ priority:'success',
                                title:'Success',
                                message: result.errorMsg});
                    $("#usernameField").text(data.username);
                    console.log("YEAH");
                },
                function(error){
                    $.toaster({ priority:'danger',
                                title: error.error,
                                message: error.errorMsg});
                }
            );
        });

        $("#logoutPage").click(function(){
            ApiAdapter.doPost("user/logout", null,
                function(result) {
                    loadNavbar();
                    if(result.errorType === 'S')
                        $.toaster({ priority:'success',
                                    title:'success',
                                    message: result.errorMsg});
                },
                function(error){
                    $.toaster({ priority:'danger',
                                title: error.error,
                                message: error.errorMsg});
                }
            );
        });
    });
});

