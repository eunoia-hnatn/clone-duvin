jQuery(document).ready(function($) {
    // Tùy chỉnh tùy chọn cho Toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-left", // Đặt vị trí ở đây
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000", // Thời gian hiển thị
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    // Kiểm tra xem có thông báo WooCommerce không
    var $woocommerceMessage = $('.woocommerce-message');
    if ($woocommerceMessage.length) {
        // Lấy nội dung thông báo
        var message = $woocommerceMessage.html();
        
        // Hiển thị thông báo toast
        toastr.info(message);
        
        // Xóa thông báo WooCommerce
        $woocommerceMessage.remove(); // Xóa thông báo sau khi hiển thị
    }

    // Bắt sự kiện khi sản phẩm được thêm vào giỏ hàng
    $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
        // Kiểm tra lại thông báo sau khi thêm sản phẩm
        var $woocommerceMessage = $('.woocommerce-message');
        if ($woocommerceMessage.length) {
            var message = $woocommerceMessage.html();
            toastr.info(message);
            $woocommerceMessage.remove(); // Xóa thông báo sau khi hiển thị
        }
    });
});
