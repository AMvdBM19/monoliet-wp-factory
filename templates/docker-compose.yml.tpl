services:
  wordpress:
    image: wordpress:6.7-php8.3-apache
    container_name: wp-${CLIENT_SLUG}
    restart: unless-stopped
    environment:
      WORDPRESS_DB_HOST: shared-mariadb:3306
      WORDPRESS_DB_NAME: ${DB_NAME}
      WORDPRESS_DB_USER: ${DB_USER}
      WORDPRESS_DB_PASSWORD: ${DB_PASSWORD}
      WORDPRESS_TABLE_PREFIX: wp_
      WORDPRESS_CONFIG_EXTRA: |
        define('DISALLOW_FILE_EDIT', true);
        define('AUTOMATIC_UPDATER_DISABLED', true);
        define('WP_POST_REVISIONS', 5);
        define('MONOLIET_API_KEY', '${MONOLIET_API_KEY}');
    volumes:
      - ./wp/wp-content/themes/monoliet-starter:/var/www/html/wp-content/themes/monoliet-starter
      - /opt/docker/wp-factory/shared-plugins:/var/www/html/wp-content/plugins:ro
      - uploads-${CLIENT_SLUG}:/var/www/html/wp-content/uploads
    networks:
      - monoliet-network
    deploy:
      resources:
        limits:
          memory: 200M
    healthcheck:
      test: ["CMD-SHELL", "curl -f http://localhost/ || curl -f http://localhost/wp-admin/install.php"]
      interval: 30s
      timeout: 10s
      retries: 3
      start_period: 60s

volumes:
  uploads-${CLIENT_SLUG}:
    name: uploads-${CLIENT_SLUG}

networks:
  monoliet-network:
    external: true
