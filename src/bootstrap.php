<?php
// src/bootstrap.php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

// Функція екранування HTML
function e(?string $s): string
{
    return htmlspecialchars($s ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Функції для роботи з flash повідомленнями
function set_flash(string $t, string $m): void
{
    $_SESSION['flash'][] = ['type' => $t, 'msg' => $m];
}

function get_flash(): array
{
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

// CSRF захист
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_check(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['_token'] ?? '';
        if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
            http_response_code(403);
            exit('CSRF validation failed.');
        }
    }
}
```[cite: 8]

Після збереження цього файлу ви зможете підключати його на інших сторінках за допомогою `require_once __DIR__ . '/../src/bootstrap.php';`[cite: 8, 11], що забезпечить роботу сесій, завантаження змінних середовища з `.env` та захист форм.