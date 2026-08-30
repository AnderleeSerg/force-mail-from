# Force Mail From

**[English](README.md)** · **[Українська](README.uk.md)** · **[Русский](README.ru.md)**

[![Support / Donate](https://img.shields.io/badge/Support%20%2F%20Donate-Monobank-e11d48)](https://send.monobank.ua/jar/2Y8epr7u5T)

The host emailed you that a letter from the site was **blocked** (“Invalid From”).  
This free file fixes that for WordPress on [Hosting Ukraine](https://www.ukraine.com.ua/) ([adm.tools](https://adm.tools/)).

You do not need to be a programmer. Follow the three steps below.

## 1. Create a mailbox (if you do not have one yet)

In **adm.tools**: **Mail → Mailboxes → Create**.

Name it after the site, for example `admin@mysite.com` if the site is `mysite.com`.

Save the password. You do not have to read this mailbox every day. It exists so the host **allows sending**.

## 2. Tell the site to send from that mailbox

**Hosting → My sites → your site → Settings.**

Find **Outgoing mail**, choose `admin@mysite.com`, click **Save**.

If you skip this, the file will not help.

## 3. Upload the file

Download [`force-mail-from.php`](force-mail-from.php)  
(or the green button **Code → Download ZIP**, then take the `.php` file from the archive).

In **adm.tools** open **File manager**. Go to your site folder, then:

`www` → `wp-content`

If there is no folder `mu-plugins` — create it (**New folder**).  
Open `mu-plugins` and **upload** `force-mail-from.php` there.

The path must look like this:

```text
wp-content/mu-plugins/force-mail-from.php
```

Do not search for this file under **Plugins** in WordPress. It turns on by itself.

Several WordPress sites? Upload the **same** file the same way on each one.

## If your mailbox is not admin@

Only then open the file in Notepad. Find:

```php
define( 'FORCE_MAIL_USER', 'admin' );
```

If the mailbox is `info@mysite.com`, change `admin` to `info`.  
If it is already `admin@...` — change nothing.

## Not WordPress? Do not upload this file

This file works only on **WordPress**. It does nothing on OpenCart, Joomla, Prestashop, or a custom PHP site.

For those, do two things in the panel and in the CMS — **the same existing mailbox** in both places, not Gmail:

1. **adm.tools:** My sites → the site → Settings → **Outgoing mail** → choose e.g. `info@mysite.com` → Save.
2. **In the CMS** set the store / site email (the From address) to that **same** mailbox.

**OpenCart:** System → Settings → **General** (not the Mail tab) → field **E-Mail**.  
The Mail tab only chooses Mail vs SMTP. Put Gmail in a mailbox **forward**, not in From.

## Did it work?

Send a test from the site (a form or “forgot password”).  
The sender should be your site mailbox, not Gmail.  
The next day the host should not email you about a blocked From.

## Support / Donate

**[Monobank jar](https://send.monobank.ua/jar/2Y8epr7u5T)**

## License

MIT.
