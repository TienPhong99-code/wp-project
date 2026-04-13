'use strict';

(function ($) {
    $(document).ready(function () {
        // Change avatar
        $('#avatar-upload').on('change', function () {
            let file = this.files[0];
            if (!file) return;

            let formData = new FormData();
            formData.append('action', 'mona_ajax_change_avatar');
            formData.append('simple-local-avatar', file);
            formData.append(
                '_simple_local_avatar_nonce',
                $('input[name="_simple_local_avatar_nonce"]').val()
            );

            $.ajax({
                url: mona_params.ajaxURL,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('.acc-edit.avatar').addClass('processing');
                },
                success: function (res) {
                    if (res.success) {
                        window.mona_notification.success({
                            title: 'Thành công',
                            message: res.data.message
                        });

                        $('.avatarReview').html(res.data.avatar);
                    } else {
                        window.mona_notification.error({
                            title: 'Thất bại',
                            message: res.data.message
                        });
                    }
                },
                complete: function () {
                    $('.acc-edit.avatar').removeClass('processing');
                },
            });
        });

        // Change account detail
        $('.acc-edit.account').on('click', function (e) {
            const form = $('#edit-account');

            form.find('input[name="fullname"]').val($('.account_name')[0].textContent);
            form.find('input[name="phone"]').val($('.account_phone').text());
            form.find('input[name="email"]').val($('.account_email')[0].textContent);
        });

        $('#edit-account').on('submit', function (e) {
            e.preventDefault();

            const _this = $(this);

            let formData = new FormData(this);
            formData.append('action', 'mona_ajax_update_account');
            formData.append('security', mona_params.ajaxNonce);

            const button = $(this).find('button');
            $.ajax({
                url: mona_params.ajaxURL,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    button.addClass('processing');
                },
                success: function (res) {
                    if (res.success) {
                        let data = res.data;

                        window.mona_notification.success({
                            title: 'Thành công',
                            message: data.message
                        });

                        $('.account_name').text(data.account_name);
                        $('.account_phone').text(data.account_phone);
                        $('.account_email').text(data.account_email);
                        _this.closest('.popup').find('.popup-close').click();
                    } else {
                        window.mona_notification.error({
                            title: 'Thất bại',
                            message: res.data.message
                        });
                    }
                },
                complete: function () {
                    button.removeClass('processing');
                },
            });
        });

        // Change address
        function loadDistricts({
            selectCityID, selectDistrictID, selectedValue = ''
        })
        {
            console.log(selectCityID, $(`#${selectCityID}`).val());
            $.ajax({
                type: "post",
                dataType: "json",
                url: vncheckout_array.get_address,
                data: {
                    action: "load_diagioihanhchinh",
                    matp: $(`#${selectCityID}`).val().trim()
                },
                beforeSend: function () {
                    $(`#${selectCityID}_field`).addClass("devvn_loading");
                },
                success: function (response) {
                    if (response.success) {
                        let listQH = response.data;

                        let html = '';
                        $.each(listQH, function (index, value) {
                            html += `<option value="${value.maqh}" ${selectedValue == value.maqh ? 'selected' : ''}>`;
                            html += `${value.name}</option>`;
                        });

                        $(`select#${selectDistrictID}`).html(html);
                    }

                    $(`#${selectCityID}_field`).removeClass("devvn_loading");
                },
            });
        }

        let address_json_input = $('input[name="address_json"]');
        
        $('.acc-edit.address').on('click', function (e) {
            const form = $('#edit-address');
            let address_json = JSON.parse(address_json_input.val());

            form.find('input[name="fullname"]').val(address_json.billing_last_name);
            form.find('input[name="phone"]').val(address_json.billing_phone);
            form.find('input[name="email"]').val(address_json.billing_email);
            form.find('input[name="address"]').val(address_json.billing_address_1);
            form.find('select[name="state"]').val(address_json.billing_state).trigger('change');
            loadDistricts({
                selectCityID: 'state_field', 
                selectDistrictID: 'city_field',
                selectedValue: address_json.billing_city
            });
        });

        $('#state_field').on('select2:select', function () {
            loadDistricts({
                selectCityID: 'state_field', 
                selectDistrictID: 'city_field'
            });
        });
        
        $('#edit-address').on('submit', function (e) {
            e.preventDefault();

            const _this = $(this);

            let formData = new FormData(this);
            formData.append('action', 'mona_ajax_update_address');
            formData.append('security', mona_params.ajaxNonce);

            const button = $(this).find('button');
            $.ajax({
                url: mona_params.ajaxURL,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    button.addClass('processing');
                },
                success: function (res) {
                    if (res.success) {
                        let data = res.data;

                        window.mona_notification.success({
                            title: 'Thành công',
                            message: data.message
                        });

                        let address_json = {
                            billing_last_name: _this.find('input[name="fullname"]').val(),
                            billing_phone: _this.find('input[name="phone"]').val(),
                            billing_email: _this.find('input[name="email"]').val(),
                            billing_state: _this.find('select[name="state"]').val(),
                            billing_city: _this.find('select[name="city"]').val(),
                            billing_address_1: _this.find('input[name="address"]').val(),
                        };

                        address_json_input.val(JSON.stringify(address_json));

                        let html = '';
                        html += `<p class="name">${address_json.billing_last_name}</p>`;
                        html += `<p class="val">${address_json.billing_phone}</p>`;
                        html += `<p class="val">${address_json.billing_email}</p>`;
                        html += `<p class="val">${data.address}</p>`;

                        $('.acc-main__address').html(html);

                        _this.closest('.popup').find('.popup-close').click();
                    } else {
                        window.mona_notification.error({
                            title: 'Thất bại',
                            message: res.data.message
                        });
                    }
                },
                complete: function () {
                    button.removeClass('processing');
                },
            });
        });
    });
})(jQuery);