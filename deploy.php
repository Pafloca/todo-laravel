<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'desplegar_laravel');

// Project repository
set('repository', 'git@github.com:Pafloca/todo-laravel.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('192.168.56.102')
    ->user('ddaw-ud4-deployer')
    ->identityFile('~/.ssh/id_rsa.pub')
    ->set('deploy_path', '/var/www/prod-ud4-a4/html'); 
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

task('reload:php-fpm', function () {
 run('sudo /etc/init.d/php8.1-fpm restart');
});

after('deploy', 'reload:php-fpm');
