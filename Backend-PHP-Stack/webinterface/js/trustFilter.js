/**
 * Created by D062427 on 18.04.2016.
 */

app.filter('trustUrl', function ($sce) {
    return function(url) {
        return $sce.trustAsResourceUrl(url);
    };
});