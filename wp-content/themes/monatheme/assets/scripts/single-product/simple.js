'use strict';
(function ($) {
    $(document).ready(function () {
        if ($('.single_add_to_cart_button').length) {
            $('button[name="action_add_to_cart"]').removeClass('disabled');
            $('button[name="action_buy_now"]').removeClass('disabled');
    
            // Button buy now
            $( 'form.cart' ).on('click', 'button[name="buy-now"].disabled', function (e) {
                e.preventDefault();
            });
    
            if (! $('form.cart').hasClass('variations_form')) {
                $( 'form.cart' ).on('click', 'button[name="buy-now"]', function (e) {
                    const form = $('form.cart');
                    form.append('<input type="hidden" name="add-to-cart" value="' + this.value + '"/>');
                });
            }
        }
    });
})(jQuery);