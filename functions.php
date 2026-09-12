<?php
/**
 * functions.php — главный файл настроек темы Keiser.
 *
 * Здесь подключаются остальные файлы темы, регистрируются
 * стили и скрипты, включается поддержка возможностей WordPress
 * и настраивается загрузка изображений (SVG и WebP).
 */

// Подключение файла бэкенда: обработчик переходов по кнопкам,
// запись кликов в базу данных и редирект на официальный сайт.
require_once get_template_directory() . '/backend.php';

// Подключение стилей и скриптов темы (срабатывает при выводе <head>).
add_action( 'wp_enqueue_scripts', function(){

  // Основной CSS-файл темы
  wp_enqueue_style( 'keiser-style', get_template_directory_uri() .'/assets/css/style.css');

  // jQuery: убираем встроенную копию WP и подключаем свежую версию с CDN Google
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
  wp_enqueue_script( 'jquery' );

  // Основной JS-файл темы (зависит от jQuery, выводится в футере — параметр true)
  wp_enqueue_script( 'keiser-script', get_template_directory_uri() . '/assets/js/keiser.js', array('jquery'), '1.0', true );
});

// Включаем поддержку возможностей WordPress:
add_theme_support('post-thumbnails'); // миниатюры записей
add_theme_support('title-tag');       // тег <title> управляется WP
add_theme_support('custom-logo');     // пользовательский логотип

// ─── Поддержка формата SVG ───────────────────────────────────────────
// Разрешаем загрузку SVG через медиабиблиотеку (только для админов).
add_filter('upload_mimes', 'keiser_svg_upload_allow');

function keiser_svg_upload_allow($mimes) {
    $mimes['svg'] = 'image/svg+xml'; // добавляем SVG в список разрешённых MIME-типов
    return $mimes;
}

// Исправляем проверку MIME-типа SVG (нужно на старых версиях WordPress до 5.1).
add_filter('wp_check_filetype_and_ext', 'keiser_fix_svg_mime_type', 10, 5);

function keiser_fix_svg_mime_type($data, $file, $filename, $mimes, $real_mime = '') {
    if (version_compare($GLOBALS['wp_version'], '5.1.0', '>=')) {
        // WP 5.1+: определяем SVG по реальному MIME-типу файла
        $dosvg = in_array($real_mime, ['image/svg', 'image/svg+xml']);
    } else {
        // Старые версии: определяем по расширению имени файла
        $dosvg = ('.svg' === strtolower(substr($filename, -4)));
    }
    
    if ($dosvg) {
        if (current_user_can('manage_options')) {
            // Админам разрешаем: подтверждаем расширение и тип
            $data['ext'] = 'svg';
            $data['type'] = 'image/svg+xml';
        } else {
            // Обнуляем и расширение, и MIME-тип, чтобы запретить загрузку SVG не-админам.
            // Ранее здесь была опечатка ($type_and_ext вместо $data):
            $data['ext'] = $data['type'] = false;
        }
    }

    return $data;
}

// ─── Поддержка формата WebP ──────────────────────────────────────────
// Разрешаем загрузку WebP для всех пользователей с правом upload_files.
// Используется только upload_mimes: WordPress 5.8+ сам корректно
// определяет MIME-тип WebP, дополнительные фильтры не нужны.
add_filter('upload_mimes', 'keiser_webp_upload_allow');

function keiser_webp_upload_allow($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}

/**
 * function_carbon.php — регистрация полей админки (Carbon Fields):
 * вкладки «Логотип», «Hero», «Программы», «Почему мы», «О нас»,
 * «Видео», «CTA», «Footer».
 */
require_once get_template_directory() . '/function_carbon.php';
?>
