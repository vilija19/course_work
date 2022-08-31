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
                <tr>
                <th scope="row">{{ $wallet->id }}</th>
                <td>{{ $wallet->name }}</td>
                <td>{{ $wallet->currency->name  }}</td>
                <td>{{ $wallet->balance }}</td>
                <td>
                    <div>
                        <div style="float: left;margin-left: 5px;">
                            <a href="{{ route('account.wallets.edit', $wallet->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                        @if ($wallet->transactions->count() == 0)
                            <div style="float: left;margin-left: 5px;">
                                <form class="btn btn-danger"  method="POST" action="{{ route('account.wallets.destroy', $wallet->id) }}"  target="_self">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete">
                                </form>
                            </div>
                        @endif
                    </div>
                </td>
                </tr>
                @endforeach                 
            </tbody>
        </table>

        <a class="btn btn-primary" href="{{route('account.wallets.create')}}" role="button">Create new Wallet</a>                               

      </div>


    </div>
    
</x-app-layout>