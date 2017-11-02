Делал на **php 7.1**.

Для Firefox можно использовать такой плагин https://addons.mozilla.org/ru/firefox/addon/rested/

Установка
1. в файле env прописать подключение к БД.
2. запустить миграцию
	php artisan migrate:refresh --seed 

3. Запустить на каком-нибудь сервере...