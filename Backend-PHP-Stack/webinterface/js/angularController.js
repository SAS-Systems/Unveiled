(function (ng) {
    ng.module('app', [ 'ng-coverflow', 'ng-coverflow.utils' ])
        .controller('AppCtrl', [ '$scope', 'ngCoverflowItemFactory', '$rootScope','$http',  function ($scope, itemFactory, $rootScope,$http) {
            $scope.selectedIndex = 0;

            $http({
                method : "GET",
                url : "../api/file/all",
            }).then(function mySucces(response) {
                console.log(response.data);
                $scope.items=[];
                for(var index in response.data.files){
                    $scope.items.push(itemFactory(response.data.files[index]));
                };
            }, function myError(response) {
                console.log(response.statusText);
            });
            currentItem = $rootScope;

/*
            $scope.items = [
                itemFactory({ title:'Dummy Value', subtitle:'Description', imageUrl:'/unveiled/ftp/webinterface/pictures/mqdefault1.jpg', date:'12.08.2015',resolution:'1080p', lng:'51.508742',latitude:'-0.120850',length:'15:00min',size:'20MB'}),
                itemFactory({ title:'Dummy Value', subtitle:'Description', imageUrl:'/unveiled/ftp/webinterface/pictures/mqdefault2.jpg', date:'06.07.2014',resolution:'1080p', lng:'51.508742',latitude:'-0.120850',length:'14:00min',size:'29MB'}),
                itemFactory({ title:'Dummy Value', subtitle:'Description', imageUrl:'/unveiled/ftp/webinterface/pictures/mqdefault3.jpg', date:'06.07.2013',resolution:'1080p', lng:'51.508742',latitude:'-0.120850',length:'13:00min',size:'28MB'}),
                itemFactory({ title:'Dummy Value', subtitle:'Description', imageUrl:'/unveiled/ftp/webinterface/pictures/mqdefault4.jpg', date:'06.07.2012',resolution:'1080p', lng:'51.508742',latitude:'-0.120850',length:'12:00min',size:'27MB'}),
                itemFactory({ title:'Dummy Value', subtitle:'Description', imageUrl:'/unveiled/ftp/webinterface/pictures/mqdefault5.jpg', date:'06.07.2011',resolution:'1080p', lng:'51.508742',latitude:'-0.120850',length:'11:00min',size:'26MB'}),
                itemFactory({ title:'Dummy Value', subtitle:'Description', imageUrl:'/unveiled/ftp/webinterface/pictures/mqdefault6.jpg', date:'06.07.2010',resolution:'1080p', lng:'51.508742',latitude:'-0.120850',length:'10:00min',size:'25MB'}),
                itemFactory({ title:'Dummy Value', subtitle:'Description', imageUrl:'/unveiled/ftp/webinterface/pictures/mqdefault7.jpg', date:'06.07.2019',resolution:'1080p', lng:'51.508742',latitude:'-0.120850',length:'16:00min',size:'24MB'}),
                itemFactory({ title:'Dummy Value', subtitle:'Description', imageUrl:'/unveiled/ftp/webinterface/pictures/mqdefault8.jpg', date:'06.07.2018',resolution:'1080p', lng:'51.508742',latitude:'-0.120850',length:'17:00min',size:'23MB'}),
                itemFactory({ title:'Dummy Value', subtitle:'Description', imageUrl:'/unveiled/ftp/webinterface/pictures/mqdefault9.jpg', date:'06.07.2017',resolution:'1080p', lng:'51.508742',latitude:'-0.120850',length:'18:00min',size:'22MB'}),
            ];*/

            $scope.itemClickHandler = function (item) {
                console.log('Item ' + item.title + ' was clicked');
                console.log($rootScope.currentItem);
                console.log($rootScope.currentItem.targetScope._currentItem.__date);
                console.log($rootScope.currentItem.targetScope.selectedIndex);
            };



           // $scope.currentItem = function(){

           // };


        } ]);
} (angular));

var myCenter=new google.maps.LatLng(51.508742,-0.120850);

function initialize()
{
    var mapProp = {
        center:myCenter,
        zoom:10,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

    var marker=new google.maps.Marker({
        position:myCenter,
        animation:google.maps.Animation.BOUNCE
    });

    marker.setMap(map);

    var infowindow = new google.maps.InfoWindow({
        content: 'Latitude: ' +51.508742+ '<br>Longitude: ' +-0.120850
    });

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map,marker);
    });
}

google.maps.event.addDomListener(window, 'load', initialize);

