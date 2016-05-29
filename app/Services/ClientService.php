<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 16/05/2016
 * Time: 18:36
 */

namespace CodeDelivery\Services;


use CodeDelivery\Http\Requests\AdminClientRequest;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;

class ClientService
{
    /**
     * @var ClientRepository
     */
    private $repository;

    public function __construct(ClientRepository $repository, UserRepository $userRepository){

        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function index(){
        $clients = $this->repository->paginate(5);
        return view('admin.clients.index', compact("clients"));
    }

    public function create(){
        $users = $this->userRepository->findWhere([['role', '<>', 'admin']])->lists('name', 'id');
        return view('admin.clients.create', compact("users"));
    }

    public function store(AdminClientRequest $request){
        $data = $request->all();
        $this->repository->create($data);

        return redirect()->route('admin.clients.index');
    }

    public function edit($id){
        $client = $this->repository->with('user')->find($id);
        return view('admin.clients.edit', compact("client"));
    }

    public function update(array $data, $id){
        $client = $this->repository->update($data, $id);
        $this->userRepository->update($data['user'], $client->user_id);
        return redirect()->route('admin.clients.index');
    }

    public function destroy($id){
        $this->repository->delete($id);
        return redirect()->route('admin.clients.index');
    }
}