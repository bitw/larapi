
# Quickly create a Laravel project API Backend.

## Laravel version 10.x

## Установка \ Setup:
1. Объявить локальный домен
   ```
   sudo echo -e "\n127.0.0.1 <имя_домена>\n" >> /etc/hosts
   ```
2. Настроить сертификат
   ```
   ./docker/nginx/cert.sh
   ```
3. Скопировать .env файл
   ```
   cp .env.example .env
   ```
4. Запустить проект
   ```
   make up
   ```
## Команды Makefile \ Makefile commands

- Init
  ```
  make up
  ```

- Down
  ```
  make down
  ```

- Консоль php:
  ```
  make bash
  make console
  ```
- Отчет по покрытию тестами (с открытием в хроме)
  ```
  make coverage-show
  ```
- Отчет по покрытию тестами (только регенерация)
  ```
  make coverage
  ```
и добавляются в процессе разработки