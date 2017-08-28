
$(function () {

    // View Controller
    View.listenEvent();


    // Charts
    var charts = new Charts(JSON.parse($('#markStud').text()), JSON.parse($('#markValue').text()))

});
