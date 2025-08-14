#!/bin/bash

# Define the path to your project directory
PROJECT_PATH="/home/sepbdco1/public_html"

# Define the full paths to the .htaccess and .htaccess_old files
HTACCESS_PATH="$PROJECT_PATH/.htaccess"
HTACCESS_OLD_PATH="$PROJECT_PATH/.htaccess_old"

# Check if .htaccess_old exists and .htaccess does not exist
if [ -f "$HTACCESS_OLD_PATH" ] && [ ! -f "$HTACCESS_PATH" ]; then
    # Rename .htaccess_old back to .htaccess
    mv "$HTACCESS_OLD_PATH" "$HTACCESS_PATH"
    echo "$(date) - .htaccess_old renamed back to .htaccess" >> "$PROJECT_PATH/rename_htaccess.log"
fi
