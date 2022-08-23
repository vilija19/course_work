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
                <div class="col-sm-2">User Bank Accounts</div>
                <div class="col-sm-8">fill me!!!</div>
            </div> 
            <div class="row">
                <div class="col-sm-2">Total ammount</div>
                <div class="col-sm-8">fill me!!!</div>
            </div>                                   

        </div>


    </div>
    
</x-app-layout>