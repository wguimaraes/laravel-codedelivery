<?php

namespace CodeDelivery\Http\Requests;

use CodeDelivery\Http\Requests\Request;
use Illuminate\Http\Request as Req;

class CheckoutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Req $request)
    {
    	$rules = [];
    	$items = $request->get('items');
        if($items && is_array($items)){
        	foreach($items as $key => $item){
        		$this->buildRuleItems($key, $rules);
        	}
        }else{
        	$this->buildRuleItems(0, $rules);
        }
        return $rules;
    }
    
    public function buildRuleItems($key, &$rules){
    	$rules["items.$key.product_id"] = 'required';
    	$rules["items.$key.qtd"] = 'required';
    }
}
