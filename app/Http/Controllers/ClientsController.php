<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminClientRequest;

use CodeDelivery\Http\Requests;
use CodeDelivery\Services\ClientService;

class ClientsController extends Controller
{

    /**
     * @var ClientService
     */
    private $service;

    public function __construct(ClientService $service){

        $this->service = $service;
    }

    public function index(){
       return $this->service->index();
    }

    public function create(){
        return $this->service->create();
    }

    public function store(AdminClientRequest $request){
        return $this->service->store($request);
    }

    public function edit($id){
        return $this->service->edit($id);
    }

    public function update(AdminClientRequest $request, $id){
        return $this->service->update($request->all(), $id);
    }

    public function destroy($id){
        return $this->service->destroy($id);
    }
}
