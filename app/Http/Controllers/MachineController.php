<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\MachineImage;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public $title;
    function __construct(Request $request)
    {
        $this->title = "machine";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = Machine::orderBy('id','DESC')->get();
        return view('machine.index',compact('data','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        return view('machine.create',compact('title'));
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
            'description' => 'required',
            'photos' => 'required',
            'code' => 'required',
        ]);


        $input = ['name' => $request->name,'description' => $request->description,'code'=>$request->code];
        $machine = Machine::create($input);
        if ($request->photos) {
            foreach ($request->photos as $key => $photo) {
                $machine_photo = new MachineImage();
                $machine_photo['machine_id'] = $machine->id;
                $machine_photo['photo'] = storeFile($photo,$title);
                $machine_photo->save();
            }
        }

        return redirect()->route("$title.index")->with('success',ucfirst($title)." created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function show(Machine $machine)
    {
        $title = $this->title;
        return view("machine.show",compact('machine','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function edit(Machine $machine)
    {
        $title = $this->title;
        return view('machine.edit',compact('machine','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Machine $machine)
    {
        $title = $this->title;
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'code'=>'required',
        ]);

        $machine['name']= $request->name;
        $machine['description'] = $request->description;
        $machine['code'] = $request->code;
        $machine->save();

        if ($request->photos) {
            foreach ($request->photos as $key => $photo) {
                $machine_photo = new MachineImage();
                $machine_photo['machine_id'] = $machine->id;
                $machine_photo['photo'] = storeFile($photo,$title);
                $machine_photo->save();
            }
        }

        return redirect()->route("$title.index")->with('success',ucfirst($title)." updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machine $machine)
    {
        $title = $this->title;
        $machine_photo = MachineImage::where('machine_id',$machine->id)->pluck('id')->toArray();
        MachineImage::destroy($machine_photo);
        $machine->delete();
        return redirect()->route("$title.index")->with('success',ucfirst($title).' deleted successfully');
    }

    public function removeMachineImage($id)
    {
        $machine_photo = MachineImage::find($id);
        if($machine_photo){
            $machine_photo->delete();
            return response()->json(['status' => 'success','msg' => 'image remove']);
        }else{
            return response()->json(['status' => 'error','msg' => 'image not found!']);
        }
    }
}
