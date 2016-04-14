/**
 * Created by Sebastian on 07.12.15.
 */

loadNavbar = function () {
    if (($.cookie("loginToken")) !== undefined) {
        $("#userMenu").css("visibility", "visible");
        $("#loginPage").css("visibility", "hidden");
        $("#mediaPage").css("visibility", "visible");
        $("#usernameField").text(($.cookie("loginUsername")));
    }
    else {
        $("#userMenu").css("visibility", "hidden");
        $("#mediaPage").css("visibility", "hidden");
        $("#loginPage").css("visibility", "visible");
    }
};

loadAdminSettings = function () {
    if (($.cookie("loginAdmin")) === "true") {
        $("#deleteUser").css("visibility", "visible");
    }
    else {
        $("#deleteUser").css("visibility", "hidden");
    }
};
$(document).ready(function(){

    loadNavbar();

    loadAdminSettings();
    $.getScript('js/apiAdapter.js', function() {

        $("#logoutPage").click(function(){
            ApiAdapter.doPost("user/logout", null,
                function(result) {
                    loadNavbar();
                    if(result.errorType === 'S')
                        var pageUrl = window.location.pathname;
                    if(pageUrl.indexOf("index.html") < 0){
                        window.location.href = 'index.html';
                    }
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

    $("#deleteBtn").click(function(){
        console.log(currentItem.currentItem.targetScope.selectedIndex);
        $.ajax({
            url: "../api/file/"+currentItem.currentItem.targetScope.selectedIndex,
            type: "DELETE",
            success: function(result){
                var res = JSON.parse(result);

                },
            error: function(error){
                var res = {
                    "error": error.status,
                    "errorMsg":error.statusText,
                    "errorType": "E"
                };
            }


        });
    });
});