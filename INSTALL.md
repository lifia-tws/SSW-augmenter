1) Add a new virtual host

ServerName localhost

<VirtualHost *:80>
    Header set Access-Control-Allow-Origin "*"
    Header set Access-Control-Allow-Headers "origin, x-requested-with, content-type"
    Header set Access-Control-Allow-Methods "PUT, GET, POST, DELETE, OPTIONS"

    DocumentRoot /var/www/ssw2014/web
    DirectoryIndex app.php

    <Directory "/var/www/ssw2014/web">
        AllowOverride All
        Order allow,deny
        Allow from All
    </Directory>

    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
</VirtualHost>

1b) Enabled headers module (to avoid CORS)

a2enmod headers
service apache2 restart

2) 

Permissions

chown -R www-data ssw2014/
chmod -R 777 ssw2014/

3)



http://www.ens.ro/2012/03/27/symfony2-jobeet-day-3-the-data-model/

php app/console doctrine:database:create
php app/console doctrine:generate:entities dvSSW2014Bundle
php app/console doctrine:schema:update --force
php app/console doctrine:generate:crud --entity=EnsJobeetBundle:Job --route-prefix=ens_job --with-write --format=yml
php app/console cache:clear
