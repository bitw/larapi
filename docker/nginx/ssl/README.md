# Генерация самоподписанного сертификата

## Содержание

- [NSSDB](#nssdb)
- [Создание сертификата](#--)
  - [1. Создание приватного ключа](#1---)
  - [2. Создание сертификата](#2--)
  - [3. Создание csr-файла](#3--csr-)
  - [4. Создание файла v3.ext](#4---v3ext)
  - [5. Создание сертификата](#5--)
- [Настройка Firefox](#-firefox)

## NSSDB
1. Устанавливаем NSSDB
```
sudo apt install libnss3-tools libnss3-dev
```
2. Создаем БД сертификатов
```
mkdir $HOME/.pki/nssdb
certutil -d sql:$HOME/.pki/nssdb -D -n "HOME" 2>/dev/null
```
3. Как добавить сертификат в БД?
```
certutil -d sql:$HOME/.pki/nssdb -A -t "CT,C,C" -n "HOME" -i ${PATH_TO_CERT}
```
4. Как удалить старые сертификаты?
```
rm -rf $HOME/.pki/nssdb && mkdir -p $HOME/.pki/nssdb && certutil -N -d $HOME/.pki/nssdb --empty-password
```

## Создание сертификата

### 1. Создание приватного ключа

```
openssl genrsa -out local.dev.key 2048
```

### 2. Создание сертификата

```
openssl req -x509 -new -nodes -key local.dev.key -sha256 -days 1024 -out local.dev.pem
```

### 3. Создание csr-файла

(Certificate Signing Request) основанном на ключе.
```
openssl req -new -newkey rsa:2048 -sha256 -nodes -key local.dev.key -subj "/C=CA/ST=None/L=NB/O=None/CN=local.dev" -out local.dev.csr
```

### 4. Создание файла v3.ext 
```
authorityKeyIdentifier=keyid,issuer
basicConstraints=CA:FALSE
keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
subjectAltName = @alt_names

[alt_names]
DNS.1 = local.dev
DNS.2 = *.local.dev
```

### 5. Создание сертификата

```
openssl x509 -req -in local.dev.csr -CA local.dev.pem -CAkey local.dev.key -CAcreateserial -out device.crt -days 365 -sha256 -extfile /tmp/__v3.ext
```

# Настройка Firefox

1. `Настройки` > `Приватность и защита` > `Сертификаты` > `Просмотр сертификатов` > `Серверы` > `Добавить исключение`
2. Вводим адрес `https://lta.local.dev` и ставим галку `Постоянно хранить это исключение`
3. Подтверждаем исохраняем
4. Идем в `about:config`, вводим в поиске: `network.stricttransportsecurity.preloadlist` и ставим в `false`
5. Перезапускаем браузер
6. Переходим на https://lta.local.dev
