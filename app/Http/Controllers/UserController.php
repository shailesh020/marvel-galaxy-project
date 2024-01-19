<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $title;
    function __construct(Request $request)
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->title = "users";
        $uri = $request->route();
        if($uri){
            $uri = $request->route()->uri;
            $uri = explode('/',$uri)[0];
        }
        if($uri == 'clients'){
            $this->title = "clients";
        }elseif ($uri == 'engineers') {
            $this->title = "engineers";
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = User::orderBy('id','DESC');
        if($title == 'clients'){
            $data = $data->whereHas('roles',function($q){
                $q->where('name','Clients');
            });
        }elseif ($title == 'engineers') {
            $data = $data->whereHas('roles',function($q){
                $q->where('name','Engineers');
            });
        }
        $data = $data->get();
        return view('users.index',compact('data','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles','title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $this->title;
        if($title != 'clients'){
            $this->validate($request, [
                'name' => 'required',
                'dob' => 'required',
                'residential_address' => 'required',
                'native_address' => "required",
                'email' => 'required|email',
                'phone_no' => 'required',
                'alternet_phone_no' => 'required',
                'file' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'name' => 'required',
                'dob' => 'required',
                'residential_address' => 'required',
                'office_address' => 'required',
                'ohter_office_address' => 'required',
                'email' => 'required|email',
                'phone_no' => 'required',
            ]);
        }

        $input = $request->all();
        if ($request->file) {
            $fileName = time().'.'.$request->file->extension();
            $request->file->move(public_path("file/$title"), $fileName);
            $input['file'] = $fileName;
        }
        $input['password'] = Hash::make('password');
        $role = $title == 'clients' ? 'Clients' : 'Engineers';
        $user = User::create($input);
        $user->assignRole($role);

        return redirect()->route("$title.index")->with('success',ucfirst($title)." created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $title = $this->title;
        return view('users.show',compact('user','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $title = $this->title;
        return view('users.edit',compact('user','roles','userRole','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $title = $this->title;
        if($title != 'clients'){
            $this->validate($request, [
                'name' => 'required',
                'dob' => 'required',
                'residential_address' => 'required',
                'native_address' => "required",
                'email' => 'required|email',
                'phone_no' => 'required',
                'alternet_phone_no' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'name' => 'required',
                'dob' => 'required',
                'residential_address' => 'required',
                'office_address' => 'required',
                'ohter_office_address' => 'required',
                'email' => 'required|email',
                'phone_no' => 'required',
            ]);
        }

        $input = $request->all();
        if ($request->file) {
            $fileName = time().'.'.$request->file->extension();
            $request->file->move(public_path("file/$title"), $fileName);
            $input['file'] = $fileName;
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $role = $title == 'clients' ? 'Clients' : 'Engineers';
        $user->assignRole($role);

        return redirect()->route("$title.index")->with('success',ucfirst($title).' updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $title = $this->title;
        User::find($id)->delete();
        return redirect()->route("$title.index")->with('success',ucfirst($title).' deleted successfully');
    }
}
