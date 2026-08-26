# Force Mail From

**[English](README.md)** · **[Українська](README.uk.md)** · **[Русский](README.ru.md)**

[![Support / Donate](https://img.shields.io/badge/Support%20%2F%20Donate-Monobank-e11d48)](https://send.monobank.ua/jar/2Y8epr7u5T)

## What this is

Hosting Ukraine sometimes emails you that a letter from the site was **blocked**: “Invalid From header”.

That happens when WordPress sends mail as Gmail (or another foreign address). The host only allows a mailbox that exists **on your hosting**, on the **same domain as the site**.

This file makes WordPress send from that mailbox. The plugin is free.

Hosting wiki: https://www.ukraine.com.ua/wiki/mail/issues/invalid-from/

## What to do (4 steps)

### 1. Create a mailbox

In the hosting panel ([adm.tools](https://adm.tools/)): **Mail → Mailboxes → create**.

Example: if the site is `mysite.com`, create `admin@mysite.com`.  
Write down the password. You do not have to read this mailbox every day — it is needed so the host **allows sending**.

### 2. Turn on sending for the site

**Hosting → My sites → your site → Settings.**

Find **Outgoing mail**, pick the mailbox from step 1, click **Save**.

Without this step the file will not help.

### 3. Put the file on the site

Download [`force-mail-from.php`](force-mail-from.php) (or **Code → Download ZIP**).

On the server, in the site files, open `wp-content`.  
If there is no folder `mu-plugins` — create it.  
Put the file here:

```text
wp-content/mu-plugins/force-mail-from.php
```

Do not look for it under “Plugins” in WordPress. This kind of file turns on by itself.

If you have several WordPress sites — copy the **same** file to each of them.

### 4. Only if the mailbox is not admin@

Open the file in a text editor. Find this line:

```php
define( 'FORCE_MAIL_USER', 'admin' );
```

If the mailbox is `info@mysite.com` — replace `admin` with `info`.  
If it is `admin@mysite.com` — change nothing.

## How to know it worked

Send any test from the site (a form, “forgot password”).  
The sender should be `admin@your-domain`, not Gmail.  
The next day the host should not email you about a bad From header.

## Support / Donate

If this helped, you can say thanks:

**[Support / Donate (Monobank)](https://send.monobank.ua/jar/2Y8epr7u5T)**

## License

MIT.
