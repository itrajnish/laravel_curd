<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use DB;
use File;
use App\Book;

class UserController extends Controller
{
    public function index()

    {
    	//$name = 'Hello World';
    	//return view('welcome')->with('name',$name);
    	//return view('welcome')->with(compact('name'));
    	//return view('welcome',compact('name'));
    	 //$users=User::get()->toArray();
		 //$users=DB::table('users')->get();
        $books=Book::with('user')->get()->toArray();
        $users=User::with('books')->get()->toArray();

		 $users=json_decode(json_encode($users),true);
    	 
    	// echo "<pre>";
    	 //print_r($users);
        //print_r($books);

    	 //die;

    	//return view('welcome' , ['name'=> $name]);
    	return view('welcome' , ['users'=> $users]);
    }
    public function userdata (Request $request)
    {
    	$data = $request->all();
    	// $data = $request->input();
    	// echo "<pre>";
    	// print_r($data);
    	// die;
if(!empty($data)){


    $imgname='';
if($request->hasFile('image')){
    $file=$request->file('image');
    $filename=$file->getClientOriginalName();
    $extension=$file->getClientOriginalExtension();
    if($extension=='jpg' || $extension=='png' || $extension=='jpeg'){
        $imgname=uniqid().$filename;
        $destinationPath=public_path('/img/');
        $file->move($destinationPath,$imgname);
    }else{
        $request->session()->flash('alert-danger','File Type Not Valid');
        return redirect()->back();
    }



}else{
    $imgname='';

}

	try{
	//DB::table('users')->insert(['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email'],'image'=>$imgname]);

	//$id=\DB::table('users')->insertGetId(['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']]);
	$user = new user();
	$user->name=$data['name'];
	$user->email=$data['email'];
	$user->mobile=$data['mobile'];
    $user->image=$imgname;
	$user->save();	

    // when Multiple option selected then run below code   

foreach ($data['book'] as $key => $value) {
    $book = new Book();
    $book->book = $value;
    $book->user_id = $user->id;
    $book->save();
}

    // when single option selected then run below code
/*    $book = new Book();
    $book->book = $data['book'];
    $book->user_id = $user->id;
    $book->save();
*/


	//user::create(['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']]);



}catch(\Exception $e){
	$request->session()->flash('alert-danger',$e->getMessage());
	return redirect()->back();
}
	$message = 'User Added sucessfully';
	//$message = $id.' '.'User Added sucessfully';
	//$request->session()->flash('alert-success','User Added sucessfully');
	$request->session()->flash('alert-success',$message);
	return redirect()->back();

}else{
	return redirect()->back();
}

    }

 public function editusers($id)
    {
    	$id=convert_uudecode(base64_decode($id));
    	//echo $id; die();
    	//$userdata = User::where('id',$id)->first()->toArray();
        $userdata = User::with('books')->where('id',$id)->first()->toArray();


    	//$userdata=DB::table('users')->where('id',$id)->first();
		$userdata=json_decode(json_encode($userdata),true);    	
    	return view('editusers',['userdata'=>$userdata]);
    }
 public function updateusers(Request $request)
 {

$data=$request->all();
if($request->hasFile('image')){

    $oldimage=User::where('id',$data['user_id'])->value('image');
    $fullpath = public_path('/img/').$oldimage;
    File::delete($fullpath);

    $file=$request->file('image');
    $filename=$file->getClientOriginalName();
    $extension=$file->getClientOriginalExtension();
    $imgname=uniqid().$filename;
    $destinationPath=public_path('/img/');
    $file->move($destinationPath,$imgname);
}else{
    $imgname=User::where('id',$data['user_id'])->value('image');

}

try {
	
 	DB::table('users')->where('id',$data['user_id'])->update(['name'=>$data['name'], 
												'mobile'=>$data['mobile'], 
												'email'=>$data['email'],
                                                'image'=>$imgname
 												]);
    Book::where('user_id',$data['user_id'])->update(['book'=>$data['book']]);
 	$request->session()->flash('alert-success','User Updated Successfully');
} catch (\Exception $e) {
	 	$request->session()->flash('alert-danger','Failed');
	
}
return redirect()->to('/');
 	// echo "<pre>";
 	// print_r($data);
 	// die();
 }
 public function deleteusers(Request $request, $id)
     {
     	$id=convert_uudecode(base64_decode($id));
     	try {

                $oldimage=User::where('id',$id)->value('image');
                $fullpath = public_path('/img/').$oldimage;
                File::delete($fullpath);   

            
     		    DB::table('users')->where('id',$id)->delete();
                DB::table('books')->where('user_id',$id)->delete();

             


     		    $request->session()->flash('alert-success','User Delete Successfully');
     		
     	} catch (\Exception $e) {
     		$request->session()->flash('alert-danger','Failed');
     	}
     	return redirect()->back();
     }    
}