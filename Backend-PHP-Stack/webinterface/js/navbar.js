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

 /*   $.getScript('js/apiAdapter.js', function() {
        $("#logoutPage").click(function () {
            ApiAdapter.doPost("user/logout", null,
                function (result) {
                    loadNavbar();
                    if (result.errorType === 'S')
                        $.toaster({
                            priority: 'success',
                            title: 'success',
                            message: result.errorMsg
                        });
                },
                function (error) {
                    $.toaster({
                        priority: 'danger',
                        title: error.error + ': OOps seems like the server has some problems',
                        message: error.errorMsg
                    });
                }
            );
        });
    }); */
});