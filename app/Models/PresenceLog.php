<?php
namespace PresenceEngine\Models;

use PresenceEngine\Core\Model;

class PresenceLog extends Model
{
    protected string $table = 'presence_logs';

    public function markOnline(int $userId, ?string $section, ?string $ip): int
    {
        return $this->insert(
            "INSERT INTO presence_logs (user_id, section, login_time, is_online, ip_address) 
             VALUES (?, ?, NOW(), 1, ?)",
            [$userId, $section, $ip]
        );
    }

    public function markOffline(int $userId): void
    {
        $this->query(
            "UPDATE presence_logs 
             SET is_online = 0, logout_time = NOW() 
             WHERE user_id = ? AND is_online = 1",
            [$userId]
        );
    }

    public function getById(int $id): ?array
    {
        return $this->fetch("SELECT * FROM presence_logs WHERE id = ?", [$id]);
    }

    public function getOnline(): array
    {
        return $this->fetchAll(
            "SELECT p.id as log_id, p.user_id, u.username, p.section, 
                    p.login_time, p.ip_address
             FROM presence_logs p
             JOIN users u ON u.id = p.user_id
             WHERE p.is_online = 1
             ORDER BY p.login_time ASC"
        );
    }

    public function getHistory(int $limit = 100): array
    {
        return $this->fetchAll(
            "SELECT p.id, u.username, p.section, p.login_time, p.logout_time, p.is_online
             FROM presence_logs p
             JOIN users u ON u.id = p.user_id
             ORDER BY p.login_time DESC
             LIMIT " . (int) $limit
        );
    }

    public function closeAllOnline(): void
    {
        $this->query(
            "UPDATE presence_logs SET is_online = 0, logout_time = NOW() WHERE is_online = 1"
        );
    }

    public function countOnline(): int
    {
        return (int) $this->query(
            "SELECT COUNT(*) FROM presence_logs WHERE is_online = 1"
        )->fetchColumn();
    }

    public function countOnlineBySection(string $section): int
    {
        return (int) $this->query(
            "SELECT COUNT(*) FROM presence_logs WHERE is_online = 1 AND section = ?",
            [$section]
        )->fetchColumn();
    }

    public function getMaxLogId(): int
    {
        $row = $this->fetch("SELECT MAX(id) as max_id FROM presence_logs");
        return (int) ($row['max_id'] ?? 0);
    }

    public function getNewLogs(int $lastId): array
    {
        return $this->fetchAll(
            "SELECT p.id as log_id, p.user_id, u.username, p.section, 
                    p.login_time, p.ip_address, p.is_online, p.logout_time
            FROM presence_logs p
            JOIN users u ON u.id = p.user_id
            WHERE p.id > ?
            ORDER BY p.id ASC",
            [$lastId]
        );
    }
}