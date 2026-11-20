<?php

declare(strict_types=1);

/**
 * ImportLogRepository — Quản lý lịch sử đồng bộ 1 chiều từ Google Sheets (bảng `import_logs`).
 */
final class ImportLogRepository extends BaseRepository
{
    public function startBatch(string $batchId, int $totalRows, string $triggeredBy = 'google_apps_script'): int
    {
        $this->query(
            "INSERT INTO import_logs (batch_id, total_rows, success_rows, error_rows, triggered_by, status)
             VALUES (:batch_id, :total_rows, 0, 0, :triggered_by, 'processing')",
            [
                'batch_id'     => $batchId,
                'total_rows'   => max(0, $totalRows),
                'triggered_by' => $triggeredBy,
            ]
        );
        return (int) $this->db()->lastInsertId();
    }

    /**
     * @param array<int, array<string, mixed>> $errorDetails
     */
    public function finishBatch(int $logId, int $successRows, int $errorRows, array $errorDetails = []): void
    {
        $status = $errorRows > 0 ? 'failed_with_errors' : 'success';
        $now = date('Y-m-d H:i:s');
        $this->query(
            "UPDATE import_logs
             SET success_rows = :success_rows,
                 error_rows = :error_rows,
                 error_details = :error_details,
                 status = :status,
                 completed_at = :completed_at
             WHERE id = :id",
            [
                'success_rows'  => max(0, $successRows),
                'error_rows'    => max(0, $errorRows),
                'error_details' => json_encode($errorDetails, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'status'        => $status,
                'completed_at'  => $now,
                'id'            => $logId,
            ]
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function recent(int $limit = 20): array
    {
        $limit = max(1, min(100, $limit));
        return $this->fetchAll(
            "SELECT id, batch_id, total_rows, success_rows, error_rows, error_details, triggered_by, status, started_at, completed_at
             FROM import_logs
             ORDER BY id DESC
             LIMIT {$limit}"
        );
    }
}

