Что использовал:
1) Python 2.7 

	easy_install mysql-python
	easy_install flask

2) PHP 5.4.19 (cli) (built: Aug 21 2013 01:12:03)

Python API по умолчанию поднимается на 5000 порту.
Установка и запуск:

1) Устанавливаем sql/domru.sql
2) Настраиваем конфиг подключения к mysql. pythonserver/server.py

3) Устанавливаем php приложение, коприруя все файлы из директории phpclient на веб сервер apache.

4) Настраивает apache:

	 # Устанавливаем корневой директорией "basic/web"
	 DocumentRoot "path/to/basic/web"

	<Directory "path/to/basic/web">
  	  RewriteEngine on

   	 # Если запрашиваемая в URL директория или файл существуют обращаемся к ним напрямую
   	 RewriteCond %{REQUEST_FILENAME} !-f
   	 RewriteCond %{REQUEST_FILENAME} !-d
   	 # Если нет - перенаправляем запрос на index.php
   	 RewriteRule . index.php
	
   	 # ...прочие настройки...
	</Directory>

5) Комментируем 2 строки в файле phpclient\basic\web\index.php

	defined('YII_DEBUG') or define('YII_DEBUG', true);

	defined('YII_ENV') or define('YII_ENV', 'dev');

6) Настраиваем подключение в python серверу. phpclient\basic\config\web.php

	'urlApi'=> 'http://127.0.0.1:5000', //Путь до API сервера

7) Запускаем приложение.