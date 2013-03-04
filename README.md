A Better Symfony app.php
========================

After doing multiple Symfony projects, it was pretty clear that the default `app.php` and `app_dev.php` file setup didn't work very well for me. My dev sites are hosted on a VM, and I access them from my main desktop. This means my default I can't even access `app_dev.php`.

It also presented a problem going from `dev` to `prod` environments. Your `.htaccess` file can only point to one or the other. 

Instead, I came up with a single script which dynamically detects the environment via environmental variables. You can set these server wide like I do, or for specific sites via virtual host/per-directory configurations.

Setup
-----

Simply override `web/app.php` with mine, delete `web/app_dev.php`, ensure the `.htaccess` file or server config points to `web/app.php` and you're done. The script will default to a `prod` environment, so to override, set an environment variable `SYMFONY_ENV`.

Examples
--------

### Apache

Virtual host version:

```
<VirtualHost *:80>
    ServerName example.com
    ...
    SetEnv SYMFONY_ENV dev
</VirtualHost>
```

Global version (Put in your `httpd.conf` file):

```
SetEnv SYMFONY_ENV dev
```

### Nginx

```
server {
    server_name example.com;
    ...

    location ~ \.php$ {
        ...
        fastcgi_param SYMFONY_ENV dev;
        ...
    }
}
```