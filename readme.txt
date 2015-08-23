Что использовал:
1) Python 2.7 

	easy_install mysql-python
	easy_install flask

2) PHP 5.4.19 (cli) (built: Aug 21 2013 01:12:03)

Python API по умолчанию поднимается на 5000 порту.
Установка и запуск:

1) Устанавливаем sql/domru.sql
2) Настраиваем конфиг подключения к mysql. pythonserver/server.py
3) Устанавливаем php приложение, копируя содержимое папки domru в папку htdocs
4) Настраиваем подключение к python api в файле index.php (new ScheduleAPI("http://127.0.0.1:5000"))
5) Запускаем питон скрипт server.py
6) Подключаемся к index.php