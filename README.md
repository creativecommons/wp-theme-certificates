# Certificate WordPress Theme

`ccommons-certificates` is a WordPress theme for https://certificates.creativecommons.org.

## Requirements

- PHP > 7.3
- WordPress > 5.5.3

### Plugin and Theme Requirements

Must be used with the parent theme [creativecommons-base](https://github.com/creativecommons/creativecommons-base).

Relies on the following plugins:

```
+-----------------------------+----------------+-----------+-----------+
| name                        | status         | update    | version   |
+-----------------------------+----------------+-----------+-----------+
| advanced-custom-fields-pro  | active-network | available | 5.9.1     |
| queulat                     | active-network | none      | 0.1.0     |
| the-events-calendar         | active-network | none      | 5.2.1     |
| wordpress-seo               | active-network | available | 15.2      |
+-----------------------------+----------------+-----------+-----------+
```

## Installation

> With composer

Add the following to your `composer.json` file:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/creativecommons/creativecommons-certificate"
    }
  ],
  "require": {
    "creativecommons/creativecommons-certificate": "dev-master"
  }
}
```

> Manual Installation

1. Click the 'Code' button on this Github page and select 'Download ZIP'.
2. In your admin panel, go to Appearance -> Themes and click the 'Add New' button.
3. Click on 'Upload Theme', select the zip file, and click on 'Install Now'.
4. Click on the 'Activate' button to use your new theme right away.

## Local Development

- Frontend JavaScript and CSS are located in the `front/` directory. There you can `npm install` and `npm run watch` to recompile scss and js files when files are updated. You'll still need to manually refresh your browser to see changes. Alternatively, `npm run watch` can be paired with something like [BrowserSync](https://browsersync.io) to auto update your browser tab when changes are made. You can use the command `browser-sync start --proxy https://your-local-domain.test --files="**/*.css,**/*.php"` in the root of the theme as an example.

## Manual Deployment

1. Export local DB with url rename `wp search-replace 'certs-backup.test' 'tempcert.creativecommons.org' --export=certs.sql`
2. Zip uploads directory `zip uploads.zip uploads -r`
3. Upload `.zip` to production server
