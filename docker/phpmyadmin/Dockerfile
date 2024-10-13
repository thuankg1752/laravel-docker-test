FROM phpmyadmin/phpmyadmin:latest


ENV PMA_ARBITRARY=1 \
    PMA_HOST=db \
    PMA_PORT=3306

RUN apt-get update && apt-get install -y \
    nginx \
    && rm -rf /var/lib/apt/lists/* \
COPY ../nginx/nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

COPY --from=phpmyadmin/phpmyadmin:latest /var/www/html /var/www/html

CMD ["nginx", "-g", "daemon off;"]
