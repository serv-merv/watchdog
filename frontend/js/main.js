$(document).ready(function () {
    $("#resizeWindow").click(function () {
        $(".content .left, .content .right").toggle();

        $(".main-container").toggleClass("col-md-6");
        $(".main-container").toggleClass("col-md-12");

        mapboxgl.accessToken = 'pk.eyJ1IjoiYm9zdG9ubGVlayIsImEiOiJjajMwMGJjZHAwMDBnMndvZjd0dndreGdvIn0.tGx8QT3EOyUPhi1_FDtPtQ';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/dark-v9'
        });
    });
});