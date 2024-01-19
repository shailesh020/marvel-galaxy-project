<?php

namespace App\Http\Controllers;

use App\Models\Campaigning;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaigningController extends Controller
{
    public $title;
    function __construct(Request $request)
    {
        $this->title = "campaigning";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = Campaigning::orderBy('id','DESC')->get();
        return view('campaigning.index',compact('data','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        return view('campaigning.create',compact('title'));
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
            'start_date' => 'required',
            'end_date' => 'required',
            'note' => 'required',
            'file' => 'required',
        ]);

        $purchaseHistory = new Campaigning();
        $purchaseHistory['name'] = $request->name;
        $purchaseHistory['start_date'] = $request->start_date;
        $purchaseHistory['end_date'] = $request->end_date;
        $purchaseHistory['note'] = $request->note;
        $purchaseHistory['photo'] = storeFile($request->file,$title);
        $purchaseHistory->save();

        return redirect()->route("$title.index")->with('success',ucfirst($title)." created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaigning  $campaigning
     * @return \Illuminate\Http\Response
     */
    public function show(Campaigning $campaigning)
    {
        $title = $this->title;
        return view('campaigning.show',compact('title','campaigning'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaigning  $campaigning
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaigning $campaigning)
    {
        $title = $this->title;
        return view('campaigning.edit',compact('campaigning','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaigning  $campaigning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaigning $campaigning)
    {
        $title = $this->title;
        $this->validate($request, [
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'note' => 'required',
        ]);

        $campaigning['name'] = $request->name;
        $campaigning['start_date'] = $request->start_date;
        $campaigning['end_date'] = $request->end_date;
        $campaigning['note'] = $request->note;
        if($request->file){
            $campaigning['photo'] = storeFile($request->file,$title);
        }
        $campaigning->save();

        return redirect()->route("$title.index")->with('success',ucfirst($title)." updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaigning  $campaigning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaigning $campaigning)
    {
        $title = $this->title;
        $campaigning->delete();
        return redirect()->route("$title.index")->with('success',ucfirst($title).' deleted successfully');
    }
}
