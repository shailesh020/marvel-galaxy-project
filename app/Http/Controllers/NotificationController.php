<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Models\ClientGroup;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public $title;
    function __construct(Request $request)
    {
        $this->title = "notification";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $data = Notification::orderBy('id','DESC')->get();
        return view('notification.index',compact('data','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $groups = ClientGroup::all();
        return view('notification.create',compact('title','groups'));
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
            'date' => 'required',
            'time' => 'required',
            'note' => 'required',
            'group' => 'required',
        ]);

        $Notification = new Notification();
        $Notification['name'] = $request->name;
        $Notification['date'] = $request->date;
        $Notification['time'] = $request->time;
        $Notification['note'] = $request->note;
        $Notification['group'] = json_encode($request->group);
        $Notification->save();

        return redirect()->route("$title.index")->with('success',ucfirst($title)." created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        $title = $this->title;
        return view('notification.show',compact('title','notification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        $title = $this->title;
        $groups = ClientGroup::all();
        return view('notification.edit',compact('title','groups','notification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        $title = $this->title;
        $this->validate($request, [
            'name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'note' => 'required',
            'group' => 'required',
        ]);

        $notification['name'] = $request->name;
        $notification['date'] = $request->date;
        $notification['time'] = $request->time;
        $notification['note'] = $request->note;
        $notification['group'] = json_encode($request->group);
        $notification->save();

        return redirect()->route("$title.index")->with('success',ucfirst($title)." updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $title = $this->title;
        $notification->delete();
        return redirect()->route("$title.index")->with('success',ucfirst($title).' deleted successfully');
    }
}
