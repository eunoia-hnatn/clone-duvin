<?php

// Phase 1 demo data, not verified commercial product specifications.
return [
    'filters' => [
        [
            'id' => 'woocommerce_layered_nav-3',
            'class' => 'widget woocommerce widget_layered_nav woocommerce-widget-layered-nav',
            'title' => 'Thương hiệu',
            'options' => [
                [
                    'label' => 'Château Margaux',
                    'url' => '/danh-muc/wine/?filter_brands=chateau-margaux&query_type_brands=or',
                    'count' => 0
                ],
                [
                    'label' => 'Concha y Toro',
                    'url' => '/danh-muc/wine/?filter_brands=concha-y-toro&query_type_brands=or',
                    'count' => 0
                ],
                [
                    'label' => 'Penfolds',
                    'url' => '/danh-muc/wine/?filter_brands=penfolds&query_type_brands=or',
                    'count' => 0
                ],
                [
                    'label' => 'Robert Mondavi',
                    'url' => '/danh-muc/wine/?filter_brands=robert-mondavi&query_type_brands=or',
                    'count' => 0
                ],
                [
                    'label' => 'San Marzano',
                    'url' => '/danh-muc/wine/?filter_brands=san-marzano&query_type_brands=or',
                    'count' => 0
                ],
                [
                    'label' => 'Antinori',
                    'url' => '/danh-muc/wine/?filter_brands=antinori&query_type_brands=or',
                    'count' => 0
                ],
                [
                    'label' => 'Louis Latour',
                    'url' => '/danh-muc/wine/?filter_brands=louis-latour&query_type_brands=or',
                    'count' => 0
                ],
                [
                    'label' => 'Santa Carolina',
                    'url' => '/danh-muc/wine/?filter_brands=santa-carolina&query_type_brands=or',
                    'count' => 0
                ]
            ]
        ],
        [
            'id' => 'woocommerce_layered_nav-4',
            'class' => 'widget woocommerce widget_layered_nav woocommerce-widget-layered-nav',
            'title' => 'Vintage',
            'options' => [
                [
                    'label' => '12-18 năm',
                    'url' => '/danh-muc/old-rare/?filter_do-tuoi=12-18-nam&query_type_do-tuoi=or',
                    'count' => 13
                ],
                [
                    'label' => '18-30 năm',
                    'url' => '/danh-muc/old-rare/?filter_do-tuoi=18-30-nam&query_type_do-tuoi=or',
                    'count' => 28
                ],
                [
                    'label' => 'Dưới 12 năm',
                    'url' => '/danh-muc/old-rare/?filter_do-tuoi=duoi-12-nam&query_type_do-tuoi=or',
                    'count' => 11
                ],
                [
                    'label' => 'NAS - None Age Statement',
                    'url' => '/danh-muc/old-rare/?filter_do-tuoi=nas-none-age-statement&query_type_do-tuoi=or',
                    'count' => 2
                ],
                [
                    'label' => 'Trên 30 năm',
                    'url' => '/danh-muc/old-rare/?filter_do-tuoi=tren-30-nam&query_type_do-tuoi=or',
                    'count' => 39
                ]
            ]
        ],
        [
            'id' => 'woocommerce_layered_nav-5',
            'class' => 'widget woocommerce widget_layered_nav woocommerce-widget-layered-nav',
            'title' => 'Loại thùng',
            'options' => [
                [
                    'label' => 'American Oak',
                    'url' => '/danh-muc/old-rare/?filter_loai-thung=american-oak&query_type_loai-thung=or',
                    'count' => 1
                ],
                [
                    'label' => 'Bourbon',
                    'url' => '/danh-muc/old-rare/?filter_loai-thung=bourbon&query_type_loai-thung=or',
                    'count' => 19
                ],
                [
                    'label' => 'European Oak',
                    'url' => '/danh-muc/old-rare/?filter_loai-thung=european-oak&query_type_loai-thung=or',
                    'count' => 6
                ],
                [
                    'label' => 'Gỗ sồi Pháp',
                    'url' => '/danh-muc/old-rare/?filter_loai-thung=go-soi-phap&query_type_loai-thung=or',
                    'count' => 6
                ],
                [
                    'label' => 'Hogshead',
                    'url' => '/danh-muc/old-rare/?filter_loai-thung=hogshead&query_type_loai-thung=or',
                    'count' => 1
                ],
                [
                    'label' => 'Rum',
                    'url' => '/danh-muc/old-rare/?filter_loai-thung=rum&query_type_loai-thung=or',
                    'count' => 2
                ],
                [
                    'label' => 'Sherry',
                    'url' => '/danh-muc/old-rare/?filter_loai-thung=sherry&query_type_loai-thung=or',
                    'count' => 54
                ]
            ]
        ],
        [
            'id' => 'woocommerce_layered_nav-6',
            'class' => 'widget woocommerce widget_layered_nav woocommerce-widget-layered-nav',
            'title' => 'Lọc lạnh',
            'options' => [
                [
                    'label' => 'Có lọc lạnh',
                    'url' => '/danh-muc/old-rare/?filter_loc-lanh=co-loc-lanh&query_type_loc-lanh=or',
                    'count' => 16
                ],
                [
                    'label' => 'Không có lọc lạnh',
                    'url' => '/danh-muc/old-rare/?filter_loc-lanh=khong-co-loc-lanh&query_type_loc-lanh=or',
                    'count' => 78
                ]
            ]
        ],
        [
            'id' => 'woocommerce_price_filter-3',
            'class' => 'widget woocommerce widget_price_filter',
            'title' => 'Khoảng giá',
            'options' => [
                [
                    'label' => 'Dưới 5 triệu',
                    'url' => '/danh-muc/old-rare/?min_price=0&max_price=5000000',
                    'count' => null
                ],
                [
                    'label' => '5-10 triệu',
                    'url' => '/danh-muc/old-rare/?min_price=5000000&max_price=10000000',
                    'count' => null
                ],
                [
                    'label' => '10-20 triệu',
                    'url' => '/danh-muc/old-rare/?min_price=10000000&max_price=20000000',
                    'count' => null
                ],
                [
                    'label' => '20-50 triệu',
                    'url' => '/danh-muc/old-rare/?min_price=20000000&max_price=50000000',
                    'count' => null
                ],
                [
                    'label' => '50-100 triệu',
                    'url' => '/danh-muc/old-rare/?min_price=50000000&max_price=100000000',
                    'count' => null
                ],
                [
                    'label' => 'Trên 100 triệu',
                    'url' => '/danh-muc/old-rare/?min_price=100000000',
                    'count' => null
                ]
            ]
        ]
    ],
    'related_slugs' => [
        'vang-sui-champagne-moet-chandon-brut-imperial',
        'vang-y-san-marzano-primitivo-2020',
        'vang-chile-don-melchor-2019',
        'vang-trang-louis-latour-pouilly-fume-2021',
        'vang-do-antinori-tignanello-2018',
        'vang-chile-santa-carolina-reserva-2022',
        'vang-trang-robert-mondavi-fume-blanc-2020',
        'hop-qua-tang-vang-cao-cap'
    ],
    'price_note' => '* Giá tham khảo, vui lòng liên hệ để được báo giá chính xác nhất'
];
