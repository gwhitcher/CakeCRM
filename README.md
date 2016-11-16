# CakeCRM

A Client Relations Manager (CRM) written in [CakePHP](http://cakephp.org) 3.x.  Written by [George Whitcher](http://georgewhitcher.com).

## Installation
1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.  (If you do not have composer you can download CakePHP manually [cakephp/cakephp](https://github.com/cakephp/cakephp))
2. Download/clone the repository and extract to your designated directory.
3. Run composer update (If downloaded manually ignore this step)
4. Update `/config/app.php` with your MySQL information under 'Datasources'.
5. Rename the `/config/cakecrm-config-default.php` with your values and save as `/config/cakecrm-config.php`.
6. Visit `domain.com/install` to install the necessary tables.
7. `*IMPORTANT:* Delete the /src/Controllers/InstallController for security purposes.`

## Updates
A custom updater has been built into CakeCRM to update directly from the Git Repository.  Just choose update from the menu and CakeCRM will do the rest.  This will overwrite all the core CakeCRM files so it is not suggested to customize them yourself.