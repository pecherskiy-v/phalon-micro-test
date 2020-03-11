# phalon-micro-test

# директория nginx
    
    - настроки web сервера

# директория Site - микросервис 

# директория User - микросервис

# строка дла шторма - переменные окружения для запуска докер контейнеров
COMPOSE_PROJECT_NAME=phalkon-micto;nginx_port_on_host=80;nginx_port_on_host_site=8081;nginx_port_on_host_user=8082;nginx_local_hostname_site=site.local;nginx_local_hostname_user=user.local;

# .env.example - переменные окружения для запуска докер контейнеров

# phpcs.xml - настроки проверик стиля кодирования