# Busarev Roman's diploma
## Initialization
1) Скопіюйте файл `.env.example` в `.env` та відредагуйте його як потрібно
2) Скопіюйте файл `main/.env.example` в `main/.env` та відредагуйте його як потрібно
3) Запустіть команду `docker-composeu up --build -d`
4) Запустіть команду `docker-compose exec php-fpm php artisan migrate --seed`
5) Запустіть команду `docker-compose exec php-fpm npm run prod`
6) Проект запущено