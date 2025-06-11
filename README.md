# Task Composer 🎯
__Трекер задач с командной работой!__
---
## Краткое описание
Task Composer - PHP проект реализованный с помощью фреймворка Laravel.  
__Фичи:__
- Командная работа над задачами
- Система комментариев
- Проект покрыт тестами
- Контейнеризация с помощью Docker
## Запуск проекта с помощью Docker
1. Клонируем проект из GitHub:
```
git clone https://github.com/yunya101/task-composer
```
2. Поднимаем контейнеры:
```
docker compose up -d
```
4. Запускаем миграции:
```
docker exec -it laravel-app php artisan migrate
```
После чего можно переходить в браузере по ссылке:
```
http://localhost:8080
```