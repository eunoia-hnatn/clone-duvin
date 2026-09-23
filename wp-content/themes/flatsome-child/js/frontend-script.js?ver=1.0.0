//lấy content trong subtitle của slider tại home và hiện trong dot, đồng thời cho dots sang bên trái chung với col ở trên
document.addEventListener('DOMContentLoaded', function() {
    // Hàm để xử lý nội dung khi phần tử trong viewport
    const handleSliderContent = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Lấy phần tử .home-mainslider
                const mainSlider = entry.target;

                // Lấy tất cả các thẻ p trong .dtsubtitle bên trong .home-mainslider
                const subtitles = mainSlider.querySelectorAll('.dtsubtitle p');
                const dots = mainSlider.querySelectorAll('.flickity-page-dots .dot');

                // Duyệt qua từng dot và gán nội dung từ subtitles
                dots.forEach((dot, index) => {
                    if (subtitles[index]) {
                        dot.textContent = subtitles[index].textContent; // Chèn nội dung vào li
                        dot.setAttribute('aria-label', `Page dot ${index + 1}`); // Cập nhật aria-label
                        
                        // Tạo thẻ span
                        const span = document.createElement('span');
                        span.textContent = ``; // Nội dung cho span, có thể tùy chỉnh
                        
                        // Thêm span sau thẻ li
                        dot.insertAdjacentElement('afterend', span);
                    }
                });

                // Hàm để cập nhật left của .flickity-page-dots
                function updateDotsPosition() {
                    const colInner = mainSlider.querySelector('.center-maxwidth-50 .col-inner');
                    const dotsContainer = mainSlider.querySelector('.flickity-page-dots');

                    if (colInner && dotsContainer) {
                        const marginLeft = window.getComputedStyle(colInner).marginLeft; // Lấy giá trị margin-left
                        dotsContainer.style.left = marginLeft; // Đặt giá trị vào left của .flickity-page-dots
                    }
                }

                // Gọi hàm để thiết lập vị trí ban đầu
                updateDotsPosition();

                // Thêm class 'active' vào .flickity-page-dots
                const dotsContainer = mainSlider.querySelector('.flickity-page-dots');
                if (dotsContainer) {
                    dotsContainer.classList.add('active');
                }

                // Lắng nghe sự kiện resize
                window.addEventListener('resize', updateDotsPosition);

                // Ngừng theo dõi sau khi đã chạy
                observer.unobserve(mainSlider);
            }
        });
    };

    // Khởi tạo Intersection Observer
    const observer = new IntersectionObserver(handleSliderContent, {
        root: null, // Theo dõi trong viewport
        threshold: 0.5 // Tỷ lệ phần tử trong viewport để kích hoạt
    });

    // Lấy phần tử .home-mainslider và bắt đầu theo dõi
    const mainSlider = document.querySelector('.home-mainslider');
    if (mainSlider) {
        observer.observe(mainSlider);
    }
});



//Xử lý section choose a type of whisky trên Home
document.addEventListener('DOMContentLoaded', function() {
    // Di chuyển phần tử .dtsubtitle vào vị trí trên cùng trong <ul class="nav">
    const subtitle = document.querySelector('.home-section-choosewhisky .dtsubtitle');
    const navList = document.querySelector('.home-section-choosewhisky .nav');
    const exploreButton = document.querySelector('.home-section-choosewhisky a.choosetype-seemore');

    if (subtitle && navList) {
        navList.insertBefore(subtitle, navList.firstChild); // Di chuyển subtitle lên đầu
    }

    // Di chuyển nút "Khám phá sản phẩm" vào vị trí dưới cùng trong <ul>
    if (exploreButton && navList) {
        navList.appendChild(exploreButton); // Di chuyển exploreButton xuống cuối
    }

    // Thêm sự kiện click cho nút "Khám phá sản phẩm"
    exploreButton.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của nút

        // Tìm phần tử banner trong panel active
        const activePanel = document.querySelector('.home-section-choosewhisky .tab-panels .panel.active');
        if (activePanel) {
            const bannerLink = activePanel.querySelector('.home-section-choosewhisky .banner.has-hover a.fill');
            if (bannerLink) {
                bannerLink.click(); // Nhấp vào link bên trong banner
            }
        }
    });
});



