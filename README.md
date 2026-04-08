# MBN WordPress Theme

Custom WordPress theme for My Biz Niche.

## Theme Details

- Theme Name: `MBN`
- Description: `Custom Theme for MBN`
- Version: `1.0.5`
- Author: `My Biz Niche`
- Theme URI: [https://github.com/MBNDEV/demo-theme](https://github.com/MBNDEV/demo-theme)
- Author URI: [https://www.mybizniche.com/](https://www.mybizniche.com/)
- License: `GPL-2.0`
- Text Domain: `demo-theme`

## Requirements

- WordPress (current supported version)
- PHP compatible with WordPress requirements
- Composer (for development tooling)

## Installation

1. Copy or clone this theme into `wp-content/themes/albert-theme`.
2. Install dependencies:
   - `composer install`
3. In WordPress Admin, go to **Appearance > Themes** and activate **MBN**.

## Development

This theme uses Composer autoloading for vendor packages.

- Primary package in use:
  - `yahnis-elsts/plugin-update-checker`
- Autoload is conditionally loaded in `functions.php` to avoid duplicate class loading.

## Update Checker

The theme includes GitHub-based update checks through Plugin Update Checker.

- Repository configured in code:
  - [https://github.com/MBNDEV/custom-theme](https://github.com/MBNDEV/custom-theme)
- Slug configured in code:
  - `custom-theme`

## Linting

Run WordPress coding standards checks before committing:

- `composer run lint`
- `composer run lint:fix`
- `composer run lint:security`
- `composer run lint:run`

## Security

Please review `SECURITY.md` for:

- supported versions
- vulnerability reporting process
- enforced secure coding standards
