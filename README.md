# Runestudios Theme

Starter WordPress theme using Vite and Tailwind CSS.

## Installation
npm i

## WordPress requirements

This theme uses Advanced Custom Fields Pro for flexible content and the Options page.
Field groups load from and save to `acf-json/`. After updating a field group in WordPress,
commit the generated JSON file so the same fields are available in other environments.
The shared `blocks` field is exposed on editable content post types; media attachments and
WordPress/ACF internal post types are excluded.

## Development
npm run dev

## Build
npm run build
