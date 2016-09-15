<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Models\Order;
use CodeDelivery\Validators\OrderValidator;

/**
 * Class OrderRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
	
	protected $skipPresenter = true;
	
	public function getByIdAndDeliveryMan($id, $deliveryManId){
		$result = $this->with([
				'client',
				'items',
				'deliveryMan', 
				'cupom'])->findWhere([
						'id' => $id, 
						'deliveryman_id' => $deliveryManId]);
		$order = null;
		if($result instanceof Collection){
			$order = $result->first();
		}else{
			if(isset($result['data']) && sizeof($result['data']) > 0){
				$order = ['data' => $result['data'][0]];
			}
		}
		
		return $order;
	}
	
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function presenter(){
    	return \CodeDelivery\Presenters\OrderPresenter::class;
    }
}
