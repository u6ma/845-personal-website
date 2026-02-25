ADD TO NGINX.CONF
``location / {
try_files $uri $uri/ /index.php 
}``

CREATE A .ENV FILE

POPULATE WITH:
