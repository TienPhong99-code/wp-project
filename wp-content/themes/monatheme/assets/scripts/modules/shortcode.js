'use strict';

export function addToCart($) {
    const shortcodeContainer = $('.mona-short-product');
    if (shortcodeContainer.length) {
        shortcodeContainer.each(function () {
            const _thisContainer = $(this);

            const productType = _thisContainer.hasClass('variable')
                ? 'variable' : 'simple';

            
            /// Button increment and decrement
            if (_thisContainer.find('.count-plus, .count-minus').length) {
                _thisContainer.on('click', '.count-plus, .count-minus', function (e) {
                    e.preventDefault();
        
                    const _this = $(this);
                    const quantity = _this.closest('.info-variations').find('input.qty');
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
                    _this.closest('.info-variations')
                        .find('.count-number')
                        .html(input);
                });
            }

            // Make ajax add to cart 
            if (_thisContainer.find('.mona-shortcode-btn-cart').length) {
                const btn_add_to_cart = _thisContainer.find('.mona-shortcode-btn-cart');
                const btn_buynow = _thisContainer.find('.mona-shortcode-btn-buynow');

                _thisContainer.on( 'click', '.mona-shortcode-btn-cart:not(.disabled)', function(e) {
                    e.preventDefault();

                    // Element
                    let thisbutton = $(this),
                    product_qty = _thisContainer.find('input[name=quantity]').val() || 1,
                    product_id = _thisContainer.find('input[name=product_id]').val(),
                    variation_id = _thisContainer.find('input[name=variation_id]').val() || 0;

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
                            thisbutton.addClass('processing');
                        },
                        complete: function (response) {
                            thisbutton.addClass('added');
                            thisbutton.removeClass('processing');
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

                _thisContainer.on( 'click', '.mona-shortcode-btn-buynow:not(.disabled)', function(e) {
                    e.preventDefault();

                    // Element
                    let thisbutton = $(this),
                    product_qty = _thisContainer.find('input[name=quantity]').val() || 1,
                    product_id = _thisContainer.find('input[name=product_id]').val(),
                    variation_id = _thisContainer.find('input[name=variation_id]').val() || 0;

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
                            thisbutton.addClass('processing');
                        },
                        complete: function (response) {
                            thisbutton.addClass('added');
                            thisbutton.removeClass('processing');
                        },
                        success: function (response) {
                            if (response.error && response.product_url) {
                                window.mona_notification.error({
                                    title: 'Lỗi',
                                    message: 'Thêm giỏ hàng thất bại',
                                });

                                return false;
                            }

                            window.location.href = mona_params.checkout_url;
                            return false;
                        },
                    });
            
                    return false;
                });

                // is variable
                if (productType == 'variable') {
                    const current_variation = {};
                    let variations = _thisContainer.find('input[name="product_variations"]').val();
                    variations = JSON.parse(variations);
    
                    _thisContainer.on('select2:select', 'select', function(e) {
                        e.preventDefault();
                        let _this = $(this);

                        
                        let selects = _thisContainer.find('select');

                        for (let i = 0; i < selects.length; i++) {
                            current_variation[selects[i].name] = selects[i].value;
                        }
                        console.log(_this.val());
    
                        let findVariation = findMatchingVariation(variations, current_variation);
                        if (! findVariation || ! findVariation.variation_is_visible) {
                            toggleCartButton(false, btn_add_to_cart, btn_buynow);
                            return;
                        }
    
                        // Update html
                        if (! findVariation.variation_is_active
                            || ! findVariation.is_purchasable
                            || ! findVariation.is_in_stock
                        ) {
                            disableActions();
                        } else {
                            toggleCartButton(true, btn_add_to_cart, btn_buynow);
                        }
    
                        _thisContainer.find('.box-price')
                            .html(findVariation.price_html);
    
                        _thisContainer.find('.info-variation-sl input[name="quantity"]')
                            .attr('max', findVariation.max_qty)
                            .attr('min', findVariation.min_qty)
                            .val(1);
                        _thisContainer.find('.info-variation-sl .count-number')
                            .html(1);
                        _thisContainer.find('input[name="variation_id"]')
                            .val(findVariation.variation_id);
                    });
                }
            }
        });
    }
}

function findMatchingVariation(variations, variationSelected) {
    for (let i = 0; i < variations.length; i++) {
        let db_attributes = variations[i].attributes;
        let is_this_variation = true;

        for (let attr_name in db_attributes) {
            let db_val = db_attributes[attr_name];
            let user_val = variationSelected[attr_name];

            if (db_val !== "" && db_val !== user_val) {
                is_this_variation = false;
                break;
            }
        }

        if (is_this_variation) {
            return variations[i];
        }
    }
    return null;
} 

function toggleCartButton(enable, btn_add_to_cart, btn_buynow = null) {
    if (enable) {
        btn_add_to_cart.prop('disabled', false);
        btn_buynow ? btn_buynow.prop('disabled', false) : false;
    } else {
        btn_add_to_cart.prop('disabled', true);
        btn_buynow ? btn_buynow.prop('disabled', true) : false;
    }
}

function processAddToCart(selector, container) {

}