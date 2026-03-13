FROM dunglas/frankenphp:php8.4
WORKDIR /api
# composerをインストール
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
# パッケージのインストールとキャッシュ削除
RUN apt-get update && \
  apt-get install -y zip unzip git rsync && \
  rm -rf /var/lib/apt/lists/* && \
  install-php-extensions pdo_mysql pcntl
# 依存関係ファイルのみコピーしてキャッシュを効かせる
COPY composer.json composer.lock ./
RUN composer install --no-scripts
# マウント外にコピー
RUN mv vendor /opt/vendor
COPY . .
# vendor同期用スクリプト作成
RUN printf '#!/bin/bash\n\
set -e\n\
[ ! -d /api/vendor ] || [ -z "$(ls -A /api/vendor 2>/dev/null)" ] && \
cp -r /opt/vendor /api/vendor || \
rsync -au --quiet /opt/vendor/ /api/vendor/\n\
exec "$@"\n' > /docker-entrypoint.sh && \
    chmod +x /docker-entrypoint.sh
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["php", "artisan", "octane:start", "--host", "0.0.0.0", "--port", "8000", "--watch"]
EXPOSE 8000
