(function (ng) {
    ng.module('app', [ 'ng-coverflow', 'ng-coverflow.utils' ])
        .controller('AppCtrl', [ '$scope', 'ngCoverflowItemFactory', '$rootScope',  function ($scope, itemFactory, $rootScope) {
            $scope.selectedIndex = 0;

            $scope.items = [
                itemFactory({ title:'Item 0', subtitle:'Subtitle', imageUrl:'/Frontend/pictures/text10.gif', date:'12.08.2015'}),
                itemFactory({ title:'Item 1', subtitle:'Subtitle', imageUrl:'/Frontend/pictures/text1.gif', date:'06.07.2014'}),
                itemFactory({ title:'Item 2', subtitle:'Subtitle', imageUrl:'/Frontend/pictures/text2.gif', date:'06.07.2013'}),
                itemFactory({ title:'Item 3', subtitle:'Subtitle', imageUrl:'/Frontend/pictures/text3.gif', date:'06.07.2012'}),
                itemFactory({ title:'Item 4', subtitle:'Subtitle', imageUrl:'/Frontend/pictures/text4.gif', date:'06.07.2011'}),
                itemFactory({ title:'Item 5', subtitle:'Subtitle', imageUrl:'/Frontend/pictures/text5.gif', date:'06.07.2010'}),
                itemFactory({ title:'Item 6', subtitle:'Subtitle', imageUrl:'/Frontend/pictures/text6.gif', date:'06.07.2019'}),
                itemFactory({ title:'Item 7', subtitle:'Subtitle', imageUrl:'/Frontend/pictures/text7.gif', date:'06.07.2018'}),
                itemFactory({ title:'Item 8', subtitle:'Subtitle', imageUrl:'/Frontend/pictures/text8.gif', date:'06.07.2017'}),
                itemFactory({ title:'Item 9', subtitle:'Subtitle', imageUrl:'/Frontend/pictures/text9.gif', date:'06.07.2016'})
            ];

            $scope.itemClickHandler = function (item) {
                console.log('Item ' + item.title + ' was clicked');
                console.log($rootScope.currentItem);
                console.log($rootScope.currentItem.targetScope._currentItem.__date);
            };



           // $scope.currentItem = function(){

           // };


        } ]);
} (angular));