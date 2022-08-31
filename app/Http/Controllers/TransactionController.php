<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['transactions'] = Transaction::all()->sortByDesc('created_at');
        $data['currencies'] = Currency::all();
        $data['default_currency_code'] = Currency::find(Auth::user()->default_currency_id)->code ;
        return view('account.transactions-info', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['wallets'] = Wallet::all();
        return view('account.transaction-create', $data);
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
            'wallet_id' => 'required|int|max:25',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|int|max:1',
            'description' => 'string|max:55',
        ]);
        $wallet = Wallet::find($request->wallet_id);
        $transaction = new Transaction();
        $transaction->type = $request->type;
        $transaction->amount = $request->amount;
        $transaction->wallet_id = $wallet->id;
        $transaction->description = $request->description;
        $transaction->save();

        if ($request->type == 1) {
            $wallet->balance += $request->amount;
        } else {
            $wallet->balance -= $request->amount;
        }
        $wallet->save();

        return redirect()->route('account.transactions.index')->with('message', 'Transaction created successfully');
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
        $data['transaction'] = Transaction::find($id);
        return view('account.transaction-edit', $data);
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
            'amount' => 'required|numeric|min:1',
            'type' => 'required|int|max:1',
            'description' => 'string|max:55'
        ]);
        $transaction = Transaction::find($id);
        $transaction->type = $request->type;
        $transaction->amount = $request->amount;
        $transaction->description = $request->description;
        $transaction->save();

        return redirect()->route('account.transactions.index')->with('message', 'Transaction updated successfully');
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
        $transaction = Transaction::find($id);
        $transaction->delete();
        $message = 'Transaction '. $transaction->id .' deleted successfully';
        return redirect()->route('account.transactions.index')->with('message', $message);
    }

}
