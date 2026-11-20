<?php

declare(strict_types=1);

/**
 * ApiController — Xử lý API đồng bộ 1 chiều từ Google Sheets (`POST /api/admin/sheet-sync`).
 *
 * Bảo mật:
 *   - Xác thực bằng `GATEWAY_SECRET_KEY` qua header `X-Gateway-Key` (hoặc `Authorization: Bearer <key>`).
 *   - Sử dụng `hash_equals()` để chống timing attack.
 */
final class ApiController extends BaseController
{
    public function __construct(
        private GoogleSheetImportService $importer = new GoogleSheetImportService()
    ) {
    }

    /**
     * Endpoint: POST /api/admin/sheet-sync
     */
    public function sheetSync(): void
    {
        $request = Request::createFromGlobals();
        $payload = $request->json();
        if (!is_array($payload)) {
            $payload = [];
        }

        $providedKey = $this->extractGatewayKey($payload);
        $result = $this->processSheetSync($payload, $providedKey);
        $this->json($result['body'], $result['status']);
    }

    /**
     * Xử lý logic xác thực & đồng bộ (tách riêng để gọi trực tiếp trong Integration Test mà không bị exit()).
     *
     * @param array<string, mixed> $payload
     * @return array{status: int, body: array<string, mixed>}
     */
    public function processSheetSync(array $payload, ?string $providedKey): array
    {
        $expectedKey = trim((string) Config::get('GATEWAY_SECRET_KEY', ''));
        if ($expectedKey === '') {
            return [
                'status' => 500,
                'body'   => [
                    'ok'      => false,
                    'error'   => 'Server configuration error: GATEWAY_SECRET_KEY is not configured.',
                ],
            ];
        }

        $candidateKey = trim((string) $providedKey);
        if ($candidateKey === '' || !hash_equals($expectedKey, $candidateKey)) {
            return [
                'status' => 401,
                'body'   => [
                    'ok'      => false,
                    'error'   => 'Unauthorized: Invalid or missing X-Gateway-Key.',
                ],
            ];
        }

        $syncResult = $this->importer->syncBatch($payload);
        $httpStatus = ($syncResult['ok'] ?? false) === true ? 200 : 422;

        return [
            'status' => $httpStatus,
            'body'   => $syncResult,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function extractGatewayKey(array $payload): string
    {
        if (!empty($_SERVER['HTTP_X_GATEWAY_KEY'])) {
            return (string) $_SERVER['HTTP_X_GATEWAY_KEY'];
        }

        $auth = (string) ($_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '');
        if (preg_match('/^Bearer\s+(.+)$/i', trim($auth), $m)) {
            return trim($m[1]);
        }

        if (!empty($payload['gateway_secret_key']) && is_string($payload['gateway_secret_key'])) {
            return $payload['gateway_secret_key'];
        }

        return '';
    }
}

