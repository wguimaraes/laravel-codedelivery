<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 28/05/2016
 * Time: 22:11
 */

namespace CodeDelivery\Services;


use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use Dmitrovskiy\IonicPush\PushProcessor;

class OrderService
{


    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var CupomRepository
     */
    private $cupomRepository;
    /**
     * @var PushProcessor
     */
    private $pushProcessor;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository, ProductRepository 
        $productRepository, CupomRepository $cupomRepository, PushProcessor $pushProcessor)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->cupomRepository = $cupomRepository;
        $this->pushProcessor = $pushProcessor;
    }

    public function create(array $data){
    	
        \DB::beginTransaction();
        try {
        	if(isset($data['cupom_id'])){
        		unset($data['cupom_id']);
        	}
            if (isset($data['cupom_code'])) {
                $cupom = $this->cupomRepository->findByField('code', $data['cupom_code'])->first();
                $data['cupom_id'] = $cupom->id;
                $cupom->used = 1;
                $cupom->save();
                unset($data['cupom_code']);
            }

            $items = $data['items'];
            unset($data['items']);

            $order = $this->orderRepository->create($data);
            $total = 0;
            foreach ($items as $item) {
                $item['price'] = $this->productRepository->find($item['product_id'])->price;
                $order->items()->create($item);
                $total += $item['price'] * $item['qtd'];
            }

            $order->total = $total;
            if (isset($cupom)) {
                $order->total -= $cupom->value;
            }
            $order->save();
            \DB::commit();
            return $order;
        }catch(\Exception $e){
            \DB::rollback();
            throw $e;
        }
    }
    
    public function updateStatus($id, $deliveryManId, $status){
    	$order = $this->orderRepository->getByIdAndDeliveryMan($id, $deliveryManId);
    	if($order){
    		$order->status = $status;
    		switch((int)$order->status){
    		    case 1:
    		        if(!$order->hash){
    		            $order->hash = md5((new \DateTime())->getTimestamp());
    		        }
    		        $order->save();
    		        break;
    		    case 2:
    		        $user = $order->client->user;
    		        $order->save();
    		        $this->pushProcessor->notify([$user->device_token], 
    		            ["message" => "Seu pedido acabou de ser entrege!"]
    		        );
    		        break;
    		}
    		return $order;
    	}
    	 
    	return false;
    }

}