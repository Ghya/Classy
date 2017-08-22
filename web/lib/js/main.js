$(function () {

    // Page Controller   
    const pageController = new PageController(
        $("#page_container"), 
        document.getElementsByClassName("chapter_page").length, 
        0, 
        5000
    );

    // View Controller
    view.listenEvent();

});
