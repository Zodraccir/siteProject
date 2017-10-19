$(document).ready(function ($) {
    var url = window.location.pathname;
    var activePage = url.split("/")[1];
    var activePage = activePage.split("/")[0];
    console.log( activePage );

   $("#header").load("header.html",function(){
        $('li.menu-item a').each(function (index) {
            var linkPage= this.href;
            if (linkPage.indexOf(activePage)>0) {
                $(this).closest("li").addClass("current-menu-item");
        }

        });
    });
});

