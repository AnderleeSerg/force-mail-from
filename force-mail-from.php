<?php
/**
 * Plugin Name: Force Mail From
 * Description: Fixes Hosting Ukraine “Invalid From”. WordPress sends from a mailbox on the site domain.
 *
 * Guide: https://github.com/AnderleeSerg/force-mail-from
 *
 * EN  1) Mail → Mailboxes → create admin@yoursite.com
 *     2) My sites → site → Settings → Outgoing mail → choose it → Save
 *     3) File manager: www / wp-content / mu-plugins / upload this file
 *        (create mu-plugins if missing). Do not activate under Plugins.
 *     4) Edit this file only if the mailbox is not admin@
 *
 * UK  1) Пошта → Скриньки → створіть admin@yoursite.com
 *     2) Мої сайти → сайт → Налаштування → Вихідна пошта → оберіть → Зберегти
 *     3) Файл-менеджер: www / wp-content / mu-plugins / завантажте цей файл
 *        (теку mu-plugins створіть, якщо немає). У «Плагіни» не активувати.
 *     4) Файл відкривайте, лише якщо скринька не admin@
 *
 * RU  1) Почта → Ящики → создайте admin@yoursite.com
 *     2) Мои сайты → сайт → Настройки → Исходящая почта → выберите → Сохранить
 *     3) Файл-менеджер: www / wp-content / mu-plugins / загрузите этот файл
 *        (папку mu-plugins создайте, если нет). В «Плагины» не активировать.
 *     4) Файл открывайте, только если ящик не admin@
 *
 * If mailbox is info@... change admin to info on the next line.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'FORCE_MAIL_USER' ) ) {
    define( 'FORCE_MAIL_USER', 'admin' );
}

$GLOBALS['FORCE_MAIL_MAP'] = isset( $GLOBALS['FORCE_MAIL_MAP'] ) ? $GLOBALS['FORCE_MAIL_MAP'] : array();

add_action( 'phpmailer_init', function ( $phpmailer ) {

    $domain = parse_url( home_url(), PHP_URL_HOST );
    $domain = strtolower( preg_replace( '#^www\.#', '', (string) $domain ) );

    if ( ! empty( $GLOBALS['FORCE_MAIL_MAP'][ $domain ] ) ) {
        $force = $GLOBALS['FORCE_MAIL_MAP'][ $domain ];
    } else {
        $force = FORCE_MAIL_USER . '@' . $domain;
    }

    if ( $phpmailer->From && stripos( $phpmailer->From, '@' . $domain ) === false ) {
        $reply_name = $phpmailer->FromName ? $phpmailer->FromName : get_bloginfo( 'name' );
        $phpmailer->addReplyTo( $phpmailer->From, $reply_name );
    }

    $phpmailer->From     = $force;
    $phpmailer->FromName = get_bloginfo( 'name' );
    $phpmailer->Sender   = $force;
} );
