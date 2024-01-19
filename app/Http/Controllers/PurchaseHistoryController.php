<?php

namespace App\Http\Controllers;

use App\Models\PurchaseHistory;
use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    public $title;
    function __construct(Request $request)
    {
        $this->title = "purchase";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = PurchaseHistory::orderBy('purchase_date','DESC')->get();
        return view('purchase.index',compact('data','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $machine = Machine::all();
        $clients = User::role('Clients')->get();
        return view('purchase.create',compact('title','machine','clients'));
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
            'machine_id' => 'required',
            'client_id' => 'required',
            'purchase_date' => 'required',
            'bill_no' => 'required',
            'file' => 'required',
        ]);

        $purchaseHistory = new PurchaseHistory();
        $purchaseHistory['machine_id'] = $request->machine_id;
        $purchaseHistory['bill_no'] = $request->bill_no;
        $purchaseHistory['client_id'] = $request->client_id;
        $purchaseHistory['purchase_date'] = $request->purchase_date;
        $purchaseHistory['photo'] = storeFile($request->file,$title);
        $purchaseHistory->save();

        return redirect()->route("$title.index")->with('success',ucfirst($title)." created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseHistory  $purchaseHistory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $purchase = PurchaseHistory::find($id);
        return view("purchase.show",compact('purchase','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseHistory  $purchaseHistory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $purchase = PurchaseHistory::find($id);
        $machine = Machine::all();
        $clients = User::role('Clients')->get();
        return view('purchase.edit',compact('purchase','title','machine','clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseHistory  $purchaseHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $title = $this->title;
        $this->validate($request, [
            'machine_id' => 'required',
            'client_id' => 'required',
            'purchase_date' => 'required',
            'bill_no' => 'required',
        ]);

        $purchaseHistory = PurchaseHistory::find($id);
        $purchaseHistory['machine_id'] = $request->machine_id;
        $purchaseHistory['bill_no'] = $request->bill_no;
        $purchaseHistory['client_id'] = $request->client_id;
        $purchaseHistory['purchase_date'] = $request->purchase_date;
        if($request->file){
            $purchaseHistory['photo'] = storeFile($request->file,$title);
        }
        $purchaseHistory->save();

        return redirect()->route("$title.index")->with('success',ucfirst($title)." updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseHistory  $purchaseHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $title = $this->title;
        $purchaseHistory = PurchaseHistory::find($id);
        $purchaseHistory->delete();
        return redirect()->route("$title.index")->with('success',ucfirst($title).' deleted successfully');
    }
}
