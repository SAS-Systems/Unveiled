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
    if (($.cookie("loginAdmin")) === true) {
        $("#deleteUser").css("visibility", "visible");
    }
    else {
        $("#deleteUser").css("visibility", "hidden");
    }
};
$(document).ready(function(){

    loadNavbar();

    loadAdminSettings();
});