<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Hyperf\DbConnection\Db::table('users')->insert([
            [
                'username'  => 1,
                'password'  => '$2y$10$Mynb1Wemp8KAkmmaFhV8zuptvjWZuHpwHf/i7oOfJwiMRjUbPens2',
                'email'     => 'jxh@qq.com',
                'last_time' => time(),
            ], [
                'username'  => 2,
                'password'  => '$2y$10$VQAYzccXEzAGrkGi4OcsJOjCJrauLcSG1aIDwdzVyaqk31pBwc6B.',
                'email'     => 'jxh@qq.com',
                'last_time' => time(),
            ],
        ]);
    }
}
