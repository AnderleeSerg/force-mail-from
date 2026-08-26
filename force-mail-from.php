<?php
/**
 * Plugin Name: Force Mail From
 * Description: Stops Hosting Ukraine “Invalid From” blocks. WordPress sends from a mailbox on the site domain.
 *
 * Full guide (EN / UK / RU): https://github.com/AnderleeSerg/force-mail-from
 *
 * --- English (4 steps) ---
 * 1. Create a mailbox on the site domain, e.g. admin@mysite.com
 * 2. My sites → site → Settings → Outgoing mail → choose that mailbox → Save
 * 3. Copy this file to:  wp-content/mu-plugins/force-mail-from.php
 *    Create the mu-plugins folder if needed. Do not activate it under Plugins.
 * 4. Change the line FORCE_MAIL_USER only if the mailbox is not admin@
 *    info@mysite.com → define( 'FORCE_MAIL_USER', 'info' );
 *
 * --- Українська (4 кроки) ---
 * 1. Створіть скриньку на домені сайта, напр. admin@mysite.com
 * 2. Мої сайти → сайт → Налаштування → Вихідна пошта → оберіть скриньку → Зберегти
 * 3. Скопіюйте цей файл у:  wp-content/mu-plugins/force-mail-from.php
 *    Теку mu-plugins створіть, якщо її немає. У «Плагіни» активувати не треба.
 * 4. Рядок FORCE_MAIL_USER змінюйте, лише якщо скринька не admin@
 *    info@mysite.com → define( 'FORCE_MAIL_USER', 'info' );
 *
 * --- Русский (4 шага) ---
 * 1. Создайте ящик на домене сайта, напр. admin@mysite.com
 * 2. Мои сайты → сайт → Настройки → Исходящая почта → выберите ящик → Сохранить
 * 3. Скопируйте этот файл в:  wp-content/mu-plugins/force-mail-from.php
 *    Папку mu-plugins создайте, если её нет. В «Плагины» активировать не нужно.
 * 4. Строку FORCE_MAIL_USER меняйте, только если ящик не admin@
 *    info@mysite.com → define( 'FORCE_MAIL_USER', 'info' );
 *
 * Wiki: https://www.ukraine.com.ua/wiki/mail/issues/invalid-from/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'FORCE_MAIL_USER' ) ) {
    define( 'FORCE_MAIL_USER', 'admin' ); // change only if mailbox is not admin@
}

/*
 * Extra map — only if the mailbox is NOT prefix@this-site-domain.
 *
 * $GLOBALS['FORCE_MAIL_MAP'] = array(
 *     'shop.com' => 'sales@shop.com',
 *     'old.com'  => 'admin@main.com',
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

    if ( $phpmailer->From && stripos( $phpmailer->From, '@' . $domain ) === false ) {
        $reply_name = $phpmailer->FromName ? $phpmailer->FromName : get_bloginfo( 'name' );
        $phpmailer->addReplyTo( $phpmailer->From, $reply_name );
    }

    $phpmailer->From     = $force;
    $phpmailer->FromName = get_bloginfo( 'name' );
    $phpmailer->Sender   = $force;
} );
