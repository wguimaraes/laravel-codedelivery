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

    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function items(){
        return $this->hasMany(OrdersItem::class);
    }
    
    public function cupom(){
    	return $this->belongsTo(Cupom::class);
    }

    public function delivaryMan(){
        return $this->belongsTo(User::class, 'deliveryman_id');
    }

}
