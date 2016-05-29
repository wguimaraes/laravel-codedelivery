<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests\AdminCupomRequest;
use CodeDelivery\Repositories\CupomRepository;

use CodeDelivery\Http\Requests;

class CupomsController extends Controller
{

    /**
     * @var CupomRepository
     */
    private $repository;

    public function __construct(CupomRepository $repository){

        $this->repository = $repository;
    }

    public function index(){
        $cupoms = $this->repository->paginate(5);
        return view('admin.cupoms.index', compact("cupoms"));
    }

    public function create(){
        $cupom = (object)["code" => rand(100, 10000)];
        return view('admin.cupoms.create', compact("cupom"));
    }

    public function store(AdminCupomRequest $request){
        $data = $request->all();
        $this->repository->create($data);

        return redirect()->route('admin.cupoms.index');
    }

    public function edit($id){
        $cupom = $this->repository->find($id);
        return view('admin.cupoms.edit', compact("cupom"));
    }

    public function update(AdminCupomRequest $request, $id){
        $data = $request->all();
        $this->repository->update($data, $id);
        return redirect()->route('admin.cupoms.index');
    }

    public function destroy($id){
        $this->repository->delete($id);
        return redirect()->route('admin.cupoms.index');
    }
}
