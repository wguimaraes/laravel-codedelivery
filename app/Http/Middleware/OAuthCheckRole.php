<?php

namespace CodeDelivery\Http\Middleware;

use Closure;
use CodeDelivery\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class OAuthCheckRole
{
	
	protected $userRepository;
	
	function __construct(UserRepository $userRepository){
		$this->userRepository = $userRepository;
	}
	
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role) //aqui adicionamos um parametro para o middleware
    {
		
	    $userId = Authorizer::getResourceOwnerId();
	    
	    $user = $this->userRepository->find($userId);
	    if(!$user || $user->role != $role){
	    	abort(403, 'Access forbidden.');
	    }

        return $next($request);
    }
}
