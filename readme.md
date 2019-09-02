<p>All the underbelow, it bases on you have learnt https://github.com/ramseyjiang/Repo_Pattern_Laraevl_Passport_Vue_Fullstack/tree/0_change_base_structure before.</p>
<p>If want to learn how to do this project step by step, please follow all the under below. </p>

<p>php artisan make:migration add_username_to_users</p>
<p>Update app/Models/User.php</p>
<p>php artisan make:seeder UsersTableSeeder</p>
<p>Update database/seeds/UsersTableSeeder.php and database/seeds/DatabaseSeeder.php</p>
<p>php artisan migrate</p>
<p>php artisan db:seed</p>

<p>php artisan make:request UserLoginRequest</p>     
<p>php artisan make:request UserRegisterRequest</p>

<p>mkdir app/Contracts</p>
<p>mkdir app/Contracts/Repositories</p>
<p>Create a file named UserRepositoryContract.php in Repositories folder</p>
<p>mkdir app/Contracts/Services</p>
<p>Create a file named UserServiceContract.php in Services folder</p>
<p>mkdir app/Repositories</p>
<p>Create a file named UserRepository.php in Repositories folde</p>
<p>mkdir app/Services</p>
<p>Create a file named UserService.php in Services folder</p>

<p>Update AppServiceProvider.php in the Providers folder</p>
<p>add $this->app->bind(UserRepositoryContract::class, UserRepository::class); in the register method.</p>
<p>add $this->app->bind(UserServiceContract::class, UserService::class); in the register method.</p>

<p>Update app/Controllers/Auth/LoginController.php and app/Controllers/Auth/RegisterController.php\</p>
<p>php artisan make:test AuthTest</p>
<p>Update tests/CreatesApplication.php</p>

<p>Run "./vendor/bin/phpunit", if it's no problem, it works fine.</p>