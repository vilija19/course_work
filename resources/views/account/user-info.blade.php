<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Info') }}
        </h2>
    </x-slot>

    <div class="py-4">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-sm-2">User Name</div>
                <div class="col-sm-8">{{ $user->name }}</div>
            </div>
            <div class="row">
                <div class="col-sm-2">email</div>
                <div class="col-sm-8">{{ $user->email }}</div>
            </div>  
            <div class="row">
                <div class="col-sm-2">Default Currency</div>
                <div class="col-sm-8">{{ $user->currency->name ?? 'Not set'}}</div>
            </div> 
            <div class="row">
                <div class="col-sm-2">Total balance</div>
                <div class="col-sm-8">{{ $user->wallets()->sum('balance') }}</div>
            </div>                                   
        </div>
    </div>

    <div class="py-4">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-sm-2">User Bank Accounts</div>
            </div>            
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->wallets as $wallet)
                    <tr>
                    <th scope="row">{{ $wallet->id }}</th>
                    <td>{{ $wallet->name }}</td>
                    <td>{{ $wallet->currency->name  }}</td>
                    <td>{{ $wallet->balance }}</td>
                    </tr>
                    @endforeach                 
                </tbody>
            </table>
        </div>
    </div>            
    
</x-app-layout>