// Xử lý see more trong product description
document.addEventListener('DOMContentLoaded', function() {
    const productLongDesCol = document.querySelector('.product-longdescol');
    const colInner = productLongDesCol.querySelector('.col-inner');
    const woocommerceTabs = document.querySelector('.woocommerce-tabs'); // Chọn phần tử woocommerce-tabs
    const tabPanels = woocommerceTabs.querySelector('.tab-panels'); // Chọn phần tử tab-panels

    // Tạo nút "Xem thêm"
    const seeMoreButton = document.createElement('button');
    seeMoreButton.className = 'see-more';
    seeMoreButton.textContent = 'Xem thêm'; // Thay đổi text thành "Xem thêm"
    
    // Tạo nút "Thu gọn"
    const seeLessButton = document.createElement('button');
    seeLessButton.className = 'see-less';
    seeLessButton.textContent = 'Thu gọn'; // Thay đổi text thành "Thu gọn"
    seeLessButton.style.display = 'none'; // Ẩn nút "Thu gọn" mặc định

    // Tạo lớp gradient
    const gradientOverlay = document.createElement('div');
    gradientOverlay.className = 'gradient-overlay';

    // Kiểm tra chiều cao nội dung
    if (colInner.scrollHeight > 300) {
        // Hiện nút "Xem thêm" và lớp gradient nếu nội dung vượt quá 300px
        productLongDesCol.appendChild(seeMoreButton);
        productLongDesCol.appendChild(seeLessButton);
        tabPanels.appendChild(gradientOverlay); // Chỉ thêm gradient vào bên trong tab-panels
        seeMoreButton.style.display = 'block';
        gradientOverlay.style.display = 'block'; // Hiện lớp gradient
    }

    // Thêm sự kiện click cho nút "Xem thêm"
    seeMoreButton.addEventListener('click', function() {
        colInner.style.maxHeight = colInner.scrollHeight + 'px'; // Mở rộng chiều cao đến chiều cao thực tế
        gradientOverlay.style.display = 'none'; // Ẩn lớp gradient khi mở rộng
        seeMoreButton.style.display = 'none'; // Ẩn nút "Xem thêm"
        seeLessButton.style.display = 'block'; // Hiện nút "Thu gọn"
    });

    // Thêm sự kiện click cho nút "Thu gọn"
    seeLessButton.addEventListener('click', function() {
        colInner.style.maxHeight = '300px'; // Đặt lại chiều cao tối đa
        gradientOverlay.style.display = 'block'; // Hiện lại lớp gradient
        seeLessButton.style.display = 'none'; // Ẩn nút "Thu gọn"
        seeMoreButton.style.display = 'block'; // Hiện lại nút "Xem thêm"

        // Cuộn về đầu của .product-longdestitlecol
        const productLongDesTitleCol = document.querySelector('.product-longdestitlecol'); // Chọn phần tử cần cuộn
        productLongDesTitleCol.scrollIntoView({ behavior: 'smooth' }); // Cuộn mượt mà
    });
});






//Change the product order dropdown to selectbox-->
document.addEventListener("DOMContentLoaded", function() {
    const select = document.querySelector('select[name="orderby"]');
    const options = select.querySelectorAll('option');
    const orderOptionsDiv = document.getElementById('order-options');

    options.forEach(option => {
        const link = document.createElement('a');
        link.href = `?orderby=${option.value}`;
        link.textContent = option.textContent;
        link.style.marginRight = '10px'; // Thêm khoảng cách giữa các liên kết
        orderOptionsDiv.appendChild(link);
    });
});
//Add active to categories by checking current URL
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentOrderby = urlParams.get('orderby') || 'menu_order'; // Mặc định là 'menu_order'
    const links = document.querySelectorAll('#order-options a');

    links.forEach(link => {
        const linkOrderby = new URL(link.href).searchParams.get('orderby');
        if (linkOrderby === currentOrderby) {
            link.classList.add('active');
        }
    });
});







