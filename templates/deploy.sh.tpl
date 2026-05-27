#!/bin/sh
# ${CLIENT_NAME} — Deploy script
set -e

SITE_DIR="/opt/docker/clients/${CLIENT_SLUG}"

echo "==> Deploying ${CLIENT_NAME}..."

cd "$SITE_DIR"
git pull origin main

echo "==> Restarting WordPress container..."
docker compose restart wordpress

echo "==> Waiting for health check..."
sleep 10

HEALTH=$(curl -sf "http://localhost/wp-json/monoliet/v1/health" -H "Host: ${CLIENT_DOMAIN}" 2>/dev/null || echo "FAIL")
if echo "$HEALTH" | grep -q "wp_version"; then
    echo "==> Deploy successful."
    echo "$HEALTH" | head -1
else
    echo "!!! Health check failed. Check container logs:"
    echo "    docker logs wp-${CLIENT_SLUG} --tail 50"
    exit 1
fi
