/**
 * @file app.main.js
 */
var service = (function () {
    var my = {};
    var throbber = '<img width=24 src="/images/throbber.gif"/>';

    my.showModal = function (button) {
        var modal = '#modal-' + button.attr('data-service');
        jQuery().show(modal);
    };

    my.init = function() {
        jQuery('div.available-connections a.btn.connect')
            .each(function(index, button) {
                jQuery(button).on('click', function(event) {
                    event.preventDefault();
                    my.showModal(jQuery(this));
                });
            });

        jQuery('a.btn.connect.throbber')
            .each(function(index, button) {
                jQuery(button).on('click', function(event) {
                    jQuery(this).replaceWith(throbber);
                });
            });
    };

    return my;
}());

jQuery(function() {
   service.init();
});
