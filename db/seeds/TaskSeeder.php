<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class TaskSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Factory::create();
        $data = [];
        for ($j = 0; $j < 20; $j++) {
            $data[] = [
                'name' => $faker->name,
                'email' => $faker->email,
                'text' => $faker->text(300),
                'status' => $faker->boolean(50),
                'created' => $faker->dateTimeBetween('-10 days', 'now')->format('Y-m-d H:i:s')
            ];
        }
        $table = $this->table('tasks');
        $table->insert($data)->save();
    }
}