//Convert price slider to range selector-->
document.addEventListener('DOMContentLoaded', function() {
    // Xác định các khoảng giá
    const priceRanges = [
        { label: 'Dưới 5 triệu', min: 0, max: 5000000 },
        { label: '5-10 triệu', min: 5000000, max: 10000000 },
        { label: '10-20 triệu', min: 10000000, max: 20000000 },
        { label: '20-50 triệu', min: 20000000, max: 50000000 },
        { label: '50-100 triệu', min: 50000000, max: 100000000 },
        { label: 'Trên 100 triệu', min: 100000000, max: Infinity },
    ];

    // Lấy giá trị min và max từ thuộc tính data-min và data-max
    const minPriceInput = document.getElementById('min_price');
    const maxPriceInput = document.getElementById('max_price');

    // Hàm để tạo danh sách các nút lọc giá
    function createPriceFilterList(minPrice, maxPrice) {
        const priceFilterList = document.createElement('ul');
        priceFilterList.className = 'woocommerce-widget-layered-nav-list';

        priceRanges.forEach(range => {
            // Kiểm tra xem khoảng giá có nằm trong giới hạn hiện tại không
            if (range.max >= minPrice && range.min <= maxPrice) {
                const listItem = document.createElement('li');
                listItem.className = 'woocommerce-widget-layered-nav-list__item wc-layered-nav-term';
                
                // Tạo liên kết cho mỗi khoảng giá
                const link = document.createElement('a');
                let url = new URL(window.location.href);
                
                // Thêm tham số min_price
                url.searchParams.set('min_price', range.min);
                
                // Thêm tham số max_price nếu không phải là khoảng "Trên 100 triệu"
                if (range.label !== 'Trên 100 triệu') {
                    url.searchParams.set('max_price', range.max);
                } else {
                    url.searchParams.delete('max_price'); // Xóa max_price nếu là trên 100 triệu
                }

                // Tạo URL cho liên kết
                link.href = url.toString();
                link.rel = 'nofollow';
                link.textContent = range.label;

                // Thêm sự kiện click
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
                    const isChosen = listItem.classList.contains('chosen');

                    // Nếu nút đã được chọn, xóa tham số khỏi URL
                    if (isChosen) {
                        url.searchParams.delete('min_price');
                        url.searchParams.delete('max_price');
                        window.location.href = url.toString(); // Tải lại trang mà không có tham số
                    } else {
                        // Cập nhật URL và tải lại trang
                        window.location.href = link.href;
                    }
                });

                listItem.appendChild(link);
                priceFilterList.appendChild(listItem);
            }
        });

        return priceFilterList;
    }

    // Hàm để cập nhật danh sách lọc giá
    function updatePriceFilter() {
        // Lấy giá trị min và max từ thuộc tính data-min và data-max
        const minPrice = parseInt(minPriceInput.getAttribute('data-min'), 10) || 0;
        const maxPrice = parseInt(maxPriceInput.getAttribute('data-max'), 10) || Infinity;

        // Tạo danh sách lọc giá mới
        const priceFilterList = createPriceFilterList(minPrice, maxPrice);

        // Tìm phần tử form và thay thế nó
        const priceFilterWidget = document.getElementById('woocommerce_price_filter-3');
        const formElement = priceFilterWidget.querySelector('form');

        if (formElement) {
            // Xóa form cũ trước khi thêm danh sách mới
            priceFilterWidget.replaceChild(priceFilterList, formElement);
        }

        // Kiểm tra URL để xác định nút nào được chọn
        const urlParams = new URLSearchParams(window.location.search);
        const selectedMinPrice = parseInt(urlParams.get('min_price'), 10);
        const selectedMaxPrice = parseInt(urlParams.get('max_price'), 10);

        // Đánh dấu nút tương ứng
        priceRanges.forEach(range => {
            if (selectedMinPrice === range.min && (selectedMaxPrice === range.max || (range.label === 'Trên 100 triệu' && !urlParams.has('max_price')))) {
                const listItem = Array.from(priceFilterList.children).find(li => li.textContent === range.label);
                if (listItem) {
                    listItem.classList.add('chosen'); // Thêm lớp .chosen cho thẻ li
                }
            }
        });
    }

    // Gọi hàm cập nhật lần đầu tiên
    updatePriceFilter();

    // Thêm sự kiện để cập nhật danh sách khi giá thay đổi
    minPriceInput.addEventListener('change', updatePriceFilter);
    maxPriceInput.addEventListener('change', updatePriceFilter);
});


