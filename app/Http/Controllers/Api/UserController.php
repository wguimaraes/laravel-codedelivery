<?php

namespace CodeDelivery\Http\Controllers\Api;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class UserController extends Controller
{
	
	protected $repository;
	protected $userId;
	
    public function __construct(UserRepository $repository){
    	$this->repository = $repository;
    	$this->userId = Authorizer::getResourceOwnerId();
	}
	
	public function authenticated(){
		return $this->repository->skipPresenter(false)->find($this->userId);
	}
	
	public function updateDeviceToken(Request $request){
	    $deviceToken = $request->get('device_token');
	    return $this->repository->updateDeviceToken($this->userId, $deviceToken);
	}
}
