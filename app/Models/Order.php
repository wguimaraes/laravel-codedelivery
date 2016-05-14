<?php

namespace CodeDelivery\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Order extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'client_id', 'deliveryman_id', 'total', 'status'
    ];

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function delivaryMan(){
        return $this->belongTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
