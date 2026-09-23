(function($){
    $(document).ready(function(){
        $('.engraving-price-num').html('0đ');
        $('.engraving-line-1').html('');
        $('.engraving-line-2').html('');
        $('.engraving-line-3').html('');
        var cartForm = $('#engraving .cart')
        cartForm.append('<input type="hidden" name="allow_engraving">');
        cartForm.append('<input type="hidden" name="engraving_line_1">');
        cartForm.append('<input type="hidden" name="engraving_line_2">');
        cartForm.append('<input type="hidden" name="engraving_line_3">');
        cartForm.append('<input type="hidden" name="font_choice_chai">');
        cartForm.append('<input type="hidden" name="allow_leather_engraving">');
        cartForm.append('<input type="hidden" name="leather_engraving">');
        cartForm.append('<input type="hidden" name="font_choice_da">');

        $(".engraving-box #engraving1").on("change", function(){
            var value = $(this).is(':checked');
            $('#engraving .cart input[name="allow_engraving"]').val(value)
            updateEngravingPrice()
        })

        $(".engraving-box #leather_engravings").on("change", function(){
            var value = $(this).is(':checked');
            $('#engraving .cart input[name="allow_leather_engraving"]').val(value)
            updateEngravingPrice()
        })

        $(".engraving-box input[name='font_choice_chai']").on("change", function(){
            var value = $(this).val();
            $('#engraving .cart input[name="font_choice_chai"]').val(value)

            if(value == 1){
                $('.box-text').removeClass('engrave-font-2')
                $('.box-text').removeClass('engrave-font-3')
                $('.box-text').addClass('engrave-font-1')
            }
            if(value == 2){
                $('.box-text').addClass('engrave-font-2')
                $('.box-text').removeClass('engrave-font-1')
                $('.box-text').removeClass('engrave-font-3')
            }
            if(value == 3){
                $('.box-text').addClass('engrave-font-3')
                $('.box-text').removeClass('engrave-font-2')
                $('.box-text').removeClass('engrave-font-1')
            }
            
            $('#font-selection-engraving .font-option').removeClass('active')
            $(this).closest('.font-option').addClass('active')
        })

        $(".engraving-box input[name='font_choice_da']").on("change", function(){
            var value = $(this).val();
            $('#engraving .cart input[name="font_choice_da"]').val(value)
            
             $(this).closest('#font-selection-leather').find('.font-option').removeClass('active')
            $(this).closest('.font-option').addClass('active')
        })

        $(".engraving-box input[name='engraving_line_1']").on("change", function(){
            var value = $(this).val();
            $('#engraving .cart input[name="engraving_line_1"]').val(value)
            
        })

        $(".engraving-box input[name='engraving_line_1']").on('keyup', function () {
            var value = $(this).val();
            $('.box-text .engraving-line-1').html(value)
        });

        $(".engraving-box input[name='engraving_line_2']").on('keyup', function () {
            var value = $(this).val();
            $('.box-text .engraving-line-2').html(value)
        });

        $(".engraving-box input[name='engraving_line_3']").on('keyup', function () {
            var value = $(this).val();
            $('.box-text .engraving-line-3').html(value)
        });

        $(".engraving-box input[name='engraving_line_2']").on("change", function(){
            var value = $(this).val();
            $('#engraving .cart input[name="engraving_line_2"]').val(value)
        })

        $(".engraving-box input[name='engraving_line_3']").on("change", function(){
            var value = $(this).val();
            $('#engraving .cart input[name="engraving_line_3"]').val(value)
        })

        $(".engraving-box input[name='leather_engraving']").on("change", function(){
            var value = $(this).val();
            $('#engraving .cart input[name="leather_engraving"]').val(value)
        })

        // Xử lý lựa chọn font cho Khắc tên lên chai
        $('input[name="font_choice_chai"]').change(function() {
            var selectedFont = $(this).val();
            var maxLength;
            var fontLimit1 = $('.normal-engraving-box').data('fontlimit1');
            var fontLimit2 = $('.normal-engraving-box').data('fontlimit2');
            var fontLimit3 = $('.normal-engraving-box').data('fontlimit3');
            switch (selectedFont) {
                case '1':
                    maxLength =fontLimit1;
                    break;
                case '2':
                    maxLength = fontLimit2;
                    break;
                case '3':
                    maxLength = fontLimit3;
                    break;
            }

            // Cập nhật maxlength cho các trường
            $('input[name^="engraving_line_"]').attr('maxlength', maxLength);
            $('input[name^="engraving_line_"]').each(function() {
                var countDisplay = $('#count_' + $(this).attr('name').slice(-1));
                countDisplay.text('0/' + maxLength);
            });
        });

        $('.product-engravingbtn').click(function(){
            var leftImage = $('.normal-engraving-box').data('leftimage');
            var rightImage = $('.normal-engraving-box').data('rightimage');
            if(rightImage){
                $('.engraving-bottle-position img').attr('src', rightImage)
            }
            if(leftImage){
                $('.engraving-bottle-img img').attr('src', leftImage)
            }
        })


        function updateEngravingPrice(){
            var normalEngravingPrice = Number.parseInt($('.normal-engraving-box').data('price'));
            var leatherEngravingPrice = Number.parseInt($('.leather-engraving-box').data('price'));

            var totalPrice = 0;
            if($('.engraving-box #engraving1').is(':checked')){
                totalPrice += normalEngravingPrice;
            }

            if($('.engraving-box #leather_engravings').is(':checked')){
                totalPrice += leatherEngravingPrice;
            }

            const formatPrice = formatCurrency(String(totalPrice), '')
            $('.engraving-price-num').html(formatPrice+'đ')
        }

        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        function formatCurrency(input_val, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.      
            
            // don't validate empty input
            if (input_val === "") { return; }
              
            // check for decimal
            if (input_val.indexOf(".") >= 0) {
          
              // get position of first decimal
              // this prevents multiple decimals from
              // being entered
              var decimal_pos = input_val.indexOf(".");
          
              // split number by decimal point
              var left_side = input_val.substring(0, decimal_pos);
              var right_side = input_val.substring(decimal_pos);
          
              // add commas to left side of number
              left_side = formatNumber(left_side);
          
              // validate right side
              right_side = formatNumber(right_side);
              
              // On blur make sure 2 numbers after decimal
              if (blur === "blur") {
                right_side += "00";
              }
              
              // Limit decimal to only 2 digits
              right_side = right_side.substring(0, 2);
          
              // join number by .
              input_val = left_side + "." + right_side;
          
            } else {
              // no decimal entered
              // add commas to number
              // remove all non-digits
              input_val = formatNumber(input_val);
              input_val = input_val;
              
              // final formatting
              if (blur === "blur") {
                input_val += ".00";
              }
            }
            return input_val
          }


        // $(document).on('click', '#engraving .single_add_to_cart_button', function(e) {
        //     if(preventSubmitAddtoCart){
        //         e.preventDefault(); // Chặn hành động mặc định
        //         preventSubmitAddtoCart = false;
        //         $(this).click()
        //     }

            


        //     const allowNormalEngraving = $("#engraving1").val()
        //     const engraving_line_1 = $('input[name="engraving_line_1"]').val()
        //     const engraving_line_2 = $('input[name="engraving_line_2"]').val()
        //     const engraving_line_3 = $('input[name="engraving_line_3"]').val()
        //     const font_choice_chai = $('input[name="font_choice_chai"]').val()

        //     const allow_leather_engraving = $("#leather_engravings").val()
        //     const leather_engraving = $('input[name="leather_engraving"]').val() 
        //     const font_choice_da = $('input[name="font_choice_da"]').val() 

        //     // Thêm dữ liệu vào form và submit lại form
        //     // form.append('<input type="hidden" name="engraving_line_1" value="' + engraving_line_1 + '">');
        //     // form.append('<input type="hidden" name="engraving_line_2" value="' + engraving_line_2 + '">');
        //     // form.append('<input type="hidden" name="engraving_line_3" value="' + engraving_line_3 + '">');
        //     // form.append('<input type="hidden" name="font_choice_chai" value="' + font_choice_chai + '">');
        //     // form.append('<input type="hidden" name="allow_leather_engraving" value="' + allow_leather_engraving + '">');
        //     // form.append('<input type="hidden" name="leather_engraving" value="' + leather_engraving + '">');
        //     // form.append('<input type="hidden" name="font_choice_da" value="' + font_choice_da + '">');

        //     $("<input />").attr("type", "hidden").attr("name", "engraving_line_1").attr("value", engraving_line_1).appendTo("form.cart");
        //     var form = $(this).closest('form.cart'); // Lấy form sản phẩm
        //     form.submit(); // Submit form bình thường
        // });

    });
})(jQuery);