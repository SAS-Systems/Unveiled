/**
 * Created by Sebastian on 07.12.15.
 */

$(document).ready(function(){

    $("#changeUsernameBtn").click(function(){
        var username;
        var email;
        var eNotification;
        var data = {
            "username": $("#inputNewUsername").val(),
            "email": $("#inputEmail").val(),
            "emailNotification": false};


        $.ajax({
            url: "../api/user/me",
            method: "PUT",
            data: data,
            success: function(result){
                var res = JSON.parse(result);
                if(res.error === 0){
                    username = res.username;
                    email = res.email;
                    eNotification = res.emailNotification;


                }
            },


            error: function(error){
                var res = {
                    "error": error.status,
                    "errorMsg":error.statusText,
                    "errorType": "E"
                };
                console.log(res);
            }


        });
    });

        $("#changeMailbtn").click(function(){
            var username;
            var email;
            var eNotification;
            var data = {
                "username": $("#inputUsrname").val(),
                "email": $("#inputNewMail").val(),
                "emailNotification": false};


            $.ajax({
                url: "../api/user/me",
                method: "PUT",
                data: data,
                success: function(result){
                    var res = JSON.parse(result);
                    if(res.error === 0){
                        username = res.username;
                        email = res.email;
                        eNotification = res.emailNotification;

                    }
                },


                error: function(error){
                    var res = {
                        "error": error.status,
                        "errorMsg":error.statusText,
                        "errorType": "E"
                    };
                    console.log(res);
                }


            });





        });

});