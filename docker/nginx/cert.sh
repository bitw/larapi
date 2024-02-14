#!/usr/bin/env bash

. .env

# generate cert
if [ ! -f docker/nginx/ssl/cert.pem ]; then
    cd docker/nginx/ssl
    ./generate.sh
    cd ../../..
fi

# Install ssl certificate (*.local.dev) on host..
if [[ "$(command -v certutil > /dev/null; echo $? >&1)" == "1" ]]; then
  echo "Attempt install nss (certutil) to host:"
  sudo apt-get install libnss3-tools libnss3-dev
fi

if [ ! -d $HOME/.pki/nssdb ]; then
  mkdir -p $HOME/.pki/nssdb
fi

certutil -d sql:$HOME/.pki/nssdb -D -n "HOME" 2>/dev/null
certutil -d sql:$HOME/.pki/nssdb -A -t "CT,C,C" -n "HOME" -i ./docker/nginx/ssl/cert.pem
