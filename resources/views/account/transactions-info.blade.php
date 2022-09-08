<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Transactions') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto  sm:px-6 lg:px-8">
            <form class="row g-3" action="{{route('account.transactions.index')}}">
                <div class="col col-lg-2">
                    <label class="form-label">{{__('Filter by Wallet')}}</label>
                    <select class="form-select" name="wallet" aria-label="Default select example">
                        <option value="" disabled selected hidden>Select wallet</option>
                        @foreach ( $wallets as  $id => $wallet)
                            <option value="{{$id}}" @if($wallet_id_filter === $id) selected @endif>{{$wallet->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col col-lg-3">
                    <label class="form-label">{{__('Filter by Type')}}</label>
                    <select class="form-select" name="type" aria-label="Default select example">
                        <option value="" disabled selected hidden>Select operation type</option>
                        @foreach ( config('app.transaction_types') as  $type_id => $type)
                            <option value="{{$type_id}}" @if($type_filter === $type_id) selected @endif>{{$type}}</option>
                        @endforeach
                    </select>
                </div> 
                <div class="col col-lg-2 position-relative">
                    <button type="submit" class="btn btn-primary position-absolute bottom-0 start-0">Filter</button>
                    <a class="btn btn-warning position-absolute bottom-0 end-0" href="{{route('account.transactions.index')}}" role="button">
                        {{__('Reset')}}
                    </a>
                </div>
                @foreach ($url['sort'] as $key => $value)
                    <input type="hidden" name="{{$key}}" value="{{$value}}">
                @endforeach               
            </form>
        </div>
        <div class="max-w-7xl mx-auto  sm:px-6 py-4 lg:px-8">
            <form class="row g-2" action="{{route('account.transactions.index')}}">
                <div class="col col-lg-2">
                    <label class="form-label">{{__('Sort by:')}}</label>
                    <select class="form-select" name="sort" aria-label="Default select example">
                        <option value="" disabled selected hidden>Select sort column</option>
                        @foreach ( $sorts as  $sort => $sortName)
                            <option value="{{$sort}}" @if($sort_id_filter === $sort) selected @endif>{{$sortName}}</option>
                        @endforeach
                    </select>
                </div>  
                <div class="col col-lg-2">
                    <label class="form-label">{{__('Order:')}}</label>
                    <select class="form-select" name="order" aria-label="Default select example">
                        <option value="" disabled selected hidden>Select sort column</option>
                        @foreach ( $orders as  $order => $orderName)
                            <option value="{{$order}}" @if($order_id_filter === $order) selected @endif>{{$orderName}}</option>
                        @endforeach
                    </select>
                </div>                              
                <div class="col col-lg-2 position-relative">
                    <button type="submit" class="btn btn-primary position-absolute bottom-0 start-0">Sort</button>
                </div> 
                @foreach ($url['filter'] as $key => $value)
                    <input type="hidden" name="{{$key}}" value="{{$value}}">
                @endforeach                 
            </form>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Wallet</th>
                <th scope="col">Amount ({{$default_currency_code}})</th>
                <th scope="col">Type</th>
                <th scope="col">Description</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                @if ($transaction->type == config('app.transaction_types')[1])
                <tr class="table-success">
                @else
                <tr class="table-danger">
                @endif
                <th scope="row">{{ $transaction->id }}</th>
                <td>{{ $transaction->wallet->name }}</td>
                <td>{{ number_format($transaction->getAmountInDeaultCurrency(),2) }}</td>
                <td>{{ $transaction->type }}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->created_at }}</td>
                <td>
                    <a href="{{ route('account.transactions.edit', $transaction->id) }}" class="btn btn-primary">Edit</a>
                    <form class="btn btn-danger"  method="POST" action="{{ route('account.transactions.destroy', $transaction->id) }}"  target="_self">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete">
                    </form>
                </td>
                </tr>
                @endforeach                 
            </tbody>
        </table> 
        @if ($transactions->hasPages())
            <h5>Pagination:</h5>
            {{ $transactions->links() }}
        @endif

        <a class="btn btn-primary" href="{{route('account.transactions.create')}}" role="button">Create new Transaction</a>                               
        <a class="btn btn-info" href="{{route('account.transactions.create',['internal' => 1])}}" role="button">Create new Internal Transaction</a>                               
        </div>


    </div>
    
</x-app-layout>