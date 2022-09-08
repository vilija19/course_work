<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array();
        /**
         * @var array $url
         * Keeps get parameters for sorting and filtering
         */
        $url = array(
            'filter' => array(),
            'sort' => array()
        );
        /**
         * @var array $data['sorts']
         * Keeps columns permitted for sorting
         */
        $data['sorts'] = array(
            'id' => 'ID',
            'wallet_id' => 'Wallet',
            'amount' => 'Amount',
            'type' => 'Type',
            'description' => 'Description',
            'created_at' => 'Date',
        );
        /**
         * @var array $data['orders']
         * Keeps orders permitted for sorting
         */
        $data['orders'] = array(
            'ASC' => 'Ascending',
            'DESC' => 'Descending',
        );

        /**
         * Constructing query with sorting, filtering and pagination
         * Start
         */
        $query = Transaction::query();
        $data['wallet_id_filter'] = null;
        if ($request->has('wallet')) {
            $query->where('wallet_id', (int)$request->get('wallet'));

            $data['wallet_id_filter'] = (int)$request->get('wallet');
            $url['filter']['wallet'] = $data['wallet_id_filter'];
        }
        $data['type_filter'] = null;
        if ($request->has('type')) {
            $query->where('type', (int)$request->get('type'));

            $data['type_filter'] = (int)$request->get('type');
            $url['filter']['type'] = $data['type_filter'];
        }

        $data['sort_id_filter'] = null;
        if ($request->has('sort')) {
            $data['sort_id_filter'] = $request->get('sort');
            $url['sort']['sort'] = $data['sort_id_filter'];
        }else {
            $data['sort_id_filter'] = 'created_at';
        }

        $data['order_id_filter'] = null;
        if ($request->has('order')) {
            $data['order_id_filter'] = $request->get('order');
            $url['sort']['order'] = $data['order_id_filter'];

        }else {
            $data['order_id_filter'] = 'DESC';
        }

        $query->orderBy($data['sort_id_filter'],$data['order_id_filter']);
        $data['transactions'] = $query->paginate(config('app.items_per_page'));
        /**
         * Constructing query with sorting, filtering and pagination
         * End
         */

        $data['url'] = $url;

        $data['currencies'] = Currency::all();
        $data['wallets'] = Wallet::all();
        $data['default_currency_code'] = Currency::find(Auth::user()->default_currency_id)->code ;
        return view('account.transactions-info', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = array();
        $data['wallets'] = Wallet::all();
        if ($request->has('internal')) {
            return view('account.transaction-internal-create', $data);
        }else {
            return view('account.transaction-create', $data);
        }
    }

    /**
     * Store a newly created transaction in storage.
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
     * Store a newly created internal transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeInternal(Request $request)
    {
        $request->validate([
            'wallet_id_from' => 'required|int|max:25|different:wallet_id_to',
            'wallet_id_to' => 'required|int|max:25',
            'description' => 'string|max:55|nullable',
        ]);

        $walletFrom = Wallet::find($request->wallet_id_from);
        $walletTo = Wallet::find($request->wallet_id_to);

        $request->validate([
            'amount' => 'required|numeric|min:1|max:'.$walletFrom->getBalance()
        ]);

        DB::transaction(function () use ($request, $walletFrom, $walletTo) {
            /**
             * First part of transaction. Withdraw from wallet source wallet
             */
            $transaction = new Transaction();
            $transaction->type = 0;
            $transaction->amount = $request->amount;
            $transaction->wallet_id = $walletFrom->id;
            $transaction->description = $request->description;
            $transaction->save();

            /**
             * Second part of transaction. Deposit to wallet destination wallet
             */
            $transaction = new Transaction();
            $transaction->type = 1;
            $transaction->amount = Currency::convertCurrency($request->amount, $walletFrom->currency_id, $walletTo->currency_id);
            $transaction->wallet_id = $walletTo->id;
            $transaction->description = $request->description;
            $transaction->save();  
        });
      
        return redirect()->route('account.transactions.index')->with('message', 'Internal transaction created successfully');
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
     * Show the form for editing the specified transaction.
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
     * Update the specified transaction in storage.
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
     * Remove the specified transaction from storage.
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
