<?php

use CodeDelivery\Models\Order;
use CodeDelivery\Models\OrdersItem;
use CodeDelivery\Models\Product;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 5)->create()->each(function($o){
            $product = Product::find(rand(1,30));
            $data = [
                'product_id' => $product->id,
                'order_id' => $o->id,
                'price' => $product->price,
                'qtd' => 1
            ];
            $ordersItem = new OrdersItem($data);
            $o->items()->save($ordersItem);
            $o->total = $product->price;
            switch($o->id){
                case 1:
                    $o->deliveryman_id = 3;
                    $o->client_id = 1;
                    break;
                case 2:
                    $o->client_id = 2;
                    break;
            }
            $o->save();
        });
    }
}
