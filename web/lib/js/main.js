
$(function () {

    // View Controller
    View.listenEvent();

    tinymce.init({ selector:'textarea.chapter' });

    // API Manager
    loadApi.loadCalendarData();

    // Charts
    var model = new Model();  

});




