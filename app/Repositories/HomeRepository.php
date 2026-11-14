<?php

declare(strict_types=1);

final class HomeRepository extends BaseRepository
{
    /**
     * @return array<string, mixed>
     */
    public function content(): array
    {
        return [
            'hero_slides' => [
                [
                    'subtitle' => 'VANG PHÁP',
                    'description' => 'Tuyển tập những dòng vang tinh tế, mang đậm hơi thở của các vùng thổ nhưỡng trứ danh. Khám phá ngay để tìm ra hương vị yêu thích cho những khoảnh khắc gắn kết của bạn!',
                    'button_label' => 'KHÁM PHÁ NGAY',
                    'image' => [
                        'fetchpriority' => 'high',
                        'decoding' => 'async',
                        'width' => '1280',
                        'height' => '1312',
                        'src' => '/assets/images/duvin2.jpg',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Vang Pháp DuVin',
                        'title' => 'Vang Pháp DuVin'
                    ],
                    'title_lines' => [
                        'TINH HOA RƯỢU VANG TỪ CÁC CHATEAU DANH TIẾNG ĐÃ CÓ MẶT TẠI DUVIN'
                    ],
                    'button_url' => '/danh-muc/vang-phap',
                    'banner_url' => 'https://youtube.com/@amisduvin'
                ],
                [
                    'subtitle' => 'VANG Ý',
                    'description' => 'DuVin tự hào mang đến những dòng vang Ý thượng hạng, từ những chai mượt mà, ngọt ngào đến những chai chát đậm, cấu trúc chắc chắn. Một lựa chọn hoàn hảo để đánh thức mọi giác quan của người yêu vang.',
                    'button_label' => 'XEM THÊM',
                    'image' => [
                        'decoding' => 'async',
                        'width' => '1552',
                        'height' => '1013',
                        'src' => '/assets/images/duvin1.jpg',
                        'class' => 'bg attachment-2048x2048 size-2048x2048',
                        'alt' => 'Vang Ý Thượng Hạng DuVin',
                        'title' => 'Vang Ý Thượng Hạng DuVin'
                    ],
                    'title_lines' => [
                        'BẢN GIAO HƯỞNG ĐẬM ĐÀ VÀ QUYẾN RŨ'
                    ],
                    'button_url' => '/danh-muc/vang-y',
                    'banner_url' => '/danh-muc/bo-qua-tang/'
                ],
                [
                    'subtitle' => 'VANG CHILE',
                    'description' => 'Trải nghiệm sự bùng nổ hương vị trái cây chín mọng và tannin mềm mại của vang Chile. Dễ uống, dễ kết hợp ẩm thực và mức giá cực kỳ tiếp cận – đây luôn là lựa chọn tuyệt vời cho những buổi tụ họp bạn bè.',
                    'button_label' => 'KHÁM PHÁ NGAY',
                    'image' => [
                        'decoding' => 'async',
                        'width' => '1200',
                        'height' => '1200',
                        'src' => '/assets/images/duvin9.jpg',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Vang Chile DuVin',
                        'title' => 'Vang Chile DuVin'
                    ],
                    'title_lines' => [
                        'SỰ PHÁ CÁCH MẠNH MẼ TỪ TÂN THẾ GIỚI'
                    ],
                    'button_url' => '/danh-muc/vang-chile',
                    'banner_url' => '/kien-thuc-whisky/'
                ],
                [
                    'subtitle' => 'NEW ARRIVAL',
                    'description' => 'DuVin vừa cập bến những dòng vang mới nhất cho mùa lễ hội. Được đích thân chuyên gia nếm thử và tuyển chọn khắt khe, đây chắc chắn là những viên ngọc ẩn mang lại trải nghiệm đầy bất ngờ.',
                    'button_label' => 'XEM CHI TIẾT',
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '1920',
                        'height' => '1081',
                        'src' => '/assets/images/duvin3.jpg',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Bộ Sưu Tập Vang DuVin Mới Nhất',
                        'title' => 'Bộ Sưu Tập Vang DuVin Mới Nhất'
                    ],
                    'title_lines' => [
                        'BỘ SƯU TẬP VANG TUYỂN CHỌN MỚI NHẤT'
                    ],
                    'button_url' => '/danh-muc/new-arrival/',
                    'banner_url' => '/ve-nha-sang-lap/'
                ],
                [
                    'subtitle' => 'QUÀ TẶNG',
                    'description' => 'Thể hiện đẳng cấp và sự thấu hiểu với bộ sưu tập hộp quà tặng vang sang trọng từ DuVin. Thiết kế hộp da, hộp gỗ cao cấp cùng những chai vang xứng tầm, thay bạn gửi lời triân sâu sắc đến đối tác và người thân.',
                    'button_label' => 'XEM BỘ SƯU TẬP',
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '1947',
                        'height' => '808',
                        'src' => '/assets/images/duvin11.jpg',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Hộp Quà Tặng DuVin',
                        'title' => 'Hộp Quà Tặng DuVin'
                    ],
                    'title_lines' => [
                        'TRAO GỬI THÂM TÌNH QUA NHỮNG HỘP QUÀ TINH TẾ'
                    ],
                    'button_url' => '/danh-muc/bo-qua-tang',
                    'banner_url' => '/ve-nha-sang-lap/'
                ]
            ],
            'price_slides' => [
                [
                    'button_label' => 'Khám phá sản phẩm',
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '1920',
                        'height' => '920',
                        'src' => '/assets/images/whisky_duoi_20_banner_1.webp',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Vang Thượng Hạng Từ 5 Triệu | DuVin',
                        'title' => 'Vang Thượng Hạng Từ 5 Triệu | DuVin'
                    ],
                    'title_lines' => ['VANG THƯỢNG HẠNG ', 'TỪ 5 TRIỆU'],
                    'banner_url' => '/san-pham/?min_price=5000000&max_price=10000000',
                    'button_url' => '/danh-muc/wine'
                ],
                [
                    'button_label' => 'Khám phá sản phẩm',
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '1920',
                        'height' => '920',
                        'src' => '/assets/images/whisky_duoi_10_banner_1.webp',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Vang Thượng Hạng Từ 20 Triệu | DuVin',
                        'title' => 'Vang Thượng Hạng Từ 20 Triệu | DuVin'
                    ],
                    'title_lines' => ['VANG THƯỢNG HẠNG', 'TỪ 20 TRIỆU'],
                    'banner_url' => '/san-pham/?min_price=20000000&max_price=50000000',
                    'button_url' => '/danh-muc/wine'
                ],
                [
                    'button_label' => 'Khám phá sản phẩm',
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '1920',
                        'height' => '920',
                        'src' => '/assets/images/whisky_duoi_6_banner_1.webp',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Vang Thượng Hạng Từ 30 Triệu | DuVin',
                        'title' => 'Vang Thượng Hạng Từ 30 Triệu | DuVin'
                    ],
                    'title_lines' => ['VANG THƯỢNG HẠNG ', ' TỪ 30 TRIỆU'],
                    'banner_url' => '/san-pham/?min_price=30000000',
                    'button_url' => '/danh-muc/wine'
                ],
                [
                    'button_label' => 'Khám phá sản phẩm',
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '1920',
                        'height' => '920',
                        'src' => '/assets/images/whisky_duoi_4_banner-1.webp',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Vang Thượng Hạng Từ 10 Triệu | DuVin',
                        'title' => 'Vang Thượng Hạng Từ 10 Triệu | DuVin'
                    ],
                    'title_lines' => ['VANG THƯỢNG HẠNG ', 'TỪ 10 TRIỆU'],
                    'banner_url' => null,
                    'button_url' => '/danh-muc/wine'
                ]
            ],
            'category_tabs' => [
                [
                    'title' => 'VANG PHÁP CỔ ĐIỂN',
                    'url' => '/danh-muc/vang-phap',
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '2300',
                        'height' => '1203',
                        'src' => '/assets/images/dt_world_whisky_banner.webp',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Vang Pháp Cổ Điển | DuVin',
                        'title' => 'Vang Pháp Cổ Điển | DuVin'
                    ]
                ],
                [
                    'title' => 'VANG Ý ĐẬM ĐÀ',
                    'url' => '/danh-muc/vang-y',
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '2300',
                        'height' => '1203',
                        'src' => '/assets/images/dt_japanese_whisky_banner.webp',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Vang Ý Đậm Đà | DuVin',
                        'title' => 'Vang Ý Đậm Đà | DuVin'
                    ]
                ],
                [
                    'title' => 'VANG TÂN THẾ GIỚI',
                    'url' => '/danh-muc/vang-tan-the-gioi',
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '1920',
                        'height' => '1004',
                        'src' => '/assets/images/Artboard-19-2.webp',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Vang Tân Thế Giới | DuVin',
                        'title' => 'Vang Tân Thế Giới | DuVin'
                    ]
                ]
            ],
            'statistics' => [
                ['value' => 110000, 'label' => 'Lượt theo dõi'],
                ['value' => 18000000, 'label' => 'Lượt xem']
            ],
            'collections' => [
                [
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '1253',
                        'height' => '704',
                        'src' => '/assets/images/duvin11.jpg',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Bộ Sưu Tập DuVin',
                        'title' => 'Bộ Sưu Tập DuVin'
                    ]
                ],
                [
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '1202',
                        'height' => '1536',
                        'src' => '/assets/images/gift1.jpg',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Wine Tasting Sets | DuVin',
                        'title' => 'Wine Tasting Sets | DuVin'
                    ],
                    'url_0' => '/danh-muc/set-thu-ruou/',
                    'url_1' => '/danh-muc/bo-qua-tang',
                    'text_0' => 'WINE TASTING SETS',
                    'text_1' => 'KHÁM PHÁ ĐA DẠNG HƯƠNG VỊ'
                ],
                [
                    'image' => [
                        'loading' => 'lazy',
                        'decoding' => 'async',
                        'width' => '1200',
                        'height' => '1489',
                        'src' => '/assets/images/gift2.jpg',
                        'class' => 'bg attachment-original size-original',
                        'alt' => 'Premium Gift Set | DuVin',
                        'title' => 'Premium Gift Set | DuVin'
                    ],
                    'url_0' => '/danh-muc/bo-qua-tang/',
                    'url_1' => '/danh-muc/bo-qua-tang',
                    'text_0' => 'PREMIUM GIFT SET',
                    'text_1' => 'HỘP QUÀ TẶNG DOANH NGHIỆP Ý NGHĨA'
                ]
            ],
            'copy' => [
                'brands_heading' => ['NHỮNG THƯƠNG HIỆU NỔI TIẾNG'],
                'influence_eyebrow' => ['DUVIN\'S INFLUENCE'],
                'influence_heading' => ['SỨC ẢNH HƯỞNG VÀ', ' LAN TỎA CỦA ', 'DUVIN'],
                'influence_description' => [
                    'DuVin đang từng bước khẳng định vị thế là một trong những cộng đồng chia sẻ kiến thức và văn hóa rượu vang uy tín trên các nền tảng mạng xã hội. Qua những bài viết, video đánh giá chân thực và gần gũi, chúng tôi mong muốn truyền cảm hứng và kết nối những người yêu vang tại Việt Nam.'
                ],
                'social_milestone' => ['Đánh dấu sự phát triển mạnh mẽ trên Facebook & Zalo'],
                'regions_heading' => ['LỰA CHỌN VÙNG RƯỢU VANG'],
                'gifts_eyebrow' => ['Gift & accessories'],
                'gifts_heading' => ['BỘ SƯU TẬP HỘP QUÀ TẶNG SANG TRỌNG']
            ]
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function presentation(): array
    {
        return [
            'hero' => [
                [
                    'ids' => ['row-1922335903', 'col-823827177', 'row-1187038803', 'col-577842964', 'text-3694114886', 'text-2435649643', 'col-1882220669', 'banner-979033297', 'text-box-1100581749'],
                    'row_class' => 'row row-collapse row-full-width align-equal align-center',
                    'height' => '85%',
                    'position' => '48% 57%',
                    'light_heading' => false,
                    'column_attributes' => ['id' => 'col-823827177', 'class' => 'col full-50center-col medium-6 small-12 large-6', 'data-animate' => 'bounceIn'],
                    'inner_attributes' => ['class' => 'col-inner dark'],
                    'link_attributes' => [['target' => '_blank', 'class' => 'button white is-outline', 'rel' => 'noopener nofollow'], ['class' => 'fill', 'rel' => 'nofollow noopener', 'target' => '_blank']]
                ],
                [
                    'ids' => ['row-1820758871', 'col-237622452', 'row-381728242', 'col-1763453208', 'text-3069244932', 'text-2849886364', 'col-1606553887', 'banner-172421307', 'text-box-2101962369'],
                    'row_class' => 'row row-collapse row-full-width align-equal align-center',
                    'height' => '85%',
                    'position' => '50% 50%',
                    'light_heading' => true,
                    'column_attributes' => ['id' => 'col-237622452', 'class' => 'col full-50center-col medium-6 small-12 large-6', 'data-animate' => 'bounceIn'],
                    'inner_attributes' => ['class' => 'col-inner dark'],
                    'link_attributes' => [['class' => 'button white is-outline'], ['class' => 'fill']]
                ],
                [
                    'ids' => ['row-1189397621', 'col-2079080757', 'row-40291993', 'col-448103316', 'text-2487441999', 'text-1919995188', 'col-1172825832', 'banner-1911364539', 'text-box-1262447953'],
                    'row_class' => 'row row-collapse row-full-width align-equal align-center',
                    'height' => '85%',
                    'position' => '50% 50%',
                    'light_heading' => true,
                    'column_attributes' => ['id' => 'col-2079080757', 'class' => 'col full-50center-col medium-6 small-12 large-6', 'data-animate' => 'bounceIn'],
                    'inner_attributes' => ['class' => 'col-inner dark'],
                    'link_attributes' => [['class' => 'button white is-outline'], ['class' => 'fill']]
                ],
                [
                    'ids' => ['row-1510103197', 'col-152010837', 'row-1144211603', 'col-410069352', 'text-1707576550', 'text-221666679', 'col-1090483861', 'banner-1698295982', 'text-box-1215443242'],
                    'row_class' => 'row row-collapse row-full-width align-equal align-center',
                    'height' => '85%',
                    'position' => '50% 50%',
                    'light_heading' => true,
                    'column_attributes' => ['id' => 'col-152010837', 'class' => 'col full-50center-col medium-6 small-12 large-6', 'data-animate' => 'bounceIn'],
                    'inner_attributes' => ['class' => 'col-inner dark'],
                    'link_attributes' => [['class' => 'button white is-outline'], ['class' => 'fill']]
                ],
                [
                    'ids' => ['row-805178059', 'col-2041285324', 'row-1614742721', 'col-1768461746', 'text-3507850259', 'text-3407985449', 'col-1428230554', 'banner-1834199923', 'text-box-1393661131'],
                    'row_class' => 'row row-collapse row-full-width align-equal align-center',
                    'height' => '85%',
                    'position' => '50% 50%',
                    'light_heading' => true,
                    'column_attributes' => ['id' => 'col-2041285324', 'class' => 'col full-50center-col medium-6 small-12 large-6', 'data-animate' => 'bounceIn'],
                    'inner_attributes' => ['class' => 'col-inner dark'],
                    'link_attributes' => [['class' => 'button white is-outline'], ['class' => 'fill']]
                ]
            ],
            'price' => [
                ['ids' => ['banner-190753066', 'text-box-1107567781', 'text-1888062961', 'text-box-1133374249'], 'background' => '#3f170f'],
                ['ids' => ['banner-1134262102', 'text-box-942699898', 'text-3574921671', 'text-box-1582845620'], 'background' => '#3f170f'],
                ['ids' => ['banner-308182967', 'text-box-1517724225', 'text-3184614620', 'text-box-1748247065'], 'background' => '#3f170f'],
                ['ids' => ['banner-2063084966', 'text-box-1718059530', 'text-1891963955', 'text-box-1533276686'], 'background' => '#3f170f']
            ],
            'tabs' => [
                [
                    'tab_id' => 'tab-vang-phap',
                    'panel_id' => 'tab_vang-phap',
                    'ids' => ['banner-154442658', 'text-box-1262973491'],
                    'background' => '#3f170f'
                ],
                [
                    'tab_id' => 'tab-vang-y',
                    'panel_id' => 'tab_vang-y',
                    'ids' => ['banner-2131976074', 'text-box-2114704381'],
                    'background' => '#3f170f'
                ],
                [
                    'tab_id' => 'tab-vang-chile',
                    'panel_id' => 'tab_vang-chile',
                    'ids' => ['banner-1090547792', 'text-box-812061266'],
                    'background' => '#3f170f'
                ]
            ],
            'statistics' => [
                [
                    'row-1404662968',
                    'col-589037030',
                    'text-2916360142',
                    'text-4230103372'
                ],
                [
                    'row-385751197',
                    'col-646669310',
                    'text-2186524649',
                    'text-1670527859'
                ]
            ],
            'brand_image_defaults' => [
                'decoding' => 'async',
                'height' => '225',
                'class' => 'home-brandlogo-slider',
                'loading' => 'lazy',
            ],
        ];
    }
}
