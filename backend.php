<?php
/**
 * backend.php — «бэкенд» трекинга переходов.
 *
 * Что делает:
 *  1. Ловит клики по кнопкам сайта (ссылки вида /?offer=Keiser&sub1=...),
 *     сохраняет данные клика в таблицу wp_keiser_clicks и делает
 *     302-редирект на официальный сайт.
 *  2. Отдаёт список сохранённых кликов в JSON по адресу /clicks.
 */

// Хук init срабатывает при КАЖДОЙ загрузке WordPress — самый ранний этап,
// где можно перехватить запрос до вывода любой страницы.
add_action('init', 'keiser_handle_backend');

function keiser_handle_backend() {
    $uri = $_SERVER['REQUEST_URI'];
    
    // Если в URL есть ?offer=... — это переход по кнопке: фиксируем клик
    // и сразу завершаемся (страница сайта не открывается).
    if (isset($_GET['offer']) && !empty($_GET['offer'])) {
        keiser_handle_click();
        exit;
    }
    
    // Если запрос к /clicks (или ?action=clicks) — отдаём список кликов в JSON.
    if (strpos($uri, '/clicks') !== false || isset($_GET['action']) && $_GET['action'] === 'clicks') {
        keiser_handle_clicks();
        exit;
    }
}

// Создаёт таблицу кликов в БД, если её ещё нет (при первом обращении).
function keiser_ensure_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'keiser_clicks'; // например, wp_keiser_clicks
    
    // Проверяем наличие таблицы в базе
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        
        // Структура таблицы: один клик = одна запись
        $sql = "CREATE TABLE $table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            click_id VARCHAR(100) NOT NULL,
            offer VARCHAR(100) NOT NULL,
            sub1 VARCHAR(100) NOT NULL,
            timestamp DATETIME NOT NULL,
            ip VARCHAR(100) NOT NULL,
            user_agent TEXT NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql); // штатная функция WP для создания/обновления таблиц
    }
}

// Обработчик клика: сохраняет данные в БД и перенаправляет на сайт оффера.
function keiser_handle_click() {
    // Гарантируем, что таблица существует, перед записью
    keiser_ensure_table();
    
    // Очищаем входные параметры от лишнего (защита от инъекций)
    $offer = isset($_GET['offer']) ? sanitize_text_field($_GET['offer']) : ''; // название оффера
    $sub1  = isset($_GET['sub1']) ? sanitize_text_field($_GET['sub1']) : '';   // метка кнопки (откуда клик)
    
    // Генерируем уникальный ID клика вида click_1789135928_52129
    $click_id = 'click_' . time() . '_' . wp_rand(10000, 99999);
    
    // Текущее время в формате MySQL (с учётом часового пояса сайта)
    $timestamp = current_time('mysql');
    
    // IP-адрес посетителя
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Браузер/устройство посетителя
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    // Записываем клик в базу данных
    global $wpdb;
    $table_name = $wpdb->prefix . 'keiser_clicks';
    
    $wpdb->insert($table_name, array(
        'click_id' => $click_id,
        'offer' => $offer,
        'sub1' => $sub1,
        'timestamp' => $timestamp,
        'ip' => $ip,
        'user_agent' => $user_agent,
    ));
    
    // Адрес официального сайта — цель перехода.
    // Чтобы сменить цель перехода, меняем эту строку.
    $official_url = 'https://www.keiseruniversity.edu';
    
    // 302-редирект (временное перенаправление) и остановка выполнения
    header('Location: ' . $official_url, true, 302);
    exit;
}

// Обработчик списка кликов: возвращает все записи таблицы в формате JSON.
function keiser_handle_clicks() {
    // Гарантируем, что таблица существует
    keiser_ensure_table();
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'keiser_clicks';
    
    // Все клики, свежие сверху
    $clicks = $wpdb->get_results("SELECT * FROM $table_name ORDER BY timestamp DESC");
    
    header('Content-Type: application/json');
    echo json_encode($clicks);
    exit;
}
?>
