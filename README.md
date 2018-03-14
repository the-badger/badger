<p align="center">
<img src="http://i.imgur.com/mFAwoIi.png" alt="Gruik Logo"/>
</p>

## Badger
[![Travis CI](https://travis-ci.org/the-badger/badger.svg)](https://travis-ci.org/the-badger/badger/tree/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/the-badger/badger/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/the-badger/badger/?branch=master)

Badger is a gamification platform initially developed as an internal project by [Akeneo](http://www.akeneo.com).
Badger is still under development, but is working! If you want to try the project, please install [the last release](https://github.com/the-badger/badger/releases).

## Prerequisite
- PHP 7.1+
- MySQL
- Composer
- NodeJS & NPM _(only used to grab front JS dependencies)_
- Elasticsearch 1.7.x (**not compatible with 2.x**)

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

php bin/console doctrine:schema:update --force
```

#### 3) Install frontend assets
```bash
npm install # Install frontend dependencies, like Bootstrap
php bin/console assets:install # Move bundle assets to web/ directory
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
2. Fill in needed informations. Put your Badger Google Login page (eg. `http://badger.example.com/login/check-google`) as a **valid redirect domain**
3. Once the application created, put your **Client ID** & **Client Secret** tokens in the parameters file of your Badger app:
```yml
# ./app/config/parameters.yml
parameters:
    google_client_id: abcdefg123456789.apps.googleusercontent.com
    google_client_secret: 123456789abcd
```

### Setup Elasticsearch

Bagder is working with Elasticsearch in order to ease the search in the application.

1. Instructions for installing and deploying Elasticsearch may be found [here](https://www.elastic.co/downloads/elasticsearch).
2. Set the correct elastic host and port in you parameters.yml file.
3. (Optional) Populate Elasticsearch with existing users using the following command:

```bash
php bin/console fos:elastica:populate
```

_Note that every new users will be automatically indexed by Elasticsearch, you won't need to re-run this command again._

### Create an admin user
To manage Badger, you'll need one or several administrators. To promote a user, use this command:

```bash
php bin/console fos:user:promote <username> ROLE_ADMIN
```

Note that the promoted user will need to **logout then login again** to have full power :metal:

## Running Tests

```bash
./bin/simple-phpunit -c app
```

```bash
./bin/simple-phpunit -c app --coverage-html=web/phpunit-coverage
```

## License
Badger is licensed under the [Open Software License v. 3.0 (OSL-3.0)](https://opensource.org/licenses/OSL-3.0)
