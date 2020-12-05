@extends('layouts.app')

@section('content')
    <div class="flex flex-col w-full">
        <div class="">
            <form action="{{ route('contacts.update', $contact) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-3 sm:col-span-2">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                                <input required type="text" name="first_name" value="{{ old('first_name') ?? $contact->first_name }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('first_name')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-span-3 sm:col-span-2">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                                <input required type="text" name="last_name" value="{{ old('last_name') ?? $contact->last_name }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('last_name')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-span-3 sm:col-span-2">
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') ?? $contact->date_of_birth }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('date_of_birth')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-span-6 ">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                <input type="text" name="email" value="{{ old('email') ?? $contact->email }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('email')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label required for="company" class="block text-sm font-medium text-gray-700">Company</label>
                                <input required type="text" name="company" value="{{ old('company') ?? $contact->company }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('company')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label required for="position" class="block text-sm font-medium text-gray-700">Position</label>
                                <input required type="text" name="position" value="{{ old('position') ?? $contact->position }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('position')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
