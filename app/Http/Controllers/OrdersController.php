<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminOrderRequest;
use CodeDelivery\Repositories\OrderRepository;

use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\UserRepository;

class OrdersController extends Controller
{

    /**
     * @var OrderRepository
     */
    private $repository;
    /**
     * @var OrderRepository
     */
    private $userRepository;

    public function __construct(OrderRepository $repository, UserRepository $userRepository){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function index(){
        $orders = $this->repository->paginate(5);
        return view('admin.orders.index', compact("orders"));
    }

    public function create(){
        $users = $this->userRepository
            ->findWhere(['role' => 'admin'])
            ->lists('name', 'id');
        return view('admin.orders.create', compact("users"));
    }

    public function store(AdminOrderRequest $request){
        $data = $request->all();
        $this->repository->create($data);

        return redirect()->route('admin.orders.index');
    }

    public function edit($id){
        $order = $this->repository->find($id);
        $users = $this->userRepository
            ->findWhere(['role' => 'admin'])
            ->lists('name', 'id');
        
        $status = [
            1 => 'Solicitado',
            2 => 'Em transporte',
            3 => 'Entregue',
            4 => 'Cancelado'
        ];
        return view('admin.orders.edit', compact("order", "users", "status"));
    }

    public function update(AdminOrderRequest $request, $id){
        $data = $request->all();
        $this->repository->update($data, $id);
        return redirect()->route('admin.orders.index');
    }

    public function destroy($id){
        $this->repository->delete($id);
        return redirect()->route('admin.orders.index');
    }
}
