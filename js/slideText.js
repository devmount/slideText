$(document).ready(function(){
    $(".slidetext").click(function(event){
        /* toggle arrow marker */
        if (<<TOGGLE-ARROW>>) {
            $(this).children(".question").children(".toggle-arrow").toggleClass("opened");
        };
        /* set configuration */
        $(this).children(".answere").slideToggle(
            <<CONFIGURATION>>
        );
    });
});