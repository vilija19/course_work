<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['wallets'] = User::find(Auth::user()->id)->wallets;
        return view('account.wallets-info', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['currencies'] = Currency::all();
        return view('account.wallet-create', $data);
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
            'currency_id' => 'required|int|max:25',
            'name' => 'required|string|max:255',
            'balance' => 'numeric|min:0',
        ]);
        $user = User::find(Auth::user()->id);
        $wallet = new Wallet();
        $wallet->name = $request->name;
        $wallet->currency_id = $request->currency_id;
        $wallet->user_id = $user->id;
        $wallet->save();
        if ($request->balance > 0) {
            $wallet->balance = $request->balance;
            $wallet->save();
            $transaction = new Transaction();
            $transaction->type = 1;
            $transaction->amount = $request->balance;
            $transaction->wallet_id = $wallet->id;
            $transaction->description = 'Initial balance';
            $transaction->save();
        }        
        return redirect()->route('account.wallets.index')->with('message', 'Wallet has been created');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $data['wallet'] = Wallet::find($id);
        return view('account.wallet-edit', $data);
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
        $request->validate([
            'name' => 'required|string|max:25'
        ]);
        $wallet = Wallet::find($id);
        $wallet->name = $request->name;
        $wallet->save();
        return redirect()->route('account.wallets.index')->with('message', 'Wallet "'.$wallet->name.'" has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = '';
        $wallet = Wallet::find($id);
        $wallet->delete();
        $message = 'Wallet "'.$wallet->name.'" has been deleted';
        return redirect()->route('account.wallets.index')->with('message', $message);
    }

}
