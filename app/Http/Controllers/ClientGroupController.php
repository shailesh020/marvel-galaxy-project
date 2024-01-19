<?php

namespace App\Http\Controllers;

use App\Models\ClientGroup;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientGroupController extends Controller
{
    public $title;
    function __construct(Request $request)
    {
        $this->title = "client-group";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = ClientGroup::orderBy('id','DESC')->get();
      
        return view('client-group.index',compact('data','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $clients = User::role('Clients')->get();
        return view('client-group.create',compact('title','clients'));
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
        $this->validate($request, [
            'name' => 'required',
            'perpose' => 'required',
            'client' => 'required',
        ]);

        $group = new ClientGroup();
        $group['name'] = $request->name;
        $group['perpose'] = $request->perpose;
        $group['client'] = json_encode($request->client);
        $group->save();

        return redirect()->route("$title.index")->with('success',ucfirst($title)." created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientGroup  $clientGroup
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $group = ClientGroup::find($id);
        return view('client-group.show',compact('title','group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientGroup  $clientGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $clients = User::role('Clients')->get();
        $group = ClientGroup::find($id);
        return view('client-group.edit',compact('title','clients','group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientGroup  $clientGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientGroup $clientGroup)
    {
        $title = $this->title;
        $this->validate($request, [
            'name' => 'required',
            'perpose' => 'required',
            'client' => 'required',
        ]);

        $clientGroup['name'] = $request->name;
        $clientGroup['perpose'] = $request->perpose;
        $clientGroup['client'] = json_encode($request->client);
        $clientGroup->save();

        return redirect()->route("$title.index")->with('success',ucfirst($title)." updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientGroup  $clientGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientGroup $clientGroup)
    {
        $title = $this->title;
        $clientGroup->delete();
        return redirect()->route("$title.index")->with('success',ucfirst($title).' deleted successfully');
    }
}
