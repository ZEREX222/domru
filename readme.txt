��� �����������:
1) Python 2.7 

	easy_install mysql-python
	easy_install flask

2) PHP 5.4.19 (cli) (built: Aug 21 2013 01:12:03)

Python API �� ��������� ����������� �� 5000 �����.
��������� � ������:

1) ������������� sql/domru.sql
2) ����������� ������ ����������� � mysql. pythonserver/server.py

3) ������������� php ����������, �������� ��� ����� �� ���������� phpclient �� ��� ������ apache.

4) ����������� apache:

	 # ������������� �������� ����������� "basic/web"
	 DocumentRoot "path/to/basic/web"

	<Directory "path/to/basic/web">
  	  RewriteEngine on

   	 # ���� ������������� � URL ���������� ��� ���� ���������� ���������� � ��� ��������
   	 RewriteCond %{REQUEST_FILENAME} !-f
   	 RewriteCond %{REQUEST_FILENAME} !-d
   	 # ���� ��� - �������������� ������ �� index.php
   	 RewriteRule . index.php
	
   	 # ...������ ���������...
	</Directory>

5) ������������ 2 ������ � ����� phpclient\basic\web\index.php

	defined('YII_DEBUG') or define('YII_DEBUG', true);

	defined('YII_ENV') or define('YII_ENV', 'dev');

6) ����������� ����������� � python �������. phpclient\basic\config\web.php

	'urlApi'=> 'http://127.0.0.1:5000', //���� �� API �������

7) ��������� ����������.