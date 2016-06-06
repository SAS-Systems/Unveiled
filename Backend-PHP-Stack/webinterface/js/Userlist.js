/**
 * Created by Fabian on 08.12.2015.
 */

list = function () {

    $.ajax({
        url: "../api/user/all",
        method: "GET",
        success: function(result){
            var res = JSON.parse(result);
            if(res.error === 0){

                var ul = $('<ul class="list-group">').appendTo("#userList");
                var li;
                var but;
                var ban;
                $(res.users).each(function(index, item){

                    li = $(document.createElement('li')).text(item.username);
                    li.addClass("list-group-item");
                    console.log(item.isActive);
                    if (item.isActive)
                        ban = $(document.createElement('button')).text("Deactivate");
                    else
                        ban = $(document.createElement('button')).text("Activate");

                    ban.attr("id","#"+item.id);
                    but =  $(document.createElement('button')).text("Change Permission"+"("+item.permission+")");
                    but.attr("id",item.id);
                    but.click(function (event) {

                        swal({   title: "User Permission!",
                                text: "1 = low, 2 = moderator, 3 = admin",
                                type: "input",   showCancelButton: true,
                                closeOnConfirm: false,
                                animation: "slide-from-top",
                                inputPlaceholder: "Permission" },
                            function(inputValue){
                                if (inputValue === false) return false;
                                if (inputValue === "") {
                                    swal.showInputError("You need to write something!")
                                    return false   }
                                else{
                                    swal({   title: "Are you sure?",
                                            text: "Your action will change the permission of the user!",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#DD6B55",
                                            confirmButtonText: "Yes, change it!",
                                            cancelButtonText: "No, cancel plx!",
                                            closeOnConfirm: false,
                                            closeOnCancel: false },
                                        function(isConfirm){
                                            if (isConfirm) {
                                                var data = {"permission": inputValue};
                                                $.ajax({
                                                    url: "../api/user/"+event.target.id,
                                                    method: "PUT",
                                                    data: data,
                                                    success: function(result){
                                                        var res = JSON.parse(result);
                                                        if(res.error === 0){
                                                            swal("Changed!", "The permission has been changed.", "success");
                                                            setTimeout(function(){ location.reload(); }, 2000);
                                                        }
                                                    }
                                                });


                                            }
                                            else {
                                                swal("Cancelled", "The permission is unaltered", "error");
                                            } });
                                }
                            });

                    });
                    but.addClass("btn btn-warning listBtn");
                    ban.addClass("btn btn-primary listBtn");

                    ban.click(function (event) {
                        swal({   title: "Are you sure?",
                                text: "Your action will "+event.target.textContent+" the selected user!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Yes, change it!",
                                cancelButtonText: "No, cancel plx!",
                                closeOnConfirm: false,
                                closeOnCancel: false },
                            function(isConfirm){
                                if (isConfirm) {
                                    if(event.target.textContent === "Deactivate")
                                        var data = {"active": "false"};
                                    else
                                        var data = {"active": "true"};
                                    var  userid = event.target.id;
                                    userid = userid.substring(1,userid.length);
                                    $.ajax({
                                        url: "../api/user/"+userid,
                                        method: "PUT",
                                        data: data,
                                        success: function(result){
                                            var res = JSON.parse(result);
                                            if(res.error === 0){
                                                swal("Completed!", "User "+event.target.textContent+"d.", "success");
                                                setTimeout(function(){ location.reload(); }, 2000);
                                            }
                                        }
                                    });
                                }
                                else {
                                    if(event.target.textContent === "Deactivate")
                                        swal("Cancelled", "User is still active", "error");
                                    else
                                        swal("Cancelled", "User is still deactivated", "error");
                                } });
                    });


                    li.append(ban);
                    li.append(but);

                    ul.append(li);
                });

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

}

$(document).ready(function(){
    list();

});