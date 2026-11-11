<?php

declare(strict_types=1);

final class SiteRepository extends FixtureRepository
{
    public function content(): array
    {
        return $this->load('site');
    }

    /**
     * Cấu hình toàn trang — mock data cho Phase 2.
     * Sẽ chuyển sang đọc từ bảng `settings` khi Database sẵn sàng.
     *
     * @return array{
     *   age_gate: array{enabled: bool, cookie_minutes: int, title: string, message: string, confirm_label: string, deny_label: string},
     *   contact: array{hotline: string, zalo_oa: string, zalo_expert: string, messenger: string}
     * }
     */
    public function getSettings(): array
    {
        return [
            'age_gate' => [
                'enabled'         => true,
                'cookie_minutes'  => 15,
                'title'           => 'Xác minh độ tuổi',
                'message'         => 'Duvin cung cấp thông tin về sản phẩm rượu vang dành cho người trên 18 tuổi. Vui lòng xác nhận bạn đủ 18 tuổi để tiếp tục.',
                'confirm_label'   => 'Tôi đủ 18 tuổi',
                'deny_label'      => 'Tôi chưa đủ 18 tuổi',
            ],
            'contact' => [
                'hotline'       => '+84589598386',
                'zalo_oa'       => 'https://zalo.me/0589598386',
                'zalo_expert'   => 'https://zalo.me/0589598386',
                'messenger'      => 'https://www.facebook.com/DuVinVN/',
            ],
        ];
    }
}
