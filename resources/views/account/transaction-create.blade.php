<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new Transaction') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <form class="col-sm-4" action="{{route('account.transactions.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{__('Wallet Name')}}</label>
                <select class="form-select" name="wallet_id" aria-label="Default select example">
                    <option selected>Select wallet</option>
                    @foreach ($wallets as $wallet)
                        <option value="{{$wallet->id}}">{{$wallet->name}} ({{$wallet->currency->code}})</option>
                    @endforeach
                </select>
            </div>             
            <div class="mb-3">
                <label class="form-label">{{__('Type')}}</label>
                <select class="form-select" name="type" aria-label="Default select example">
                    <option selected>Select operation type</option>
                    @foreach ( config('app.transaction_types') as  $type_id => $type)
                        <option value="{{$type_id}}">{{$type}}</option>
                    @endforeach
                </select>
            </div> 
            <div class="mb-3">
                <label class="form-label">{{ __('Amount') }}</label>
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