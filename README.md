<p align="center">
<img src="http://i.imgur.com/mFAwoIi.png" alt="Gruik Logo"/>
</p>

## Badger
[![Travis CI](https://travis-ci.org/akeneo/badger.svg)](https://travis-ci.org/akeneo/badger/tree/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/akeneo/badger/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/akeneo/badger/?branch=master)

Badger is a gamification platform initially developed as an internal project by [Akeneo](http://www.akeneo.com).

## Prerequisite
- PHP 5.5+
- MySQL
- Composer
- NodeJS & NPM _(only used to grab front JS dependencies)_

## Installation
Badger is based on the great Symfony framework. **If you encounter some installation errors**,
please have a look on the [Symfony installation documentation](http://symfony.com/doc/2.8/book/installation.html).
If you still have some troubles, feel free to open a [GitHub issue](https://github.com/grena/gruik/issues/new).

#### 1) Install Composer dependencies
```
composer install
```

#### 2) Setup your database
```
mysql -u root -p

    CREATE DATABASE badger;
    GRANT ALL PRIVILEGES ON badger.* TO badger_user@localhost IDENTIFIED BY 'badger_password';
    EXIT

php app/console doctrine:schema:update --force
```

#### 3) Install frontend assets
```bash
npm install # Install frontend dependencies, like Bootstrap
php app/console assets:install # Move bundle assets to web/ directory
nodejs node_modules/gulp/bin/gulp.js less # Compile bundle .less files to .css
nodejs node_modules/gulp/bin/gulp.js install # Move downloaded assets to web/ directory
```

## Configuration
Once Badger has been installed, you'll have some small things to configure in order to use the application.

### Setup GitHub oAuth login
1. Create a GitHub application with your GitHub account by following this link: https://github.com/settings/developers
2. Fill in needed informations. **Homepage URL** & **Authorization callback URL** should have the same URL, which is your Badger index page (eg. `http://badger.example.com/`)
3. Once the application created, put your **Client ID** & **Client Secret** tokens in the parameters file of your Badger app:
```yml
# ./app/config/parameters.yml
parameters:
    github_client_id: 123456789
    github_client_secret: abcdef123456789
```

### Setup Google oAuth login
1. Create a Google application with your Google account by following this link: https://console.developers.google.com/
2. Fill in needed informations. Put your Badger index page (eg. `http://badger.example.com/`) as a **valid redirect domain**
3. Once the application created, put your **Client ID** & **Client Secret** tokens in the parameters file of your Badger app:
```yml
# ./app/config/parameters.yml
parameters:
    google_client_id: abcdefg123456789.apps.googleusercontent.com
    google_client_secret: 123456789abcd
```

### Create an admin user
To manage Badger, you'll need one or several administrators. To promote a user, use this command:

```bash
php app/console fos:user:promote <username> ROLE_ADMIN
```

Note that the promoted user will need to **logout then login again** to have full power :metal:

### Running the Behat test
To use behat test you will need a test db database with fixtures loaded.


```bash
php app/console doctrine:database:create -e test
php app/console doctrine:schema:update --force -e test
php app/console doctrine:fixture:load -e test
```

Running behat:

```bash
php bin/behat
```

## License
Badger is licensed under the [Open Software License v. 3.0 (OSL-3.0)](https://opensource.org/licenses/OSL-3.0)
