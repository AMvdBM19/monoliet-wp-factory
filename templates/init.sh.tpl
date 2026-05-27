#!/bin/sh
# ${CLIENT_NAME} — WordPress initialization script
# Run inside the WordPress container after first boot.
set -e

WP="wp --allow-root"

echo "==> Installing WordPress..."
$WP core install \
  --url="https://${CLIENT_DOMAIN}" \
  --title="${CLIENT_NAME}" \
  --admin_user="monoliet" \
  --admin_password="${WP_ADMIN_PASS}" \
  --admin_email="sites@monoliet.cloud" \
  --skip-email

echo "==> Configuring settings..."
$WP option update blogdescription ""
$WP option update timezone_string "Europe/Amsterdam"
$WP option update date_format "d-m-Y"
$WP option update time_format "H:i"
$WP option update start_of_week 1
$WP option update WPLANG "nl_NL"
$WP rewrite structure '/%postname%/' --hard

echo "==> Activating theme..."
$WP theme activate monoliet-starter

echo "==> Activating plugins..."
$WP plugin activate advanced-custom-fields
$WP plugin activate monoliet-core
$WP plugin activate wordpress-seo
$WP plugin activate autoptimize
$WP plugin activate wp-super-cache
$WP plugin activate redirection
$WP plugin activate wordfence
$WP plugin activate wp-mail-smtp

echo "==> Creating pages..."
HOME_ID=$($WP post create --post_type=page --post_title="Home" --post_status=publish --porcelain)
$WP post create --post_type=page --post_title="About" --post_status=publish
$WP post create --post_type=page --post_title="Contact" --post_status=publish
$WP post create --post_type=page --post_title="Portfolio" --post_status=publish
$WP post create --post_type=page --post_title="FAQ" --post_status=publish
$WP post create --post_type=page --post_title="Services" --post_status=publish

SETTINGS_ID=$($WP post create --post_type=page --post_title="Site Settings" --post_status=publish --porcelain)
$WP post meta update "$SETTINGS_ID" _wp_page_template page-site-settings.php

echo "==> Setting front page..."
$WP option update show_on_front page
$WP option update page_on_front "$HOME_ID"

echo "==> Cleaning defaults..."
$WP post delete 1 --force 2>/dev/null || true
$WP post delete 2 --force 2>/dev/null || true
$WP post delete 3 --force 2>/dev/null || true

DEFAULT_THEMES=$($WP theme list --status=inactive --field=name 2>/dev/null || true)
for theme in $DEFAULT_THEMES; do
  case "$theme" in
    twenty*) $WP theme delete "$theme" 2>/dev/null || true ;;
  esac
done

echo "==> Security hardening..."
$WP option update default_comment_status closed
$WP option update default_ping_status closed
$WP option update default_pingback_flag 0
$WP plugin deactivate akismet 2>/dev/null || true
$WP plugin deactivate hello 2>/dev/null || true

echo "==> Flushing..."
$WP cache flush
$WP rewrite flush

echo "==> Done. Site ready at https://${CLIENT_DOMAIN}"
echo "    Admin: monoliet / ${WP_ADMIN_PASS}"
