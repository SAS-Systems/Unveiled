(function (ng) {
    'use strict';

    ng.module('ng-coverflow.utils', [])

        .factory('ngCoverflowItemFactory', [ function () {
            function NgCoveflowItem (title, subtitle, thumbnailUrl, dateStr,resolution,length,size, lng, lat, id, fileUrl) {
                this.__title = title;
                this.__subtitle = subtitle;
                this.__thumbnailUrl = thumbnailUrl;
                this.__dateStr = dateStr;
                this.__resolution = resolution;
                this.__length = length;
                this.__size = size;
                this.__lng = lng;
                this.__lat = lat;
                this.__id = id;
                this.__fileUrl = fileUrl;
            }

            NgCoveflowItem.prototype = {
                get title() { return this.__title; },
                get subtitle() { return this.__subtitle; },
                get thumbnailUrl() { return this.__thumbnailUrl; },
                get dateStr() { return this.__dateStr; },
                get resolution() { return this.__resolution;},
                get length() { return this.__length;},
                get size() { return this.__size;},
                get lng() {return this.__lng;},
                get lat() {return this.__lat;},
                get id() {return this.__id;},
                get fileUrl() {return this.__fileUrl;},
            };

            return function (data) {
                return new NgCoveflowItem(data.title || '', data.subtitle || '', data.thumbnailUrl || '', data.dateStr || '', data.resolution || '', data.length || '', data.size || '', data.lng || '', data.lat || '', data.id || '', data.fileUrl || '');
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
                get thumbnailUrl() {
                    return this.__source[ this.__map.thumbnailUrl || 'thumbnailUrl' ];
                },
                get dateStr() {
                    return this.__source[ this.__map.dateStr || 'dateStr' ];
                },
                get resolution() {
                    return this.__source[ this.__map.resolution || 'resolution' ];
                },
                get length() {
                    return this.__source[ this.__map.length || 'length' ];
                },
                get size() {
                    return this.__source[ this.__map.size || 'size' ];
                },
                get lng() {
                    return this.__source[ this.__map.lng || 'lng' ];
                },
                get lat() {
                    return this.__source[ this.__map.lat || 'lat' ];
                },
                get id() {
                    return this.__source[ this.__map.id || 'id' ];
                },
                get fileUrl() {
                    return this.__source[ this.__map.fileUrl || 'fileUrl' ];
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