FROM	alpine:3.7
RUN		set -x && \
		apk update && \
		apk upgrade && \
		apk add --update --no-cache \
		nginx \
		supervisor \
		bash \
		curl \
		php7 \
		php7-bcmath \
		php7-ctype \
		php7-curl \
		php7-dom \
		php7-fpm \
		php7-json \
		php7-mbstring \
		php7-mcrypt \
		php7-opcache \
		php7-openssl \
		php7-pdo \
		php7-pdo_sqlite \
		php7-pdo_mysql \
		php7-phar \
		php7-simplexml \
		php7-tokenizer \
		php7-xml \
		php7-xmlwriter \
		php7-zip \
		php7-zlib && \
		rm -rf /var/cache/apk/* && \
		mkdir -p /var/www/src
# copiando conteúdos
COPY	/src/               /var/www/src/
COPY    /config/machine/    /
WORKDIR	/var/www/src
# permissões finais e composer
RUN		chmod +x /start.sh && \
		chown -R nginx:nginx /var/www/src/ && \
		curl -sS https://getcomposer.org/installer | \
		php -- --install-dir=/usr/bin/ --filename=composer && \
		composer install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader
# Start Supervisord
CMD		["/start.sh"]