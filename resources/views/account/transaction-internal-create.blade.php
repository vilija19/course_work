<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new Transaction between your wallets') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <form class="col-sm-4" action="{{route('account.transactions.storeinternal')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{__('Wallet Name From')}}</label>
                <select class="form-select" name="wallet_id_from" aria-label="Default select example">
                    <option selected>Select wallet</option>
                    @foreach ($wallets as $wallet)
                        <option value="{{$wallet->id}}">{{$wallet->name}} ({{$wallet->currency->code}}) Balance:{{$wallet->getBalance()}}</option>
                    @endforeach
                </select>
            </div>             
            <div class="mb-3">
                <label class="form-label">{{__('Wallet Name To')}}</label>
                <select class="form-select" name="wallet_id_to" aria-label="Default select example">
                    <option selected>Select wallet</option>
                    @foreach ($wallets as $wallet)
                        <option value="{{$wallet->id}}">{{$wallet->name}} ({{$wallet->currency->code}})  Balance:{{$wallet->getBalance()}}</option>
                    @endforeach
                </select>
            </div> 
            <div class="mb-3">
                <label class="form-label">{{ __('Amount (in currency Wallet From)') }}</label>
                <input name="amount" type="text" class="form-control" value="{{ old('amount') }}" placeholder="amount">
            </div>   
            <div class="mb-3">
                <label class="form-label">{{ __('Description') }}</label>
                <input name="description" type="text" class="form-control" value="{{ old('description') }}" placeholder="description">
            </div>                      
            
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
</x-app-layout>