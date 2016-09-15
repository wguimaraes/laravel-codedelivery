<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Requests\CheckoutRequest;

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
    
    private $withList = ['items'];
    private $withShow = ['client','items','deliveryMan', 'cupom'];

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
        $orders = $this->repository
        			   ->skipPresenter(false)
        			   ->with($this->withList)
        			   ->scopeQuery(function($query) use($clientId){
            return $query->where('client_id', '=', $clientId);
        })->all();

        return $orders;
    }

    public function store(CheckoutRequest $request){
        $data = $request->all();
        $clientId = $this->userRepository->find($this->userId)->client->id;
        $data['client_id'] = $clientId;
		$order = $this->orderService->create($data);
		
        return $this->repository->skipPresenter(false)->with($this->withShow)->find($order->id);
    }
    
    public function show($id){
    	$order = $this->repository->skipPresenter(false)->with($this->withShow)->find($id);
    	return $order;
    }
}
