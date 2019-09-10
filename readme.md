<p>All the underbelow, it bases on you have learnt https://github.com/ramseyjiang/Repo_Pattern_Laraevl_Passport_Vue_Fullstack/tree/3_passport_vue_fullstack before.</p>

<p>If want to learn how to do this project step by step, please follow all the under below. </p>

<p>Step0: composer require jenssegers/mongodb </p>
<p>Add MongoDB config into config/database.php, .env, .env.example</p>

<p>Step1: php artisan make:model Models/Log -m</p>
<p>Update app/Models/Log.php, app/Models/User.php</p>
<p>php artisan migrate</p>

<p>Step2: php artisan make:model Models/Blog</p>
<p>Update app/Models/Blog.php</p>

<p>Step3: php artisan make:observer BlogObserver</p>
<p>Update app/Observers/BlogObserver.php</p>

<p>step4: create LogRepositoryContract.php within the app/Contracts/Repositories folder</p>
<p>step5: create BlogRepositoryContract.php within the app/Contracts/Repositories folder</p>
<p>step6: create LogRepository.php within the app/Repositories folder</p>
<p>step7: create BlogRepository.php within the app/Repositories folder</p>
<p>step8: add "$this->app->bind(LogRepositoryContract::class, LogRepository::class);" in the app/Providers/AppServicesProvider</p>
<p>step9: add "$this->app->bind(BlogRepositoryContract::class, BlogRepository::class);" in the app/Providers/AppServicesProvider<</p>

<p>Step10: php artisan make:request BlogRequest</p>

<p>Step11: php artisan make:policy BlogPolicy</p>
<p>Update app/Providers/AuthServiceProvider.php</p>

<p>Step12: php artisan make:controller BlogController --resource</p>
<p>Update routes/web.php</p>

<p>Step13: php artisan make:test BlogTest </p>
<p>Update tests/Feature/BlogTest.php</p>

<p>Step14: If run "./vendor/bin/phpunit" no issues, it works fine.</p>

<p>Step15: create blog/List.vue, blog/Edit.vue in the resources/js/components folder, create blog/List.test.js, blog/Edit.test.js in the resources/js/tests folder</p>

<p>Step16: Update resources/js/routes.js, resources/js/app.js</p>

<p>After all steps above, you can copy code from each matches file content from this project file.</p>
<p>Run "npm run dev" to compile, after that run "npm run test" to test whether frontend works or not. </p>

<p>Visit your website in your local, if you can using admin username and passpord login, it works fine.</p>

<p>If all the above works, this project works. Thanks for your time. If you like this project, please add a star for me. Thanks and cheers.</p>