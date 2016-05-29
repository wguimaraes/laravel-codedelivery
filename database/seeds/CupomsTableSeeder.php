<?php

use CodeDelivery\Models\Cupom;
use Illuminate\Database\Seeder;

class CupomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cupom::class, 10)->create();
    }
}
