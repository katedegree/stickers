FROM node:24-slim
WORKDIR /web
# パッケージのインストールとキャッシュ削除
RUN apt-get update && \
    apt-get install -y rsync && \
    rm -rf /var/lib/apt/lists/*
# 依存関係ファイルのみコピーしてキャッシュを効かせる
COPY package.json package-lock.json ./
RUN npm install
# マウント外にコピー
RUN mv node_modules /opt/node_modules
COPY . .
# node_modules同期用スクリプト作成
RUN printf '#!/bin/bash\n\
set -e\n\
[ ! -d /web/node_modules ] || [ -z "$(ls -A /web/node_modules 2>/dev/null)" ] && \
cp -r /opt/node_modules /web/node_modules || \
rsync -au --quiet /opt/node_modules/ /web/node_modules/\n\
exec "$@"\n' > /docker-entrypoint.sh && \
    chmod +x /docker-entrypoint.sh
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["npm", "run", "dev"]
EXPOSE 3000
