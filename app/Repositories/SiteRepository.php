<?php

declare(strict_types=1);

final class SiteRepository extends BaseRepository
{
    private ?array $settingsCache = null;

    /**
     * @return array<string, mixed>
     */
    public function content(): array
    {
        $settings = $this->getSettings();
        $contact = $settings['contact'];

        // Dynamic categories from taxonomies
        $wineTypes = $this->fetchAll("
            SELECT name, slug
            FROM taxonomies
            WHERE type = 'wine_type' AND is_active = 1
            ORDER BY display_order ASC, id ASC
        ");

        $producers = $this->fetchAll("
            SELECT name, slug
            FROM taxonomies
            WHERE type = 'producer' AND is_active = 1
            ORDER BY display_order ASC, name ASC
            LIMIT 7
        ");

        $countries = $this->fetchAll("
            SELECT name, slug
            FROM taxonomies
            WHERE type = 'country' AND is_active = 1
            ORDER BY display_order ASC, name ASC
        ");

        $wineChildren = array_map(static fn (array $t): array => [
            'attributes' => ['class' => 'menu-item menu-item-type-taxonomy'],
            'link_attributes' => ['class' => '', 'href' => '/danh-muc/' . $t['slug']],
            'label' => (string) $t['name'],
            'children' => [],
        ], $wineTypes);

        $producerChildren = array_map(static fn (array $p): array => [
            'attributes' => ['class' => 'menu-item menu-item-type-taxonomy'],
            'link_attributes' => ['class' => '', 'href' => '/danh-muc/' . $p['slug']],
            'label' => (string) $p['name'],
            'children' => [],
        ], $producers);

        return [
            'menus' => [
                'header_contact' => [
                    [
                        'attributes' => ['class' => ''],
                        'link_attributes' => ['class' => 'tooltip', 'title' => $contact['working_hours']],
                        'label' => $contact['working_hours'],
                        'label_wrapper' => 'span',
                        'icon_attributes' => ['class' => 'icon-clock'],
                        'icon_before' => true,
                        'children_attributes' => [],
                        'children' => [],
                    ],
                    [
                        'attributes' => ['class' => ''],
                        'link_attributes' => ['href' => 'tel:' . $contact['hotline'], 'class' => 'tooltip', 'title' => $contact['hotline_display']],
                        'label' => $contact['hotline_display'],
                        'label_wrapper' => 'span',
                        'icon_attributes' => ['class' => 'icon-phone'],
                        'icon_before' => true,
                        'children_attributes' => [],
                        'children' => [],
                    ],
                    [
                        'attributes' => ['class' => ''],
                        'link_attributes' => ['href' => $contact['messenger'], 'class' => 'tooltip', 'target' => '_blank', 'rel' => 'noopener', 'title' => 'Nhắn tin Messenger'],
                        'label' => 'Messenger',
                        'label_wrapper' => 'span',
                        'icon_attributes' => ['class' => 'icon-comment'],
                        'icon_before' => true,
                        'children_attributes' => [],
                        'children' => [],
                    ],
                    [
                        'attributes' => ['class' => ''],
                        'link_attributes' => ['href' => $contact['zalo_oa'], 'class' => 'tooltip', 'target' => '_blank', 'rel' => 'noopener', 'title' => 'Zalo tư vấn'],
                        'label' => 'Zalo',
                        'label_wrapper' => 'span',
                        'icon_attributes' => ['class' => 'icon-chat'],
                        'icon_before' => true,
                        'children_attributes' => [],
                        'children' => [],
                    ],
                ],
                'header_2' => [
                    [
                        'attributes' => ['class' => 'menu-item menu-item-type-post_type menu-item-object-page'],
                        'link_attributes' => ['class' => 'nav-top-link', 'href' => '/ve-duvin'],
                        'label' => 'Về Duvin',
                        'children' => [],
                    ],
                    [
                        'attributes' => ['class' => 'menu-item menu-item-type-post_type menu-item-object-page'],
                        'link_attributes' => ['class' => 'nav-top-link', 'href' => '/ve-nha-sang-lap'],
                        'label' => 'Nhà Sáng Lập',
                        'children' => [],
                    ],
                    [
                        'attributes' => ['class' => 'menu-item menu-item-type-post_type menu-item-object-page'],
                        'link_attributes' => ['class' => 'nav-top-link', 'href' => '/kien-thuc-whisky'],
                        'label' => 'Kiến Thức Rượu Vang',
                        'children' => [],
                    ],
                ],
                'header_3' => [
                    [
                        'attributes' => ['class' => 'menu-item menu-item-has-children has-dropdown'],
                        'link_attributes' => ['class' => 'nav-top-link', 'href' => '/danh-muc/wine', 'aria-expanded' => 'false', 'aria-haspopup' => 'menu'],
                        'label' => 'Bộ Sưu Tập Rượu Vang',
                        'icon_attributes' => ['class' => 'icon-angle-down'],
                        'icon_before' => false,
                        'children_attributes' => ['class' => 'sub-menu nav-dropdown nav-dropdown-default'],
                        'children' => $wineChildren,
                    ],
                    [
                        'attributes' => ['class' => 'menu-item menu-item-has-children has-dropdown'],
                        'link_attributes' => ['class' => 'nav-top-link', 'href' => '/san-pham', 'aria-expanded' => 'false', 'aria-haspopup' => 'menu'],
                        'label' => 'Nhà Sản Xuất',
                        'icon_attributes' => ['class' => 'icon-angle-down'],
                        'icon_before' => false,
                        'children_attributes' => ['class' => 'sub-menu nav-dropdown nav-dropdown-default'],
                        'children' => $producerChildren,
                    ],
                    [
                        'attributes' => ['class' => 'menu-item'],
                        'link_attributes' => ['class' => 'nav-top-link', 'href' => '/danh-muc/bo-qua-tang'],
                        'label' => 'Hộp Quà Doanh Nghiệp',
                        'children' => [],
                    ],
                    [
                        'attributes' => ['class' => 'menu-item'],
                        'link_attributes' => ['class' => 'nav-top-link', 'href' => '/san-pham'],
                        'label' => 'Tất Cả Sản Phẩm',
                        'children' => [],
                    ],
                ],
                'footer_0' => [
                    [
                        'attributes' => ['class' => ''],
                        'link_attributes' => ['class' => '', 'href' => '/ve-duvin'],
                        'label' => 'Về chúng tôi',
                        'children' => [],
                    ],
                    [
                        'attributes' => ['class' => ''],
                        'link_attributes' => ['class' => '', 'href' => '/ve-nha-sang-lap'],
                        'label' => 'Về nhà sáng lập',
                        'children' => [],
                    ],
                    [
                        'attributes' => ['class' => ''],
                        'link_attributes' => ['class' => '', 'href' => '/kien-thuc-whisky'],
                        'label' => 'Kiến thức rượu vang',
                        'children' => [],
                    ],
                ],
                'footer_1' => [
                    [
                        'attributes' => ['class' => ''],
                        'link_attributes' => ['class' => '', 'href' => '/danh-muc/wine'],
                        'label' => 'Rượu vang cao cấp',
                        'children' => [],
                    ],
                    [
                        'attributes' => ['class' => ''],
                        'link_attributes' => ['class' => '', 'href' => '/danh-muc/bo-qua-tang'],
                        'label' => 'Hộp quà tặng Tết',
                        'children' => [],
                    ],
                    [
                        'attributes' => ['class' => ''],
                        'link_attributes' => ['class' => '', 'href' => '/san-pham'],
                        'label' => 'Danh mục sản phẩm',
                        'children' => [],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array{
     *   age_gate: array{enabled: bool, cookie_minutes: int, title: string, message: string, confirm_label: string, deny_label: string},
     *   contact: array{hotline: string, hotline_display: string, zalo_oa: string, zalo_expert: string, messenger: string, fanpage: string, email: string, address: string, working_hours: string},
     *   catalog: array{price_note: string}
     * }
     */
    public function getSettings(): array
    {
        if ($this->settingsCache !== null) {
            return $this->settingsCache;
        }

        $kv = [];
        try {
            $rows = $this->fetchAll('SELECT `key`, `value` FROM `settings`');
            foreach ($rows as $row) {
                if (isset($row['key'])) {
                    $kv[(string) $row['key']] = (string) ($row['value'] ?? '');
                }
            }
        } catch (Throwable) {
            $kv = [];
        }

        $this->settingsCache = [
            'age_gate' => [
                'enabled'        => ($kv['age_gate_enabled'] ?? '1') === '1',
                'cookie_minutes' => max(1, (int) ($kv['age_gate_cookie_min'] ?? 15)),
                'title'          => (string) ($kv['age_gate_title'] ?? 'Xác minh độ tuổi'),
                'message'        => (string) ($kv['age_gate_message'] ?? 'Duvin cung cấp thông tin về sản phẩm rượu vang dành cho người trên 18 tuổi. Vui lòng xác nhận bạn đủ 18 tuổi để tiếp tục.'),
                'confirm_label'  => 'Tôi đủ 18 tuổi',
                'deny_label'     => 'Tôi chưa đủ 18 tuổi',
            ],
            'contact' => [
                'hotline'         => (string) ($kv['hotline_tel'] ?? '+84589598386'),
                'hotline_display' => (string) ($kv['hotline'] ?? '058 959 8386'),
                'zalo_oa'         => (string) ($kv['zalo_oa_url'] ?? 'https://zalo.me/0589598386'),
                'zalo_expert'     => (string) ($kv['zalo_expert_url'] ?? 'https://zalo.me/0589598386'),
                'messenger'       => (string) ($kv['messenger_url'] ?? 'https://www.facebook.com/messages/t/DuVinVN'),
                'fanpage'         => (string) ($kv['fanpage_url'] ?? 'https://www.facebook.com/DuVinVN'),
                'email'           => (string) ($kv['email'] ?? 'contact@duvin.vn'),
                'address'         => (string) ($kv['address'] ?? '58B Võ Văn Dũng, Phường Đống Đa, Thành phố Hà Nội'),
                'working_hours'   => (string) ($kv['working_hours'] ?? 'Thứ 2 - Chủ Nhật: 9h00 - 22h00'),
            ],
            'catalog' => [
                'price_note' => (string) ($kv['price_note'] ?? 'Giá đã bao gồm thuế VAT · Liên hệ Duvin để nhận tư vấn chính xác.'),
            ],
        ];

        return $this->settingsCache;
    }
}
