/**
 * Created by Sebastian on 07.12.15.
 */

loadNavbar = function () {
    if (($.cookie("loginToken")) !== undefined) {
        $("#userMenu").css("visibility", "visible");
        $("#loginPage").css("display", "none");
        $("#mediaPage").css("visibility", "visible");
        $.ajax({
            url: "../api/user/me",
            method: "GET",
//        data: dataTest,
            success: function(result){
                var res = JSON.parse(result);
                if(res.error === 0){
                    $("#usernameField").text(res.userData.username);
                }
            }});
    }
    else {
        $("#userMenu").css("visibility", "hidden");
        $("#mediaPage").css("visibility", "hidden");
        $("#loginPage").css("display", "inline");
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
    $("#downloadBtn").click(function() {
  //      $("#downloadBtn").attr({
    //        target: '_blank',
         //   href: 'http://sas.systemgrid.de/unveiled/content/GoPro%20Best%20of%202015%20-%20The%20Year%20in%20Review.MP4'
     //   });

        url = currentItem.currentItem.targetScope._currentItem.__fileUrl;

        // Create link.
        a = document.createElement( "a" );
        // Set link on DOM.
        document.body.appendChild( a );
        // Set link's visibility.
        a.style = "display: none";
        // Set href on link.
        a.href = url;
        // Set file name on link.
        a.download = currentItem.currentItem.targetScope._currentItem.__title;

        // Trigger click of link.
        a.click();
    });

    $("#deleteBtn").click(function(){
        swal({   title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",   showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: true },
            function(){    $.ajax({
                url: "../api/file/"+currentItem.currentItem.targetScope._currentItem.__id,
                type: "DELETE",
                success: function(result){
                    var res = JSON.parse(result);
                    swal("Deleted!", "Your file has been deleted.", "success");
                    setTimeout(function(){ location.reload(); }, 2000);


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
});