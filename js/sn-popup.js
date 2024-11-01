jQuery(document).ready(function($){
    var popup = $('.sn-popup');

    if(!popup.length) return;

    var delay = popup.data('delay');
    var openSpeed = popup.data('openspeed');
    var closeSpeed = popup.data('closespeed');

    var config = {};

    if(openSpeed)
        config.openSpeed = openSpeed;
    if(closeSpeed)
        config.closeSpeed = closeSpeed;

    if(delay){
        setTimeout(function(){
            $.featherlight(popup,config);
        }, delay)
    } else {
        $.featherlight(popup,config);
    }
});