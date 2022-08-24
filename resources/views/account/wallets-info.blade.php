<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Wallets') }}
        </h2>
    </x-slot>

    <div class="py-4">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Currency</th>
                <th scope="col">Balance</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($wallets as $wallet)
                <th scope="row">{{ $wallet->id }}</th>
                <td>{{ $wallet->name }}</td>
                <td>{{ $currencies->find($wallet->currency_id)->name  }}</td>
                <td>{{ $wallet->balance }}</td>
                <td>
                    <a href="{{ route('account.wallets.edit', $wallet->id) }}" class="btn btn-primary">Edit</a>
                </td>
                </tr>
                @endforeach                 
            </tbody>
        </table>

        <a class="btn btn-primary" href="{{route('account.wallets.create')}}" role="button">Create new Wallet</a>                               

        </div>


    </div>
    
</x-app-layout>