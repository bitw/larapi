#!/usr/bin/env bash

set -e

# ssl.conf
echo "[ req ]
default_bits        = 4096
distinguished_name  = req_distinguished_name
req_extensions      = req_ext

[ req_distinguished_name ]
countryName                 = IL
countryName_default         = GB
stateOrProvinceName         = Center
stateOrProvinceName_default = England
localityName                = Tel Aviv
localityName_default        = Bringhton
organizationName            = CA
organizationName_default    = Hallmarkdesign
organizationalUnitName      = BlazeMeter
commonName                  = local.dev
commonName_max              = 64
commonName_default          = local.dev

[ req_ext ]
subjectAltName = @alt_names
basicConstraints = CA:TRUE
subjectKeyIdentifier = hash

[ alt_names ]
DNS.1 = *.local.dev
" >> ssl.conf

if [ ! -f cert.pem ]; then
    openssl genrsa -out key.pem 4096
    openssl req -new -sha256 -out ca.csr -key key.pem -config ssl.conf
    openssl x509 -req -days 365 -in ca.csr -signkey key.pem -out cert.pem -extensions req_ext -extfile ssl.conf
fi

certutil -d sql:$HOME/.pki/nssdb -D -n "DEV" 2>/dev/null
certutil -d sql:$HOME/.pki/nssdb -A -t "CT,C,C" -n "DEV" -i './cert.pem'
