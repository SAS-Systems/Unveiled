/**
 * Created by Sebastian on 04.12.2015.
 */

var ApiAdapter = {
    //------------------------ public attributes -----------------------------------------------------------------------

    //------------------------ private attributes ----------------------------------------------------------------------
    __apiUrl: "../api/",

    //------------------------ private constants -----------------------------------------------------------------------
    __GET: "GET",
    __PUT: "PUT",
    __POST: "POST",

    //------------------------ public methods --------------------------------------------------------------------------
    doGet: function(url, data, cbSuccess, cbFailed) {
        this.__do(url, this.__GET, data, cbSuccess, cbFailed);
    },
    doPut: function(url, data, cbSuccess, cbFailed) {
        this.__do(url, this.__PUT, data, cbSuccess, cbFailed);
    },
    doPost: function(url, data, cbSuccess, cbFailed) {
        this.__do(url, this.__POST, data, cbSuccess, cbFailed);
    },

    //------------------------ private methods -------------------------------------------------------------------------
    __do: function(url, method, data, suc, err) {
        $.ajax({
            url: this.__apiUrl + url,
            method: method,
            data: data,
            success: function(result){
                var res = JSON.parse(result);
                if(res.error ===0){
                    suc(res);
                }
                else{
                    err(res);
                }
            },
            error: function(error){
                var res = {
                    "error": error.status,
                    "errorMsg":error.statusText,
                    "errorType": "E"
                };
                err(res);
            }
        });
    }
};
