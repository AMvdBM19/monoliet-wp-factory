#!/bin/sh
# ${CLIENT_NAME} — Maintenance script
# Runs minor WP core updates with automatic rollback on failure.
set -e

CONTAINER="wp-${CLIENT_SLUG}"
WP="docker exec $CONTAINER wp --allow-root"
SITE_DIR="/opt/docker/clients/${CLIENT_SLUG}"

echo "==> Starting maintenance for ${CLIENT_NAME}..."

echo "==> Step 1: Pre-update backup..."
"$SITE_DIR/backup.sh"

echo "==> Step 2: Checking for minor core updates..."
UPDATE_AVAILABLE=$($WP core check-update --minor --format=count 2>/dev/null || echo "0")

if [ "$UPDATE_AVAILABLE" != "0" ]; then
    echo "    Minor update available. Applying..."
    $WP core update --minor

    echo "==> Step 3: Health check..."
    sleep 5
    HEALTH=$(docker exec "$CONTAINER" curl -sf http://localhost/wp-json/monoliet/v1/health 2>/dev/null || echo "FAIL")

    if echo "$HEALTH" | grep -q "wp_version"; then
        echo "==> Update successful."
    else
        echo "!!! Health check failed after update. Rolling back..."

        LATEST_BACKUP=$(ls -1t "$SITE_DIR/backups/"*.sql.gz 2>/dev/null | head -1)
        if [ -n "$LATEST_BACKUP" ]; then
            echo "    Restoring from: $(basename "$LATEST_BACKUP")"
            gunzip -c "$LATEST_BACKUP" | docker exec -i shared-mariadb mariadb \
                -u root -p"$(docker exec shared-mariadb printenv MARIADB_ROOT_PASSWORD)" \
                "${DB_NAME}"
            docker compose -f "$SITE_DIR/docker-compose.yml" restart wordpress
            echo "==> Rollback complete. Check the site manually."
        else
            echo "!!! No backup found for rollback. Manual intervention required."
        fi
        exit 1
    fi
else
    echo "    No minor updates available."
fi

echo "==> Step 4: Flushing cache..."
$WP cache flush

echo "==> Maintenance complete."
