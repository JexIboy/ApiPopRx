Import database from /api.poprx/data folder and name it to "poprx"

vhost file
<VirtualHost *:80>
	ServerName api.poprx.com
	DocumentRoot C:/xampp/htdocs/api.poprx/public
	<Directory C:/xampp/htdocs/api.poprx/public>
		DirectoryIndex index.php
		AllowOverride All
		Order allow,deny
		Allow from all
		<IfModule mod_authz_core.c>
		Require all granted
		</IfModule>
	</Directory>
</VirtualHost>

<VirtualHost *:80>
	ServerName app.poprx.com
	DocumentRoot C:/xampp/htdocs/app.poprx
	<Directory C:/xampp/htdocs/app.poprx>
		DirectoryIndex index.html
		AllowOverride All
		Order allow,deny
		Allow from all
		<IfModule mod_authz_core.c>
		Require all granted
		</IfModule>
	</Directory>
</VirtualHost>

Please use "app.poprx.dev" for you domain name to enable the facebook login feature
If you were going to test the sending of email please enable the less security feature in your google account
