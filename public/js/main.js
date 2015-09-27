setTimeout(function()
{
    $('#errorSection').slideUp()
}, 2000);

$(document).on('submit', '.delete-form', function(){
    return confirm('Are you sure?');
});

var _gaq=[['_setAccount','UA-49178418-1'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src='//www.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
