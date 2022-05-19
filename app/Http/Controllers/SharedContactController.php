<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\SharedContact;
use App\Http\Requests\StoreSharedContactRequest;
use App\Http\Requests\UpdateSharedContactRequest;
use App\Models\User;
use App\Notifications\ContactShareNoti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SharedContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSharedContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSharedContactRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SharedContact  $sharedContact
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,SharedContact $sharedContact)
    {
        if($sharedContact->status){
            return abort(404);
        }


        $from = User::find($sharedContact->from);
        $to = User::find($sharedContact->to);
        $contacts = Contact::whereIn("id",json_decode($sharedContact->contact_ids))->get();
//
//        $mark = Auth::user()->unreadNotifications->where('id',$notificationId)->get();
//        return $mark;
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);

        return view('shared-contact.show',compact('from','to','sharedContact','contacts'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SharedContact  $sharedContact
     * @return \Illuminate\Http\Response
     */
    public function edit(SharedContact $sharedContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSharedContactRequest  $request
     * @param  \App\Models\SharedContact  $sharedContact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSharedContactRequest $request, SharedContact $sharedContact)
    {
        if($request->action === 'accept'){

          Contact::whereIn("id",json_decode($sharedContact->contact_ids))
                ->update(["user_id" =>Auth::id()]);
        }

        $sharedContact->status = $request->action;
        $sharedContact->update();

        return redirect()->route('contact.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SharedContact  $sharedContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(SharedContact $sharedContact)
    {
        //
    }
}