document.addEventListener('DOMContentLoaded', function() {
    // Hàm để cuộn đến phần tử .row-filter-product
    function scrollToRowFilterProduct() {
        const rowFilterProduct = document.querySelector('.section-productcatheader');
        if (rowFilterProduct) {
            rowFilterProduct.scrollIntoView({ behavior: 'smooth' });
        }
    }

    // Kiểm tra xem có cần cuộn không
    if (sessionStorage.getItem('scrollToRowFilter')) {
        scrollToRowFilterProduct();
        sessionStorage.removeItem('scrollToRowFilter'); // Xóa flag sau khi cuộn
    }

    // Hàm để thiết lập sự kiện click cho các thẻ a
    function setupScrollOnClick(selector) {
        const links = document.querySelectorAll(selector);
        links.forEach(link => {
            link.addEventListener('click', function() {
                // Đánh dấu rằng cần cuộn xuống sau khi tải trang
                sessionStorage.setItem('scrollToRowFilter', 'true');
            });
        });
    }

    // Thiết lập sự kiện click cho các thẻ a trong #shop-sidebar
    setupScrollOnClick('#shop-sidebar a');

    // Thiết lập sự kiện click cho các thẻ a trong .woocommerce-pagination .page-numbers li
    setupScrollOnClick('.woocommerce-pagination .page-numbers li a');
});





// Xử lý see more trong SEO content
document.addEventListener('DOMContentLoaded', function() {
    const seoContentWrapper = document.querySelector('.seo-content-wrapper'); // Chọn phần tử .seo-content-wrapper
    const seoContent = seoContentWrapper.querySelector('.seo-content'); // Chọn phần tử .seo-content

    // Tạo lớp gradient
    const gradientOverlay = document.createElement('div');
    gradientOverlay.className = 'gradient-overlay';

    // Kiểm tra chiều cao nội dung
    if (seoContent.scrollHeight > 300) {
        // Thêm gradient vào bên trong seo-content
        seoContent.appendChild(gradientOverlay); 
        gradientOverlay.style.display = 'block'; // Hiện lớp gradient

        // Tạo nút "Xem thêm"
        const seeMoreButton = document.createElement('button');
        seeMoreButton.className = 'see-more';
        seeMoreButton.textContent = 'Xem thêm'; // Thay đổi text thành "Xem thêm"

        // Tạo nút "Thu gọn"
        const seeLessButton = document.createElement('button');
        seeLessButton.className = 'see-less';
        seeLessButton.textContent = 'Thu gọn'; // Thay đổi text thành "Thu gọn"
        seeLessButton.style.display = 'none'; // Ẩn nút "Thu gọn" mặc định

        // Thêm nút vào seo-content-wrapper
        seoContentWrapper.appendChild(seeMoreButton);
        seoContentWrapper.appendChild(seeLessButton);

        // Hiện nút "Xem thêm"
        seeMoreButton.style.display = 'block';

        // Thêm sự kiện click cho nút "Xem thêm"
        seeMoreButton.addEventListener('click', function() {
            seoContent.style.maxHeight = seoContent.scrollHeight + 'px'; // Mở rộng chiều cao đến chiều cao thực tế
            gradientOverlay.style.display = 'none'; // Ẩn lớp gradient khi mở rộng
            seeMoreButton.style.display = 'none'; // Ẩn nút "Xem thêm"
            seeLessButton.style.display = 'block'; // Hiện nút "Thu gọn"
        });

        // Thêm sự kiện click cho nút "Thu gọn"
        seeLessButton.addEventListener('click', function() {
            seoContent.style.maxHeight = '300px'; // Đặt lại chiều cao tối đa
            gradientOverlay.style.display = 'block'; // Hiện lại lớp gradient
            seeLessButton.style.display = 'none'; // Ẩn nút "Thu gọn"
            seeMoreButton.style.display = 'block'; // Hiện lại nút "Xem thêm"
        });
    }
});



//Replace stock status in product page
document.addEventListener('DOMContentLoaded', function() {
    // Lấy phần tử có class .add-to-cart-container
    const stockElement = document.querySelector('.add-to-cart-container p.stock');
    const productStockElement = document.querySelector('.product-stock');

    // Kiểm tra xem có nội dung trong phần tử p.stock hay không
    if (stockElement && stockElement.textContent.trim() !== '') {
        // Lưu nội dung của p.stock
        const stockText = stockElement.textContent;

        // Xóa p.stock
        stockElement.remove();

        // Cập nhật nội dung cho p.product-stock
        productStockElement.textContent = stockText;
    }
});




//Click URL when click on image on Logo Slider on Homepage home-brandlogo-slider
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.home-brandlogo-slider .box-image').forEach(boxImage => {
      boxImage.addEventListener('click', function() {
        // Tìm phần tử .box-text chứa thẻ <p> kế bên
        const boxText = this.closest('.gallery-col').querySelector('.box-text p');
        
        // Lấy URL từ thẻ <p>
        const url = boxText.innerText;

        // Mở URL trong tab mới
        window.open(url, '_blank');
      });
    });
  });

