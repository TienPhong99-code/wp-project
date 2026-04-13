'use strict';

(function ($) {
    $(document).ready(function () {
        const form = $('form.variations_form');
        const current_variation = {};
        const variations = form.data('product_variations');

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

        function toggleCartButton(enable) {
            if (enable) {
                $('button.single_add_to_cart_button').removeClass('disabled');
                $('button[name="buy-now"]').prop('disabled', false);
            } else {
                $('button.single_add_to_cart_button').addClass('disabled');
                $('button[name="buy-now"]').prop('disabled', true);
            }
        }

        $(document).on('change', '.prod-dt__variation-item input', function(e) {
            e.preventDefault();
            let _this = $(this);

            let selects = form.find('input:checked');

            for (let i = 0; i < selects.length; i++) {
                const select = $(selects[i]);
                select.closest('.prod-dt__variation')
                    .find('p.label .val')
                    .text(select.closest('.prod-dt__variation-item').data('label'));
                current_variation[selects[i].name] = selects[i].value;
            }

            let findVariation = findMatchingVariation(variations, current_variation);
            if (! findVariation || ! findVariation.variation_is_visible) {
                toggleCartButton(false);
                return;
            }

            // Update html
            if (! findVariation.variation_is_active
                || ! findVariation.is_purchasable
                || ! findVariation.is_in_stock
            ) {
                disableActions();
            } else {
                toggleCartButton(true);
            }

            $('.prod-dt__price .box-price')
                .html(findVariation.price_html);

            form.find('input.count-input')
                .attr('max', findVariation.max_qty)
                .attr('min', findVariation.min_qty)
                .val(1);
            form.find('.prod-dt__variation .count-number')
                .html(1);
            form.find('input[name="variation_id"]')
                .val(findVariation.variation_id);
        });

        setTimeout(() => {
            $('.prod-dt__variation-item input').trigger('change');
        }, 500);
    });
})(jQuery);