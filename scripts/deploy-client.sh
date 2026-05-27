#!/bin/sh
# deploy-client.sh — Deploy a client site to the VPS.
#
# Usage: ./scripts/deploy-client.sh <slug>
# Run this on the VPS.
set -e

if [ -z "$1" ]; then
    echo "Usage: $0 <slug>"
    exit 1
fi

CLIENT_SLUG="$1"
CLIENTS_DIR="/opt/docker/clients"
CLIENT_DIR="$CLIENTS_DIR/$CLIENT_SLUG"
FACTORY_DIR="/opt/docker/wp-factory"

echo "==> Deploying client: $CLIENT_SLUG"

# Clone or pull
if [ -d "$CLIENT_DIR/.git" ]; then
    echo "==> Pulling latest changes..."
    cd "$CLIENT_DIR"
    git pull origin main
else
    echo "==> Cloning repository..."
    mkdir -p "$CLIENTS_DIR"
    git clone "https://github.com/AMvdBM19/$CLIENT_SLUG.git" "$CLIENT_DIR"
    cd "$CLIENT_DIR"
fi

# Load environment
if [ ! -f "$CLIENT_DIR/.env" ]; then
    echo "!!! .env file not found in $CLIENT_DIR"
    exit 1
fi

# shellcheck disable=SC1091
. "$CLIENT_DIR/.env"

# Create database and user in shared MariaDB
echo "==> Ensuring database and user exist..."
MARIADB_ROOT_PASS=$(docker exec shared-mariadb printenv MARIADB_ROOT_PASSWORD 2>/dev/null || echo "")
if [ -z "$MARIADB_ROOT_PASS" ]; then
    MARIADB_ROOT_PASS=$(docker exec shared-mariadb cat /run/secrets/db_root_password 2>/dev/null || echo "")
fi

if [ -z "$MARIADB_ROOT_PASS" ]; then
    echo "!!! Cannot determine MariaDB root password."
    echo "    Set MARIADB_ROOT_PASSWORD or mount the secret."
    exit 1
fi

docker exec -i shared-mariadb mariadb -u root -p"$MARIADB_ROOT_PASS" <<SQL
CREATE DATABASE IF NOT EXISTS \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '$DB_USER'@'%' IDENTIFIED BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'%';
FLUSH PRIVILEGES;
SQL
echo "    Database $DB_NAME ready."

# Ensure shared plugins exist
if [ ! -d "$FACTORY_DIR/shared-plugins/monoliet-core" ]; then
    echo "!!! Shared plugins not found at $FACTORY_DIR/shared-plugins/"
    echo "    Run update-shared-plugins.sh first."
    exit 1
fi

# Start container
echo "==> Starting WordPress container..."
cd "$CLIENT_DIR"
docker compose up -d

echo "==> Waiting for container to be healthy..."
ATTEMPTS=0
MAX_ATTEMPTS=30
while [ $ATTEMPTS -lt $MAX_ATTEMPTS ]; do
    STATUS=$(docker inspect --format='{{.State.Health.Status}}' "wp-$CLIENT_SLUG" 2>/dev/null || echo "starting")
    if [ "$STATUS" = "healthy" ]; then
        echo "    Container is healthy."
        break
    fi
    ATTEMPTS=$((ATTEMPTS + 1))
    sleep 5
done

if [ "$STATUS" != "healthy" ]; then
    echo "    Container not yet healthy ($STATUS). Running init anyway..."
fi

# Run init script
echo "==> Running WordPress init..."
docker exec "wp-$CLIENT_SLUG" sh /var/www/html/wp-content/themes/monoliet-starter/../../init.sh 2>/dev/null || \
    docker cp "$CLIENT_DIR/init.sh" "wp-$CLIENT_SLUG:/tmp/init.sh" && \
    docker exec "wp-$CLIENT_SLUG" sh /tmp/init.sh

echo ""
echo "========================================="
echo "  Deployment complete: $CLIENT_SLUG"
echo "========================================="
echo ""
echo "  Container: wp-$CLIENT_SLUG"
echo "  Admin URL: https://$CLIENT_DOMAIN/wp-admin"
echo "  Admin:     monoliet / $WP_ADMIN_PASS"
echo ""
echo "  REMAINING STEPS:"
echo "  1. Add proxy host in nginx-proxy-manager (:81)"
echo "     Forward hostname: wp-$CLIENT_SLUG"
echo "     Forward port: 80"
echo "     Domain: $CLIENT_DOMAIN"
echo "     SSL: Request Let's Encrypt certificate"
echo ""
echo "  2. Point DNS A record:"
echo "     $CLIENT_DOMAIN → 72.62.26.15"
echo "========================================="
