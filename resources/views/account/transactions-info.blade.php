<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Transactions') }}
        </h2>
    </x-slot>

    <div class="py-4">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Wallet</th>
                <th scope="col">Amount</th>
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
                <td>{{ $transaction->amount  }}</td>
                <td>{{ $transaction->type }}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->created_at }}</td>
                <td>
                    <a href="{{ route('account.transactions.edit', $transaction->id) }}" class="btn btn-primary">Edit</a>
                </td>
                </tr>
                @endforeach                 
            </tbody>
        </table> 

        <a class="btn btn-primary" href="{{route('account.transactions.create')}}" role="button">Create new Transaction</a>                               

        </div>


    </div>
    
</x-app-layout>