<?php
declare(strict_types=1);

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Utility\Security;
use Migrations\AbstractSeed;

/**
 * User seed.
 */
class UserSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [];

        $table = $this->table('users');
    	$password = (new DefaultPasswordHasher())->hash('admin');
        $data = [
    	    'username' => 'admin',
            'email' => 'admin@gmail.com',
    	    'password' => $password,
            'token' =>  Security::hash('admin', 'sha256')
    	];
        $table->insert($data)->save();
    }
}
