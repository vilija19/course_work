<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
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
     * Show the form for choose default currency.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['currencies'] = \App\Models\Currency::all();
        $data['default_currency_id'] = Auth::user()->default_currency_id;
        return view('account.settings', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'currency_id' => 'required|int|max:25'
        ]);
        $user = User::find(Auth::user()->id);
        $user->default_currency_id = $request->currency_id;
        $user->save();
        return redirect()->back()->with('message', 'Default currency has been changed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
        $data['user'] = User::find($id);
        return view('account.user-info', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['user'] = User::find($id);
        return view('account.user-edit', $data);
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
        if ($request->password) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
                'name' => ['string','nullable', 'max:25'],
            ]);
        }else {
            $request->validate([
                'name' => ['string','nullable', 'max:25']
            ]);
        }

        $user = User::find($id);
        $user->name = $request->name ?? '';
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $data = array();
        $data['user'] = $user;
        return redirect()->route('account.user.show', $user->id)->with('message', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
