#!/bin/sh
# update-shared-plugins.sh — Download/update shared WordPress plugins from WP.org.
set -e

FACTORY_DIR="$(cd "$(dirname "$0")/.." && pwd)"
SHARED_DIR="$FACTORY_DIR/shared-plugins"
TEMP_DIR="/tmp/wp-plugin-downloads"
VERSIONS_FILE="$SHARED_DIR/.plugin-versions.json"

PLUGINS="advanced-custom-fields wordpress-seo autoptimize wp-super-cache redirection wordfence wp-mail-smtp"

mkdir -p "$SHARED_DIR" "$TEMP_DIR"

echo "==> Updating shared plugins..."
echo "    Target: $SHARED_DIR"
echo ""

echo "{" > "$VERSIONS_FILE.tmp"
FIRST=true

for PLUGIN in $PLUGINS; do
    echo "--- $PLUGIN ---"

    API_URL="https://api.wordpress.org/plugins/info/1.2/?action=plugin_information&request[slug]=$PLUGIN"
    PLUGIN_INFO=$(curl -gsf "$API_URL" 2>/dev/null || echo "")

    if [ -z "$PLUGIN_INFO" ]; then
        echo "    WARNING: Could not fetch info for $PLUGIN. Skipping."
        continue
    fi

    DOWNLOAD_URL=$(echo "$PLUGIN_INFO" | grep -o '"download_link":"[^"]*"' | head -1 | cut -d'"' -f4 | sed 's/\\\//\//g')
    VERSION=$(echo "$PLUGIN_INFO" | grep -o '"version":"[^"]*"' | head -1 | cut -d'"' -f4)

    if [ -z "$DOWNLOAD_URL" ]; then
        echo "    WARNING: No download URL for $PLUGIN. Skipping."
        continue
    fi

    echo "    Version: $VERSION"
    echo "    Downloading..."
    curl -gsf -o "$TEMP_DIR/$PLUGIN.zip" "$DOWNLOAD_URL"

    if [ -f "$TEMP_DIR/$PLUGIN.zip" ]; then
        rm -rf "${SHARED_DIR:?}/$PLUGIN"
        unzip -qo "$TEMP_DIR/$PLUGIN.zip" -d "$SHARED_DIR"
        echo "    Extracted to $SHARED_DIR/$PLUGIN"

        if [ "$FIRST" = true ]; then
            FIRST=false
        else
            echo "," >> "$VERSIONS_FILE.tmp"
        fi
        printf '    "%s": "%s"' "$PLUGIN" "$VERSION" >> "$VERSIONS_FILE.tmp"
    else
        echo "    WARNING: Download failed for $PLUGIN."
    fi

    rm -f "$TEMP_DIR/$PLUGIN.zip"
done

echo "==> Copying monoliet-core..."
rm -rf "${SHARED_DIR:?}/monoliet-core"
cp -r "$FACTORY_DIR/monoliet-core" "$SHARED_DIR/monoliet-core"

if [ "$FIRST" = true ]; then
    FIRST=false
else
    echo "," >> "$VERSIONS_FILE.tmp"
fi
printf '    "monoliet-core": "%s"' "1.0.0" >> "$VERSIONS_FILE.tmp"

echo "" >> "$VERSIONS_FILE.tmp"
echo "}" >> "$VERSIONS_FILE.tmp"
mv "$VERSIONS_FILE.tmp" "$VERSIONS_FILE"

rm -rf "$TEMP_DIR"

echo ""
echo "==> Plugin versions:"
cat "$VERSIONS_FILE"
echo ""
echo "==> Done. All shared plugins updated."
