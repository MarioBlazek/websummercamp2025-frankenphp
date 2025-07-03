#!/bin/bash
set -e

MARKER="/tmp/.init_done"

if [ ! -f "$MARKER" ]; then
    echo "[Entrypoint] Running one-time setup..."

    php bin/console cache:clear || true
    php bin/console doctrine:database:create --if-not-exists || true
    php bin/console doctrine:migrations:migrate --no-interaction || true

    touch "$MARKER"
else
    echo "[Entrypoint] Already initialized, skipping setup."
fi

# Continue with whatever CMD is defined (php-fpm)
exec "$@"
