<?php

namespace App\Http\Controllers\Api;

use Hash;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Permission;
use App\Models\Orders;
use App\Models\UserPermission;
use App\Models\WarehouseDetail;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\OrderProduct;
use App\Models\Currency;
use App\Models\UserLevel;
use App\Models\UserAccount;
use App\Models\AppLink;
use App\Models\UserLog;
use App\Models\Keywords;
use App\Models\fileUpload;
use App\Models\UserDetail;
use App\Models\saveFileData;
use Illuminate\Http\Request;
use App\Models\fileProcessLogs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;
   


class AdminController extends BaseController
{
    public function getAdminInfo(Request $request)
    {

   		if(Auth::guard('api')->check()){
   			if(Auth::guard('api')->user()->is_admin == 1){
   				$user = Auth::guard('api')->user();
   				return $this->sendResponse($user, 'user is admin');
   			}else{
   				return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
   			}
   		}else{
   			return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
   		}
    }
	public function updateAdminInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.Auth::guard('api')->user()->id,
			'name' => 'required',
            'username' => 'required|unique:users,username,'.Auth::guard('api')->user()->id,
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		
        $adminUser = User::where('email', Auth::guard('api')->user()->email)->first();
		$adminUser->username = $request->username;
		$adminUser->name = $request->name;
		$adminUser->email = $request->email;
        $adminUser->save();

        $success['user_id'] =  $adminUser->id;
   
