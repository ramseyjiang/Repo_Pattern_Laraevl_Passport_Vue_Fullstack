<p>If want to learn how to do this project step by step, please follow all the under below.</p>

<p>composer create-project --prefer-dist laravel/laravel project_name "5.8.*"</p>
<p>composer require laravel/telescope</p>
<p>php artisan telescope:install</p>
<p>php artisan make:auth</p>
<p>php artisan migrate</p>
<p>composer require barryvdh/laravel-debugbar --dev</p>
<p>composer require barryvdh/laravel-ide-helper --dev</p>     
<p>composer require xethron/migrations-generator --dev</p>
<p>composer require mpociot/laravel-test-factory-helper --dev</p>
<p>composer require skyronic/laravel-file-generator --dev</p>

<p>add \<\env name="TELESCOPE_ENABLED" value="false"\/\> into the phpunit.xml</p>

<p>php artisan app:name Rspafs</p>
<p>php artisan make:model Models/User</p>
<p>delete User.php under Models folder, and then move app/User.php into Models folder. After that, modify User.php namespace</p>
<p>change User namespace in config/auth.php, config/services.php, database/factories/UserFactory.php.</p>

<p>command "./vendor/bin/phpunit" can be run.</p>