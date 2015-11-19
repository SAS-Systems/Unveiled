(function (ng) {
    'use strict';

    ng.module('ng-coverflow.utils', [])

        .factory('ngCoverflowItemFactory', [ function () {
            function NgCoveflowItem (title, subtitle, imageUrl, date,resolutions,lengths,sizes, longitude) {
                this.__title = title;
                this.__subtitle = subtitle;
                this.__imageUrl = imageUrl;
                this.__date = date;
                this.__resolutions = resolutions;
                this.__lengths = lengths;
                this.__sizes = sizes;
                this.__longitude = longitude;
            }

            NgCoveflowItem.prototype = {
                get title() { return this.__title; },
                get subtitle() { return this.__subtitle; },
                get imageUrl() { return this.__imageUrl; },
                get date() { return this.__date; },
                get resolutions() { return this.__resolutions;},
                get lengths() { return this.__lengths;},
                get sizes() { return this.__sizes;},
                get longitude() {return this.__longitude;},
            };

            return function (data) {
                return new NgCoveflowItem(data.title || '', data.subtitle || '', data.imageUrl || '', data.date || '', data.resolutions || '', data.lengths || '', data.sizes || '', data.longitude || '');
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
                get resolutions() {
                    return this.__source[ this.__map.date || 'resolutions' ];
                },
                get lengths() {
                    return this.__source[ this.__map.date || 'lengths' ];
                },
                get sizes() {
                    return this.__source[ this.__map.date || 'sizes' ];
                },
                get longitude() {
                  return this.__source[ this.__map.longitude || 'longitude' ];
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