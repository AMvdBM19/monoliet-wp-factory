# ${CLIENT_NAME} — WordPress Site

## Quick Reference

| Key | Value |
|---|---|
| Client | ${CLIENT_NAME} |
| Domain | ${CLIENT_DOMAIN} |
| Slug | ${CLIENT_SLUG} |
| VPS Path | /opt/docker/clients/${CLIENT_SLUG} |
| Container | wp-${CLIENT_SLUG} |
| Theme | monoliet-starter |
| Database | ${DB_NAME} @ shared-mariadb |

## Architecture

```
Internet → nginx-proxy-manager
└── ${CLIENT_DOMAIN} → wp-${CLIENT_SLUG}:80

Docker:
├── wp-${CLIENT_SLUG} (WordPress 6.7 + PHP 8.3)
├── Theme: ./wp/wp-content/themes/monoliet-starter (mounted)
├── Plugins: /opt/docker/wp-factory/shared-plugins (read-only mount)
├── Uploads: Docker volume uploads-${CLIENT_SLUG}
└── DB: shared-mariadb → ${DB_NAME}
```

## Common Operations

### Restart
```bash
cd /opt/docker/clients/${CLIENT_SLUG}
docker compose restart wordpress
```

### Check health
```bash
curl -s https://${CLIENT_DOMAIN}/wp-json/monoliet/v1/health | jq
```

### WP-CLI (inside container)
```bash
docker exec -it wp-${CLIENT_SLUG} wp --allow-root <command>
```

### Backup
```bash
cd /opt/docker/clients/${CLIENT_SLUG}
./backup.sh
```

### Push reviews (from n8n or cron)
```bash
curl -X POST https://${CLIENT_DOMAIN}/wp-json/monoliet/v1/reviews \
  -H "Content-Type: application/json" \
  -H "X-API-Key: <key>" \
  -d '[{"name":"John","rating":5,"text":"Great!","date":"2025-01-01","source":"Google"}]'
```

## Protected Zones

- **DO NOT** modify files in `/opt/docker/wp-factory/shared-plugins/` — use `update-shared-plugins.sh`
- **DO NOT** rebuild the shared-mariadb container
- **DO NOT** hardcode credentials — use `.env`
- **DO NOT** modify other clients' containers or volumes

## Customization

The only file that should change per client is:
`wp/wp-content/themes/monoliet-starter/assets/css/client.css`

Edit CSS custom properties to match the client's brand.

## Related

- WP Factory repo: monoliet-wp-factory
- Monoliet website: monoliet.cloud (separate project)
- Portal: portal.monoliet.cloud
