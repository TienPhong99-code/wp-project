'use strict';

(function ($) {
    $(document).ready(function() {
        const form = $('form.cart');

        // Init
        setTimeout(() => {
            if (! $('button.single_add_to_cart_button').hasClass('disabled')) {
                $('button[name="buy-now"]').prop('disabled', false);
            }
        }, 1000);

        /// Button increment and decrement
        if (form.find('.count-plus, .count-minus').length) {
            form.on('click', '.count-plus, .count-minus', function (e) {
                e.preventDefault();
    
                const _this = $(this);
                const quantity = _this.closest('.prod-dt__variation').find('input.qty');
                let input = Number(quantity.val().trim());

                // Subtraction
                if (_this.hasClass('count-minus')) {
                    if (input > 1) {
                        input--;
                    }
                } else {
                    input++;
                }
    
                quantity.val(input);
                _this.closest('.prod-dt__variation')
                    .find('.count-number')
                    .html(input);
            });
        }

        // Make ajax add to cart 
        if ($('.single_add_to_cart_button.mona-btn-cart').length) {
            $( document ).on( 'click', '.single_add_to_cart_button.mona-btn-cart:not(.disabled)', function(e) {
                e.preventDefault();

                // Element
                let thisbutton = $(this),
                form = thisbutton.closest('form.cart'),
                id = thisbutton.val(),
                product_qty = form.find('input[name=quantity]').val() || 1,
                product_id = form.find('input[name=product_id]').val() || id,
                variation_id = form.find('input[name=variation_id]').val() || 0;

                // Data to send ajax
                let data = {
                    action: 'mona_woocommerce_ajax_add_to_cart',
                    product_id: product_id,
                    product_sku: '',
                    quantity: product_qty,
                    variation_id: variation_id,
                };

                // Trigger add item to cart
                $(document.body).trigger('adding_to_cart', [thisbutton, data]);

                // Send ajax
                $.ajax({
                    type: 'POST',
                    url: wc_add_to_cart_params.ajax_url,
                    data: data,
                    beforeSend: function (response) {
                        thisbutton.removeClass('added');
                        thisbutton.addClass('loading');
                    },
                    complete: function (response) {
                        thisbutton.addClass('added');
                        thisbutton.removeClass('loading');
                    },
                    success: function (response) {
                        if (response.error && response.product_url) {
                            window.mona_notification.error({
                                title: 'Lỗi',
                                message: 'Thêm giỏ hàng thất bại',
                            });

                            return false;
                        }

                        // Update content
                        let fragments = response.fragments;
                        $(document.body).trigger('added_to_cart', [fragments, response.cart_hash, thisbutton]);

                        for (let selector in fragments) {
                            $(selector).html($(fragments[selector]).html());
                        }
                    },
                });
        
                return false;
            });

            // Button buy now
            $( 'form.cart' ).on('click', 'button[name="buy-now"]:disabled', function (e) {
                e.preventDefault();
            });
        }

        // Process comment
        if ($('form#mona-form-review').length) {
            const form_comment = $('form#mona-form-review');

            form_comment.on('submit', function (e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                $.ajax({
                    url: wc_add_to_cart_params.ajax_url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $(form).find('button')
                            .addClass('processing')
                            .prop('disabled', true);
                    },
                    success: function (res) {
                        if (res.success) {
                            window.mona_notification.success({
                                title: 'Thành công',
                                message: 'Gửi đánh giá thành công!',
                            });
                            form.reset();
                            $('.popup').removeClass('open');
                        } else {
                            alert(res.data);
                        }
                    },
                    error: function () {
                        window.mona_notification.error({
                            title: 'Lỗi',
                            message: 'Có lỗi xảy ra, vui lòng thử lại',
                        });
                    },
                    complete: function () {
                        $(form).find('button')
                            .removeClass('processing')
                            .prop('disabled', false);
                    }
                });
            });

            $('button[name="review_tab"]').on('click', function() {
                let rating = $(this).val();
                let product_id = $('.prod-tab__all input[name="product"]').val();

                $('button[name="review_tab"]').removeClass('active');
                $(this).addClass('active');

                $('button.comment-viewmore').data('rating', rating);

                $.ajax({
                    url: mona_params.ajaxURL,
                    type: 'POST',
                    data: {
                        action: 'load_reviews_by_rating',
                        rating: rating,
                        product_id: product_id
                    },
                    beforeSend: function(){
                        $('#review-content').html('Đang tải...');
                        
                    },
                    success: function(response){
                        $('#review-content').html(response || 'Chưa có đánh giá nào.');

                        if (response) {
                            $('button.comment-viewmore').data('offset', 5);
                            $('button.comment-viewmore').text('Xem thêm đánh giá');
                            $('button.comment-viewmore').prop('disabled', false);
                            $('button.comment-viewmore').css('display', 'inherit');
                        } else {
                            $('button.comment-viewmore').css('display', 'none');
                            $('button.comment-viewmore').prop('disabled', true);
                        }
                    }
                });
            });

            $('button.comment-viewmore').on('click', function(){
                let button = $(this);
                let offset = button.data('offset');
                let product_id = button.data('product-id');
                let rating = button.data('rating');

                $.ajax({
                    url: mona_params.ajaxURL,
                    type: 'POST',
                    data: {
                        action: 'load_reviews_by_rating',
                        offset: offset,
                        product_id: product_id,
                        rating
                    },
                    beforeSend: function(){
                        button.text('Đang tải...');
                    },
                    success: function(response){
                        if(response){
                            $('#review-content').append(response);
                            button.data('offset', offset + 5);
                            button.text('Xem thêm đánh giá');
                        } else {
                            button.text('Hết đánh giá');
                            button.prop('disabled', true);
                        }
                    }
                });
            });
        }
    });
})(jQuery);