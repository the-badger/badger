<p align="center">
<img src="http://i.imgur.com/mFAwoIi.png" alt="Gruik Logo"/>
</p>

## Badger
Badger is a gamification platform initially developed as an internal project by [Akeneo](www.akeneo.com).

## Prerequisite
- PHP 5.5+
- MySQL
- Composer
- NodeJS & NPM _(only used to grab front JS dependencies)_

## Installation
Badger is based on the great Symfony framework. **If you encounter some installation errors**,
please have a look on the [Symfony installation documentation](http://symfony.com/doc/2.8/book/installation.html).
If you still have some troubles, feel free to open a [GitHub issue](https://github.com/grena/gruik/issues/new).

#### 1) Setup your database
```
mysql -u root -p

CREATE DATABASE badger;
GRANT ALL PRIVILEGES ON badger.* TO badger_user@localhost IDENTIFIED BY 'badger_password';
EXIT
```

#### 2) Install Composer dependencies
```
composer install
```

#### 3) Install frontend assets
```bash
npm install # Install frontend dependencies, like Bootstrap
php app/console assets:install # Move bundle assets to web/ directory
nodejs node_modules/gulp/bin/gulp.js less # Compile bundle .less files to .css
nodejs node_modules/gulp/bin/gulp.js install # Move downloaded assets to web/ directory
```

## License
Badger is licensed under the [Open Software License v. 3.0 (OSL-3.0)](https://opensource.org/licenses/OSL-3.0)
