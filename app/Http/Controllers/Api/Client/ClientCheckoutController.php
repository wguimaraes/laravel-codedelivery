<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use Illuminate\Http\Request;

use CodeDelivery\Http\Controllers\Controller;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientCheckoutController extends Controller
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
    private $orderService;
    
    private $userId;

    public function __construct(
        OrderRepository $repository, UserRepository $userRepository,
        OrderService $orderService
    )
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
        $this->userId = Authorizer::getResourceOwnerId();
    }

    public function index(){
        $clientId = $this->userRepository->find($this->userId)->client->id;
        $orders = $this->repository->with('items')->scopeQuery(function($query) use($clientId){
            return $query->where('client_id', '=', $clientId);
        })->all();

        return $orders;
    }

    public function store(Request $request){
        $data = $request->all();
        $clientId = $this->userRepository->find($this->userId)->client->id;
        $data['client_id'] = $clientId;
		$order = $this->orderService->create($data);
		
        return $this->repository->with('items')->find($order->id);
    }
    
    public function show($id){
    	$order = $this->repository->with(['client','items','delivaryMan', 'cupom'])->find($id);
    	$order->items->each(function($item){
    		$item->product;
    	});
    	
    	return $order;
    }
}
