##Server Requirements

In order to install, your server must meet following requirements:

* PHP >= 5.5.9 (including PHP 7)
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* GD PHP Extension
* Fileinfo PHP Extension
* Zip PHP Extension

## Quick Start

**Setup Commands**
 0. `apt-get update && apt-get dist-upgrade && apt-get install libnotify-bin`
 1. `composer install`
 2. `npm install`
 3. `bower install`
 4. `cp .env.example .env`
 5. `php artisan key:generate`
 6. `php artisan migrate`
 7. Set administrator info in UserSeeder.php
 8. `php artisan db:seed`
 9. `gulp --production` (Install gulp (sudo npm install -g gulp) if needed)

##Features

 - Secure user registration and login
 - Social Authentication using Facebook, Twitter and Google+
 - Password reset
 - Backup support
 - Department support
 - Two-Factor Authentication
 - Remember Me feature on login
 - Login with email or username
 - Google reCAPTCHA on registration
 - Authentication Throttling (lock user account after few incorrect login -  attempts)
 - Interactive Dashboard
 - Unlimited number of user roles
 - Powerful admin panel
 - Unlimited number of permissions
 - Manage permissions from admin interface
 - Assign permission to roles
 - Easily check if user has permission to perform some action
 - User Activity Log
 - Avatar upload with crop feature
 - Built using Twitter Bootstrap
 - Active Sessions Management (see and manage all your active sessions)
 - Full unicode support
 - Client side and server side form validation
 - Fully customisable from settings section
 - Localization support – Translate the application to any language
