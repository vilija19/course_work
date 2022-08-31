<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new Transaction') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <form class="col-sm-4" action="{{route('account.transactions.update', $transaction->id)}}" method="POST">
            @csrf
            @method('PUT')   
            <div class="mb-3">
                <label class="form-label">{{__('Type')}}</label>
                <select class="form-select" name="type" aria-label="Default select example">
                    <option selected>Select operation type</option>
                    @foreach ( config('app.transaction_types') as  $type_id => $type)
                        <option value="{{$type_id}}" @if($transaction->type == $type) selected @endif>{{$type}}</option>
                    @endforeach
                </select>
            </div> 
            <div class="mb-3">
                <label class="form-label">{{ __('Amount') }}</label>
                <input name="amount" type="text" class="form-control" value="{{ old('amount') ?? $transaction->amount }}" placeholder="amount">
            </div>   
            <div class="mb-3">
                <label class="form-label">{{ __('Description') }}</label>
                <input name="description" type="text" class="form-control" value="{{ old('description') ?? $transaction->description }}" placeholder="description">
            </div>                      
        
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
</x-app-layout>