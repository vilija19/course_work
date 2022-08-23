<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit user data') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <form class="col-sm-4" action="{{route('account.user.update',Auth::user()->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ __('User Name') }}</label>
                <input name="name" type="text" class="form-control" value="{{ old('name') ?? $user->name }}" placeholder="username">
            </div>
            <div class="mb-3">
                <label class="form-label">{{__('Password')}}</label>
                <input name="password" type="text" class="form-control" value="" placeholder="Fill it to change password">
            </div>
            <div class="mb-3">
                <label class="form-label">{{__('Confirm Password')}}</label>
                <input name="password_confirmation" type="password" class="form-control" value="" placeholder="Fill it to change password">
            </div>            
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
</x-app-layout>