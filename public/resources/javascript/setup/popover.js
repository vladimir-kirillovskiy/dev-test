/*
 * Bootstrap popovers and tooltips
 */


var $ = require('jquery')


module.exports = function () {

    // initialise all popovers
    $('body').popover({
        selector: '[data-toggle="popover"]',
        container: 'body',
        viewport: { selector: 'body', padding: 20 }
    })
    
    // destroy all exsisting popovers
    $('[data-toggle="popover"]').bind('click', function(){
        $('.popover').popover('destroy');
    });
}