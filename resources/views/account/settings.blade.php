<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Select default currency') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <form class="col-sm-4" action="{{route('account.user.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{__('Default Currency')}}</label>
                <select class="form-select" name="currency_id" aria-label="Default select example">
                    @if (!$default_currency_id)
                        <option selected>Default currency not choosen</option>
                    @endif
                    @foreach ($currencies as $currency)
                        @if ($currency->id == $default_currency_id)
                            <option value="{{$currency->id}}" selected>{{$currency->name}}</option>
                        @else
                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>         
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
</x-app-layout>