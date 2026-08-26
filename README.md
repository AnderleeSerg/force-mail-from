# Force Mail From

**[English](README.md)** · **[Українська](README.uk.md)** · **[Русский](README.ru.md)**

[![Support / Donate](https://img.shields.io/badge/Support%20%2F%20Donate-Monobank-e11d48)](https://send.monobank.ua/jar/2Y8epr7u5T)

**A WordPress plugin that stops hosting emails about an “Invalid From” / incorrect From header.**

If you use [Hosting Ukraine](https://www.ukraine.com.ua/) (panel: [adm.tools](https://adm.tools/)) and keep getting notices that outgoing mail from your site was **blocked** because of a bad `From` header — this file is for that.

Typical hosting message:

> Outgoing message blocked  
> Invalid From header  
> Некорректный заголовок From

WordPress, WooCommerce, Contact Form 7, or a security plugin often send mail as `you@gmail.com` or as a non-existent `wordpress@yoursite.com`. The host rejects that: the sender must be a **mailbox that actually exists on the same hosting account**.

This plugin forces WordPress to send from a mailbox on the site’s own domain. If a contact form used a visitor’s Gmail address, it is moved to **Reply-To**, so you can still reply.

Hosting wiki: [Invalid From header](https://www.ukraine.com.ua/wiki/mail/issues/invalid-from/)

## Download

- Plugin file: [`force-mail-from.php`](force-mail-from.php)
- Or the green **Code → Download ZIP** button

## Who it is for

- WordPress on Hosting Ukraine and similar hosts with the same `From` rule
- Several sites on one account — the same file on every WordPress install

**You do not need it** if mail already goes out through external SMTP (WP Mail SMTP + Gmail, SendPulse, etc.).  
**It will not help** OpenCart or custom PHP — WordPress only.

## Install

1. Create a mailbox on the site domain, e.g. `admin@your-site.com`.
2. **My sites → the site → Settings → “Outgoing mail”** — select that mailbox and save.
3. Copy `force-mail-from.php` to:

   ```text
   wp-content/mu-plugins/force-mail-from.php
   ```

   Create the `mu-plugins` folder if it is missing.  
   You do not activate anything under “Plugins”: mu-plugins load automatically.

4. If the mailbox is not `admin@domain`, change one line in the file:

   ```php
   define( 'FORCE_MAIL_USER', 'admin' );
   ```

   `info` → mail from `info@your-site.com`. The domain is taken from WordPress.

## Several sites and exceptions

One file for all sites: `admin` on `a.com` becomes `admin@a.com`, on `b.com` — `admin@b.com`.

If the mailbox name is different (`info@`, `sales@`) or a site has no mailbox of its own, fill in the map:

```php
$GLOBALS['FORCE_MAIL_MAP'] = array(
    'shop.com' => 'sales@shop.com',
    'old.com'  => 'admin@main.com',
);
```

The mailbox in the panel and the address in the file must match. Otherwise the host will block the message again.

## How to check

1. Send a test email (a form, “forgot password”, a security report).
2. The sender should be `you@your-domain`, not Gmail.
3. The next day you should not get a hosting notice about an invalid `From`.

## Support / Donate

The plugin is free. If it stopped the Invalid From emails, you can say thanks via a Monobank jar:

**[Support / Donate](https://send.monobank.ua/jar/2Y8epr7u5T)**

## License

MIT — you may copy, change, and share it.
