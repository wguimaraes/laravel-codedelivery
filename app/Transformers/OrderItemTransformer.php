<?php

namespace CodeDelivery\Transformers;

use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\OrdersItem;

/**
 * Class OrderItemTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderItemTransformer extends TransformerAbstract
{

	protected $defaultIncludes = ['product'];
	
    /**
     * Transform the \OrdersItem entity
     * @param \OrdersItem $model
     *
     * @return array
     */
    public function transform(OrdersItem $model)
    {
        return [
            'id'         => (int) $model->id,
        	'qtd'		 => (int) $model->qtd,
        	'price'		 => (int) $model->price,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
    
    public function includeProduct(OrdersItem $model){
    	return $this->item($model->product, new ProductTransformer());
    }
}
