<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new Wallet') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <form class="col-sm-4" action="{{route('account.wallets.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('Wallet Name') }}</label>
                <input name="name" type="text" class="form-control" value="{{ old('name') }}" placeholder="walletname">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Balance') }}</label>
                <input name="balance" type="text" class="form-control" value="{{ old('balance') ?? 0 }}" placeholder="walletbalance, zerro by default">
            </div>           
            <div class="mb-3">
                <label class="form-label">{{__('Currency')}}</label>
                <select class="form-select" name="currency_id" aria-label="Default select example">
                    <option selected>Please, choose a currency for wallet</option>
                    @foreach ($currencies as $currency)
                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                    @endforeach
                </select>
            </div>         
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
</x-app-layout>