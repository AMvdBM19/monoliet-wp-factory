# Monoliet WP Factory

Template system for rapidly creating, deploying, and maintaining WordPress client websites.

**New client site in < 1 hour.**

## Quick Start

```bash
# 1. Create a new client site
./scripts/create-site.sh empire-ink "Empire INK" empire-ink.nl

# 2. Customize brand (edit CSS variables)
vim clients/empire-ink/wp/wp-content/themes/monoliet-starter/assets/css/client.css

# 3. Push to GitHub
cd clients/empire-ink
git remote add origin https://github.com/AMvdBM19/empire-ink.git
git push -u origin main

# 4. Deploy to VPS
ssh monoliet-vps
/opt/docker/wp-factory/scripts/deploy-client.sh empire-ink
```

## What's Included

- **monoliet-starter** theme — Production-ready, fully customizable via CSS variables
- **monoliet-core** plugin — Booking widget, reviews, business hours, health API, admin branding
- **Docker templates** — WordPress 6.7 + PHP 8.3, shared MariaDB, < 200MB RAM per site
- **Deployment scripts** — Create, deploy, backup, and maintain client sites
- **n8n workflow** — Automated health monitoring

## Architecture

```
VPS (72.62.26.15)
├── nginx-proxy-manager → routes all domains
├── shared-mariadb → one DB server, one database per client
├── wp-factory/shared-plugins/ → read-only mount for all clients
└── clients/
    ├── client-a/ → wp-client-a container
    ├── client-b/ → wp-client-b container
    └── ...
```

## Documentation

See [CLAUDE.md](CLAUDE.md) for full operational reference.

---

Built by [Monoliet.cloud](https://monoliet.cloud)
