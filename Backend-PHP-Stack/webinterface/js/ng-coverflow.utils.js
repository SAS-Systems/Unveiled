(function (ng) {
    'use strict';

    ng.module('ng-coverflow.utils', [])

        .factory('ngCoverflowItemFactory', [ function () {
            function NgCoveflowItem (title, subtitle, imageUrl, date,resolution,length,size, lng) {
                this.__title = title;
                this.__subtitle = subtitle;
                this.__imageUrl = imageUrl;
                this.__date = date;
                this.__resolution = resolution;
                this.__length = length;
                this.__size = size;
                this.__lng = lng;
            }

            NgCoveflowItem.prototype = {
                get title() { return this.__title; },
                get subtitle() { return this.__subtitle; },
                get imageUrl() { return this.__imageUrl; },
                get date() { return this.__date; },
                get resolution() { return this.__resolution;},
                get length() { return this.__length;},
                get size() { return this.__size;},
                get lng() {return this.__lng;},
            };

            return function (data) {
                return new NgCoveflowItem(data.title || '', data.subtitle || '', data.imageUrl || '', data.date || '', data.resolution || '', data.length || '', data.size || '', data.lng || '');
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
                get resolution() {
                    return this.__source[ this.__map.date || 'resolution' ];
                },
                get length() {
                    return this.__source[ this.__map.date || 'length' ];
                },
                get size() {
                    return this.__source[ this.__map.date || 'size' ];
                },
                get lng() {
                    return this.__source[ this.__map.lng || 'lng' ];
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