#!/bin/bash

read -p 'Site: ' site
echo $site

read -p 'Quantidade: ' quantidade
echo $quantidade

curl -N http://loripsum.net/api/5 | wp post generate --post_content --count=$quantidade --url=$site