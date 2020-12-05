@extends('layouts.app')

@section('content')
    <div class="flex flex-col w-full">
        <div>
            <form action="{{ isset($contact) ? route('contacts.update', $contact) : route('contacts.store') }}" method="POST" onsubmit="cleanEmptyNumbers(event)">
                @csrf
                @isset($contact) @method('PUT') @endisset
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-3 sm:col-span-2">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                                <input required type="text" name="first_name" value="{{ old('first_name', $contact->first_name ?? null) }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('first_name')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-span-3 sm:col-span-2">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                                <input required type="text" name="last_name" value="{{ old('last_name', $contact->last_name ?? null) }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('last_name')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-span-3 sm:col-span-2">
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($contact->date_of_birth) ? $contact->date_of_birth->format('Y-m-d') : '') }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('date_of_birth')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-span-6 ">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                <input type="text" name="email" value="{{ old('email', $contact->email ?? null) }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('email')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label required for="company" class="block text-sm font-medium text-gray-700">Company</label>
                                <input required type="text" name="company" value="{{ old('company', $contact->company ?? null) }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('company')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label required for="position" class="block text-sm font-medium text-gray-700">Position</label>
                                <input required type="text" name="position" value="{{ old('position', $contact->position ?? null) }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('position')
                                    <span class="text-red-500 text-xs ml-2">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5">
                            @error('numbers')
                                <span class="text-red-500 text-xs ml-2">
                                    {{ $message }}
                                </span>
                            @enderror
                            @error('id')
                                <span class="text-red-500 text-xs ml-2">
                                    {{ $message }}
                                </span>
                            @enderror
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Number
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Is Primary
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @isset($contact)
                                        @foreach ($contact->contactNumbers as $key => $number)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <input type="text" name="numbers[{{ $number->id }}][number]" value="{{ old('numbers')[$number->id]['number'] ?? $number->number }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                        @error("numbers.{$number->id}.number")
                                                            <span class="text-red-500 text-xs ml-2">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 flex justify-center">
                                                        <input type="radio" name="primary_number" value="{{ $number->id }}" @if ($number->is_primary) checked @endif >
                                                    </div>
                                                </td>
                                                <td class="text-sm text-gray-900 text-center">
                                                    <button type="button" onclick="destroyContactNumber({{ $number->id }})" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                <input id="newNumber" type="text" name="numbers[new][number]" value="{{ old('contactNumbers' ?? null) }}" class="mt-1 focus:ring-gray-500 focus:border-gray-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 flex justify-center items-center">
                                                <input id="newPrimary" type="radio" name="primary_number" value="new">
                                            </div>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
        @isset($contact)
            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="flex justify-center">
                @csrf
                @method('DELETE')
                <button type="submit" class="mt-5 w-3/6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </form>
        @endisset

        <form action="/contact-numbers" id="destroyContactNumberForm" method="POST" class="hidden">
            @csrf
            @method('DELETE')
            <input type="hidden" value="" name="id" id="destroyContactNumberInput" />
        </form>
    </div>
@endsection
