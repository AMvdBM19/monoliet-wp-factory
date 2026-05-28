# Monoliet WP Factory

## What this is

Template system for rapidly creating, deploying, and maintaining WordPress
client websites. This is NOT a client site — it's the factory that produces them.

## Directory Structure

```
monoliet-wp-factory/
├── base-theme/          → monoliet-starter WordPress theme (copied per client)
├── monoliet-core/       → Custom WP plugin (shared across all clients, read-only mount)
├── templates/           → Per-client scaffolding templates (processed by envsubst)
├── shared-mariadb/      → Shared MariaDB instance (one DB server, many databases)
├── scripts/             → Factory operations scripts
├── n8n/                 → n8n workflow templates
└── clients/             → Generated client directories (gitignored)
```

## How to Add a New Client

```bash
./scripts/create-site.sh <slug> "<name>" <domain>
```

Example:
```bash
./scripts/create-site.sh empire-ink "Empire INK" empire-ink.nl
```

This generates a complete client directory under `clients/<slug>/` with:
- docker-compose.yml
- .env with generated credentials
- CLAUDE.md context file
- Theme copy with client.css for customization
- init.sh, deploy.sh, backup.sh, maintain.sh scripts
- client.json metadata

After creation:
1. Push to GitHub: `AMvdBM19/<slug>`
2. Customize `client.css` with brand colors/fonts
3. Deploy to VPS

## How to Update Shared Plugins

```bash
./scripts/update-shared-plugins.sh
```

Downloads latest versions of: ACF Free, Yoast, Autoptimize, WP Super Cache,
Redirection, Wordfence, WP Mail SMTP. Also copies monoliet-core.

Run this on the VPS at `/opt/docker/wp-factory/` to update all client sites at once
(plugins are mounted read-only).

## How to Deploy a Client

On the VPS:
```bash
./scripts/deploy-client.sh <slug>
```

This will:
1. Clone/pull the client repo to `/opt/docker/clients/<slug>/`
2. Create database + user in shared MariaDB
3. `docker compose up -d`
4. Run `init.sh` inside the container
5. Print admin credentials and nginx proxy host instructions

## VPS Paths

| Path | Purpose |
|---|---|
| /opt/docker/wp-factory/ | This repo (factory files, shared plugins) |
| /opt/docker/wp-factory/shared-plugins/ | Read-only plugin mount for all client containers |
| /opt/docker/clients/<slug>/ | Per-client deployment directory |
| /opt/docker/wordpress/ | monoliet.cloud (separate, do NOT touch) |

## Protected Zones

- **shared-plugins/** — Never edit directly. Use `update-shared-plugins.sh`.
- **Other clients' directories** — Each client is isolated. Do not cross-modify.
- **shared-mariadb** — Never rebuild. Stateful data. Only add databases.
- **monoliet.cloud** at /opt/docker/wordpress/ — Separate project entirely.
- **shared-mariadb/.db_root_password** — Contains MariaDB root password.
  Must be created manually on VPS before first `docker compose up`.
  NOT in git. Generate with: `openssl rand -base64 32 > shared-mariadb/.db_root_password`

## Theme Customization

The only file changed per client: `base-theme/assets/css/client.css`

All visual properties are CSS custom properties. Override them for each client's brand.
The base theme with default values produces a clean neutral light theme.

## Key Design Decisions

- **Shared MariaDB** — One database server, one database per client. Saves ~100MB RAM per site.
- **Read-only plugin mount** — All clients share the same plugin binaries. Update once, applies everywhere.
- **ACF Free only** — No repeater fields. CPTs replace repeaters. Site Settings page template replaces options page.
- **No staging** — VPS is production. All deploys are live immediately.
- **< 200MB RAM per client** — Docker `mem_limit` enforced.

## Related Projects

- **monoliet.cloud** — Our own website (separate WordPress, separate repo)
- **Velours ERP** — Booking system integrated via [monoliet_booking] shortcode
- **Monoliet Portal** — Client management dashboard at portal.monoliet.cloud
