<?php

namespace CodeDelivery\Http\Controllers\Api\DeliveryMan;

use CodeDelivery\Http\Controllers\Controller;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Illuminate\Http\Request;

class DeliveryManCheckoutController extends Controller
{
/**
     * @var OrderRepository
     */
    private $repository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var OrderService
     */
    private $service;
    
    private $userId;
    
    private $withList = ['items'];
    private $withShow = ['client','items','deliveryMan', 'cupom'];

    public function __construct(
        OrderRepository $repository, UserRepository $userRepository,
        OrderService $service
    )
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->service = $service;
        $this->userId = Authorizer::getResourceOwnerId();
    }

    public function index(){
    	$userId = $this->userId;
        $orders = $this->repository->skipPresenter(false)
        			   ->with($this->withList)
        			   ->scopeQuery(function($query) use($userId){
            return $query->where('deliveryman_id', '=', $userId);
        })->all();

        return $orders;
    }
    
    public function show($id){
    	return $this->repository->skipPresenter(false)->getByIdAndDeliveryMan($id, $this->userId);
    }
    
    public function updateStatus(Request $request, $id){
    	$order = $this->service->updateStatus($id, $this->userId, $request->get('status'));
    	if($order){
    		return $order;
    	}
    	abort(400, "Ordem não encontrada.");
    }
}
