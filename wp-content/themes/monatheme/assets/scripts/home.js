'use strict';

(function ($) {
    $(document).ready(function () {
        const button_category = $('button[name="category"]');

        if (button_category.length) {
            button_category.on('click', function (e) {
                e.preventDefault();

                const _this = $(this);

                $('button[name="category"]').removeClass('active');
                _this.addClass('active');

                const data = {
                    action: 'mona_ajax_get_products',
                    security: mona_params.ajaxNonce,
                    limit: 8,
                };

                if (_this.val()) {
                    data.category = _this.val();
                }

                const ajax_list = $('#sgycn');

                ajax_list.addClass('processing');
                $.post(mona_params.ajaxURL, data, function (res) {
                    if (res.success) {
                        ajax_list.html(res.data.map(item => `<div class="col">${item}</div>`).join(''));
                    }

                    ajax_list.removeClass('processing');
                });
            });
        }

        const t = document.getElementById("powerTip");

        if (t) {
            new MutationObserver((() => {
                const t = $("#powerTip .box_view_html");
                if (!t.length || t.children(".powerTip-inner").length) return;
                t.children().not(".close_ihp").wrapAll('<div class="powerTip-inner"></div>');
            })).observe(t, {
                childList: !0
            })
        }
    });
})(jQuery);
