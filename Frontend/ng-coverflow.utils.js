(function (ng) {
    'use strict';

    ng.module('ng-coverflow.utils', [])

        .factory('ngCoverflowItemFactory', [ function () {
            function NgCoveflowItem (title, subtitle, imageUrl, date) {
                this.__title = title;
                this.__subtitle = subtitle;
                this.__imageUrl = imageUrl;
                this.__date = date;
            }

            NgCoveflowItem.prototype = {
                get title() { return this.__title; },
                get subtitle() { return this.__subtitle; },
                get imageUrl() { return this.__imageUrl; },
                get date() { return this.__date; },
            };

            return function (data) {
                return new NgCoveflowItem(data.title || '', data.subtitle || '', data.imageUrl || '', data.date || '');
            };
        } ])

        .factory('ngCoverflowItemAdapterFactory', [ function () {
            function NgCoverflowItemAdapter(sourceObj, fieldMap) {
                this.__source = sourceObj;
                this.__map = fieldMap;
            }

            NgCoverflowItemAdapter.prototype = {
                get title() {
                    return this.__source[ this.__map.title || 'title' ];
                },
                get subtitle() {
                    return this.__source[ this.__map.subtitle || 'subtitle' ];
                },
                get imageUrl() {
                    return this.__source[ this.__map.imageUrl || 'imageUrl' ];
                },
                get date() {
                    return this.__source[ this.__map.date || 'date' ];
                },
                get source() {
                    return this.__source;
                }
            };

            return function (source, map) {
                return new NgCoverflowItemAdapter(source, map);
            };
        } ]);
} (angular));