
# Quickly create a Laravel project.

## Laravel version 10.x

## Содержание \ Contents

1. [Установка](#--setup)
2. [Ссылки](#--links)
3. [Команды Makefile](#-makefile--makefile-commands)
4. [Настройка Firefox](#-firefox--firefox-setup)
5. [Тестовые сотрудники](#---test-employees)
6. [Как создать нового сотрудника?](#-----how-create-new-employee)

## Установка \ Setup:
1. Объявить локальный домен
   ```
   sudo echo -e "\n127.0.0.1 fast.laravel\n" >> /etc/hosts
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