        return $this->sendResponse($success, 'User updated successfully.');
    }
	public function updatePassword(Request $request)
    {
		try {
			$validator = Validator::make($request->all(), [
				'old_password' => 'required',
				'password' => 'required|same:confirm_password',
				'confirm_password' => 'required',
			]);
	   
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			if(Auth::attempt(['email' => Auth::guard('api')->user()->email, 'password' => $request->old_password])){ 
				if($request->password == $request->confirm_password){
					$adminUser = User::where('email', Auth::guard('api')->user()->email)->first();
					$adminUser->password = bcrypt($request->password);
					$adminUser->save();
					$success['user_id'] =  $adminUser->id;
					return $this->sendResponse($success, 'Password changed successfully.');
				}else{
					return $this->sendError('mismatched', 'Please make sure new and confirm password is same');    
				}
			}else{
				return $this->sendError('old password invalid', 'Cannot verify old password');
			}
		  } catch (\Exception $e) {
			  return $e->getMessage();
		}
    }
	public function updateEmail(Request $request)
	{
		try{
			$validator = Validator::make($request->all(), [
				'email' => 'required|same:repeat_email',
				'repeat_email' => 'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			
			if($request->email == $request->repeat_email){
				$adminUser = User::where('email', Auth::guard('api')->user()->email)->first();
				$adminUser->email = $request->email;
				$adminUser->save();
				$success['user_id'] =  $adminUser->id;
				return $this->sendResponse($success, 'Email updated successfully.');
			}else{
				return $this->sendError('Something goes wrong', 'Cannot update data');
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getAppLinks(){
		try {
			$data = AppLink::orderBy('id','desc')->get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getUserLogs(){
		try {
			$data = UserLog::orderBy('id','desc')->get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getUsers(){
		try {
			$data = User::orderBy('id','desc')->get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function createUser(Request $request){
		try {
			$validator = Validator::make($request->all(), [
				'email' => 'required|email|unique:users',
				'name' => 'required',
				'last_name' => 'required',
				
			]);
			if($request->isRandomPassword == 1){
				$request->password = bcrypt(rand(1000,100000));
			} else {
				$validator = Validator::make($request->all(), [
					'email' => 'required|email|unique:users',
					'name' => 'required',
					// 'last_name' => 'required',
					'country' => 'required',
					'province' => 'required',
					'city' => 'required',
					'address' => 'required',
					'postcode' => 'required',
					'phone' => 'required',
					'contact' => 'required',
					'currency_id' => 'required',
					
					'password' => 'required|same:confirm_password',
					'confirm_password' => 'required',
					'status'=>'required',
					'user_level'=>'required',

				]);
				if($validator->fails()){
					return response()->json(['status'=>422,'message' => $validator->errors()]);
				}
				if($request->user_level == 3)
				{
					$validator = Validator::make($request->all(), [
						
						'w_name'=>'required',
						'w_email'=>'required|email|unique:warehouse_details',
						'w_country'=>'required',
						'w_province'=>'required',
						'w_city'=>'required',
						'w_postcode'=>'required',
						'w_address'=>'required',
						'w_phone'=>'required',
						'w_contact'=>'required',
						'w_location_index'=>'required',
					]);
				}
				$request->password = bcrypt($request->password);
			}
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			
			$user = New User;
			$user->email = $request->email;
			$user->name = $request->name;
			//$user->last_name = $request->last_name;
			$user->country = $request->country;
			$user->province = $request->province;
			$user->city = $request->city;
			$user->address = $request->address;
			$user->phone = $request->phone;
			$user->contact = $request->contact;
			$user->postcode = $request->postcode;
			$user->currency_id = $request->currency_id;
			
			$user->status = $request->status;
			
			$user->password = $request->password;
			
			if($user->save()){
				foreach($request->user_level as $ul)
				{
					$user_level[] = ['user_id'=>$user->id,'user_level_id'=>$ul['value']];
				}
				$user_account = UserAccount::insert($user_level);
				// return response()->json(['status'=>422,'message' => $user_level]);
				return $this->sendResponse($user,'Data has been Added');	
			} 
			
			else {
				return $this->sendResponse('Something goes wrong',false);
			}
		}
		
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function addWarehouseDetail(Request $request)
	{
		try{
			$validator = Validator::make($request->all(), [
				'user_id' => 'required',
				'name' => 'required',
				'location' => 'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			$warehouse = new WarehouseDetail;
			$warehouse->user_id = $request->user_id;
			$warehouse->name = $request->name;
			$warehouse->location = $request->location;
			if($warehouse->save())
			{
				return $this->sendResponse($warehouse,'Data has been Added');
			}
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
		
	}
	public function updateProfileInfo(Request $request){
		try {
			$validator = Validator::make($request->all(), [
				'email' => 'required|email',
					'name' => 'required',
					// 'last_name' => 'required',
					'country' => 'required',
					'province' => 'required',
					'city' => 'required',
					'address' => 'required',
					'postcode' => 'required',
					'phone' => 'required',
					'contact' => 'required',
					'currency_id' => 'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
		$user = User::find(Auth::guard('api')->user()->id);
		$user->name = $request->name;
		//$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->country = $request->country;
		$user->province = $request->province;
		$user->city = $request->city;
		$user->address = $request->address;
		$user->postcode = $request->postcode;
		$user->phone = $request->phone;
		$user->contact = $request->contact;
		$user->currency_id = $request->currency_id;
		
		if($user->save()){
			
			return $this->sendResponse($user,'Data has been updted');
		} else {
			return $this->sendResponse('Something goes wrong',false);
		}

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getPermissions($user_level){
		try {
			 
			$data = UserPermission::select('permissions.title')->join('permissions', 'permissions.id', '=', 'user_permissions.permission_id')->
			where('user_permissions.user_level_id', $user_level)->get()->toArray();

			foreach($data as $mydata)
			{
				$data1[] = $mydata['title'];
			}

			return $this->sendResponse($data1,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getRelUsers($user_level){
		try {
			 
			$data = User::where('user_level_id', $user_level)->where('status',1)->get()->toArray();

			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function saveOrder(Request $request){
		try {
			$validator = Validator::make($request->all(), [
				'title' => 'required',
				'description' => 'required',
				'quantity' => 'required',
				'type' => 'required',
				'created_by' => 'required',
				'created_for' => 'required',
				'product_id'=>'required'
			]);
			
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			$order = new Orders;
			$order->title = $request->title;
			$order->description = $request->description;
			$order->created_by = $request->created_by;
			$order->created_for = $request->created_for;
			$order->type = $request->type;
			$order->status = $request->status;
			if($order->save()){
				$order_products = new OrderProduct;
				$order_products->order_id = $order->id;
				$order_products->product_id = $request->product_id;
				$order_products->quantity = $request->quantity;
				if($order_products->save())
				{
					return $this->sendResponse($order,'Order was created');
				}
				
			} else {
				return $this->sendResponse('Something goes wrong',false);
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getOrders($user_id, $user_level){
		try {
			if($user_level != 1)
			{
				$data = Orders::where('created_for', $user_id)->orderBy('id','desc')->get();
			}
			else{
				$data = Orders::orderBy('id','desc')->get();
			}
			
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getUserDetail($user_id){
		try {
			$data = User::select('users.*','currencies.currency')->
			join('currencies','users.currency_id', '=', 'currencies.id')->
			where('users.id', $user_id)->first();

			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function UpdateUserInfo(Request $request){
		try{
			$user_level = $request->user_level;
			$request->request->remove('user_level');
			$user = User::find($request->id);
			$user->fill($request->all());
			if($user->save())
			{
				foreach($user_level as $ul)
				{
					$user_level1[] = ['user_id'=>$request->id,'user_level_id'=>$ul['value']];
				}
				$user_account = UserAccount::where('user_id',$request->id)->delete();
				$user_account = UserAccount::insert($user_level1);
			
				if($user_account)
				{
					return $this->sendResponse($user_account,'Record was updated');
				}
				//return response()->json(['status'=>422, 'message'=>$user_level]);
				
			}
			
		
		//return response()->json(['status'=>422, 'message'=>$request->all()]);
		}
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getWarehouseDetail($user_id){
		try {
			
				$data = WarehouseDetail::where('user_id', $user_id)->orderBy('id','desc')->get();
			
			
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getWarehouse($warehouse_id){
		try {
			
				$data = WarehouseDetail::where('id', $warehouse_id)->first();
			
			
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function addProductType(Request $request)
	{
		try{
			$validator = Validator::make($request->all(), [
				'type' => 'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			$product_type = ProductType::create($request->all());
			
			if($product_type)
			{
				return $this->sendResponse($product_type,'Data has been Added');
			}
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
		
	}
	public function addProduct(Request $request)
	{
		try{
			$validator = Validator::make($request->all(), [
				'type_id' => 'required',
				'name' => 'required',
				'width' => 'required',
				'length' => 'required',
				'weight' => 'required',
				'description' => 'required',
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			$product = Product::create($request->all());
			
			if($product)
			{
				return $this->sendResponse($product,'Data has been Added');
			}
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
		
	}

	public function getProductTypes(){
		try {
			
			$data = ProductType::orderBy('id','desc')->get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getAllProducts(){
		try {
			
			$data = Product::select('products.*','product_types.type')->
			join('product_types','products.type_id','=','product_types.id')->
			get()->toArray();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getAllCurrencies(){
		try {
			
			$data = Currency::get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getProfileInfo(){
		try {
			
			$data = User::where('id',Auth::guard('api')->user()->id)->first();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getSingleProduct($product_id){
		try {
			
			$data = Product::where('id',$product_id)->first();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function updateProduct(Request $request){
		try{
			$validator = Validator::make($request->all(), [
				'type_id' => 'required',
				'name' => 'required',
				'width' => 'required',
				'length' => 'required',
				'weight' => 'required',
				'description' => 'required',
				
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			$product = Product::find($request->id);
		$product->fill($request->all());
		if($product->save())
		{
			return $this->sendResponse($product,'Record was updated');
		}

		}
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getSingleOrder($order_id){
		try {
			
			$data = Orders::where('id',$order_id)->first();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function getAllUserLevels(){
		try {
			
			$data = UserLevel::where('id','!=',1)->get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getUserLevels($user_id){
		try {
			$data = UserAccount::select('user_levels.*')->
			join('user_levels', 'user_levels.id', '=', 'user_accounts.user_level_id')->
			where('user_accounts.user_id', $user_id)->get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getAllRoles(){
		try {
			
			$data = UserLevel::get();
			return $this->sendResponse($data,true);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function UpdateWarehouse(Request $request){
		try{
			$validator = Validator::make($request->all(), [
				'name'=>'required',
						'w_email'=>'required|email',
						'country'=>'required',
						'province'=>'required',
						'city'=>'required',
						'postcode'=>'required',
						'address'=>'required',
						'phone'=>'required',
						'contact'=>'required',
						'location_index'=>'required',
				
			]);
			if($validator->fails()){
				return response()->json(['status'=>422,'message' => $validator->errors()]);
			}
			$product = WarehouseDetail::find($request->id);
		$product->fill($request->all());
		if($product->save())
		{
			return $this->sendResponse($product,'Record was updated');
		}

		}
		catch (\Exception $e) {
			return $e->getMessage();
		}
	}

}