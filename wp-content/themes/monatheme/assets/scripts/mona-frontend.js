import Notification from './modules/notification.js';
import { addToCart } from './modules/shortcode.js';

(function ($) {
    window.mona_notification = Notification();

    $(document).ready(function () {
        addToCart($);

        // Copy link
        $('.copy-btn').on('click', function (e) {
            e.preventDefault();

            const _this = $(this);

            navigator.clipboard.writeText(_this.prop('href'))
                .then(() => {
                    _this.find('.tooltip').text(_this.data('success'));
                })
                .catch(() => {
                    _this.find('.tooltip').text(_this.data('fail'));
                })
                .finally(() => {
                    _this.addClass('show');
                    setTimeout(() => _this.removeClass('show'), 1500);
                });
        });

        // After add to cart
        $(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
            mona_notification.success({
                title: mona_params.cart['message-success-title'],
                message: mona_params.cart['message-success-content'],
            });
        });
    });
})(jQuery);