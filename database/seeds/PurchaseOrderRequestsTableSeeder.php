<?php

use Illuminate\Database\Seeder;

class PurchaseOrderRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PurchaseOrderRequest::class, 1)->create();
    }
}
