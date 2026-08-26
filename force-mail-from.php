<?php
/**
 * Plugin Name: Force Mail From
 * Description: WordPress всегда отправляет письма от ящика домена сайта.
 *              Нужен на Hosting Ukraine (ukraine.com.ua / adm.tools) и похожих
 *              хостингах с ошибкой «Некорректный заголовок From» / Invalid From.
 *
 * УСТАНОВКА
 *   Скопируйте этот файл в:
 *     wp-content/mu-plugins/force-mail-from.php
 *   Папку mu-plugins создайте, если её нет.
 *   Плагин подхватится сам — активировать в админке не нужно.
 *   Если сайтов несколько — положите ОДИН И ТОТ ЖЕ файл на каждый WordPress.
 *
 * ЧТО ПОМЕНЯТЬ В ЭТОМ ФАЙЛЕ
 *   1) FORCE_MAIL_USER — локальная часть ящика по умолчанию.
 *      'admin'  → письма от admin@ваш-домен.com
 *      'info'   → письма от info@ваш-домен.com
 *      'noreply'→ письма от noreply@ваш-домен.com
 *
 *   2) FORCE_MAIL_MAP — только исключения, когда ящик НЕ равен
 *      FORCE_MAIL_USER@домен-сайта (info@, office@, чужой домен и т.п.).
 *      Если все ящики вида admin@домен — карту оставьте пустой.
 *
 * В ПАНЕЛИ ХОСТИНГА (обязательно, иначе правило From снова не выполнится)
 *   1. Почта → создать ящик на том же домене, что и сайт.
 *   2. Мои сайты → сайт → Настройки → «Исходящая почта» → выбрать этот ящик.
 *   Ящик в панели и адрес в этом файле должны совпадать.
 *
 * Wiki хостинга:
 *   https://www.ukraine.com.ua/wiki/mail/issues/invalid-from/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'FORCE_MAIL_USER' ) ) {
    define( 'FORCE_MAIL_USER', 'admin' ); // ← при необходимости замените
}

/*
 * Исключения: 'домен-сайта-без-www' => 'полный@ящик'.
 * Примеры (раскомментируйте и подставьте свои):
 *
 * $GLOBALS['FORCE_MAIL_MAP'] = array(
 *     'example.com'     => 'info@example.com',
 *     'shop.example.com'=> 'sales@example.com',
 *     'old-site.com'    => 'admin@main-site.com', // нет своего ящика
 * );
 */
$GLOBALS['FORCE_MAIL_MAP'] = isset( $GLOBALS['FORCE_MAIL_MAP'] ) ? $GLOBALS['FORCE_MAIL_MAP'] : array();

add_action( 'phpmailer_init', function ( $phpmailer ) {

    $domain = parse_url( home_url(), PHP_URL_HOST );
    $domain = strtolower( preg_replace( '#^www\.#', '', (string) $domain ) );

    if ( ! empty( $GLOBALS['FORCE_MAIL_MAP'][ $domain ] ) ) {
        $force = $GLOBALS['FORCE_MAIL_MAP'][ $domain ];
    } else {
        $force = FORCE_MAIL_USER . '@' . $domain;
    }

    // Чужой From (Gmail посетителя и т.п.) сохраняем как Reply-To.
    if ( $phpmailer->From && stripos( $phpmailer->From, '@' . $domain ) === false ) {
        $reply_name = $phpmailer->FromName ? $phpmailer->FromName : get_bloginfo( 'name' );
        $phpmailer->addReplyTo( $phpmailer->From, $reply_name );
    }

    $phpmailer->From     = $force;
    $phpmailer->FromName = get_bloginfo( 'name' );
    $phpmailer->Sender   = $force;
} );
