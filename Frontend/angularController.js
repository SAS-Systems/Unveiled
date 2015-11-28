(function (ng) {
    ng.module('app', [ 'ng-coverflow', 'ng-coverflow.utils' ])
        .controller('AppCtrl', [ '$scope', 'ngCoverflowItemFactory', '$rootScope',  function ($scope, itemFactory, $rootScope) {
            $scope.selectedIndex = 0;

            $scope.items = [
                itemFactory({ title:'Item 0', subtitle:'Subtitle', imageUrl:'/ng-coverflow/Frontend/pictures/text10.gif', date:'12.08.2015',resolutions:'1080p', longitude:'51.508742',latitude:'-0.120850',lengths:'15:00min',sizes:'20MB'}),
                itemFactory({ title:'Item 1', subtitle:'Subtitle', imageUrl:'/ng-coverflow/Frontend/pictures/text1.gif', date:'06.07.2014',resolutions:'1080p', longitude:'51.508742',latitude:'-0.120850',lengths:'14:00min',sizes:'29MB'}),
                itemFactory({ title:'Item 2', subtitle:'Subtitle', imageUrl:'/ng-coverflow/Frontend/pictures/text2.gif', date:'06.07.2013',resolutions:'1080p', longitude:'51.508742',latitude:'-0.120850',lengths:'13:00min',sizes:'28MB'}),
                itemFactory({ title:'Item 3', subtitle:'Subtitle', imageUrl:'/ng-coverflow/Frontend/pictures/text3.gif', date:'06.07.2012',resolutions:'1080p', longitude:'51.508742',latitude:'-0.120850',lengths:'12:00min',sizes:'27MB'}),
                itemFactory({ title:'Item 4', subtitle:'Subtitle', imageUrl:'/ng-coverflow/Frontend/pictures/text4.gif', date:'06.07.2011',resolutions:'1080p', longitude:'51.508742',latitude:'-0.120850',lengths:'11:00min',sizes:'26MB'}),
                itemFactory({ title:'Item 5', subtitle:'Subtitle', imageUrl:'/ng-coverflow/Frontend/pictures/text5.gif', date:'06.07.2010',resolutions:'1080p', longitude:'51.508742',latitude:'-0.120850',lengths:'10:00min',sizes:'25MB'}),
                itemFactory({ title:'Item 6', subtitle:'Subtitle', imageUrl:'/ng-coverflow/Frontend/pictures/text6.gif', date:'06.07.2019',resolutions:'1080p', longitude:'51.508742',latitude:'-0.120850',lengths:'16:00min',sizes:'24MB'}),
                itemFactory({ title:'Item 7', subtitle:'Subtitle', imageUrl:'/ng-coverflow/Frontend/pictures/text7.gif', date:'06.07.2018',resolutions:'1080p', longitude:'51.508742',latitude:'-0.120850',lengths:'17:00min',sizes:'23MB'}),
                itemFactory({ title:'Item 8', subtitle:'Subtitle', imageUrl:'/ng-coverflow/Frontend/pictures/text8.gif', date:'06.07.2017',resolutions:'1080p', longitude:'51.508742',latitude:'-0.120850',lengths:'18:00min',sizes:'22MB'}),
                itemFactory({ title:'Item 9', subtitle:'Subtitle', imageUrl:'/ng-coverflow/Frontend/pictures/text9.gif', date:'06.07.2016',resolutions:'1080p', longitude:'51.508742',latitude:'-0.120850',lengths:'19:00min',sizes:'21MB'})
            ];

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

