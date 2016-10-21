<?php

namespace CodeDelivery\Transformers;

use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrderTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{

	protected $availableIncludes = ['items','deliveryMan','cupom','client'];
	
    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {	
        return [
            'id'         => (int) $model->id,
			'total' => $model->total,
        	'status' => (int)$model->status,
        	'product_names' => $this->getArrayProductNames($model->items),
        	'hash' => $model->hash,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
    
    private function getArrayProductNames(Collection $items){
    	$names = [];
    	foreach($items as $item){
    		$names[] = $item->product->name;
    	}
    	
    	return $names;
    }
    
    public function includeItems(Order $model){
    	return $this->collection($model->items, new OrdersItemTransformer());
    }
    public function includeDeliveryMan(Order $model){
    	if(!$model->deliveryMan){
    		return null;
    	}
    	return $this->item($model->deliveryMan, new UserTransformer());
    }
    public function includeCupom(Order $model){
    	if(!$model->cupom){
    		return null;
    	}
    	return $this->item($model->cupom, new CupomTransformer());
    }
    
    public function includeClient(Order $model){
    	return $this->item($model->client, new ClientTransformer());
    }
}
