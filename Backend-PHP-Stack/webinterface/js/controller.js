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
};

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
        var username = $("#usrname").val();
        var password = $("#psw").val();
        var data = {"username":username,"password":password};
        $.ajax({
            url:"../api/user/login",
            method: "POST",
            data: data,
            success: function(result){
                var res = JSON.parse(result);
                if(res.error ===0){
                    loadNavbar();
                    $("#myModal").modal("toggle");
                    $.toaster({ priority:'success',
                        title:'Success',
                        message: res.errorMsg});
                }
                else{
                    $.toaster({ priority:'success',
                        title: res.error,
                        message: res.errorMsg});

                }
            },
            error: function(error){
                $.toaster({ priority:'success',
                    title:error.status,
                    message: 'OOps seems like the server has some problems'});
            }
        });
    });

    $("#logoutPage").click(function(){
        $("#userMenu").css("visibility","hidden");
        $("#loginPage").css("visibility","visible");
        $.toaster({ priority:'success',
            title:'Success',
            message: 'Your now logged out'});
    });


});

