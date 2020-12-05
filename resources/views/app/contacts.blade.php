@extends('layouts.app')

@section('content')
    <div class="flex flex-col w-10/12">
    <form class="min-w-full mb-3 h-10">
        <label for="search" class="sr-only">Search</label>
        <div class="relative rounded-md shadow-md h-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div class="w-full h-full flex">
                <input id="search" name="search" value="{{ request('search') }}" class="focus:outline-none rounded-md rounded-r-none border border-gray-300 form-input block w-5/6 h-full pl-10 sm:text-sm sm:leading-5" placeholder="Search..." />
                <button class="w-1/6 bg-gray-300 rounded-md rounded-l-none text-gray-700 hover:bg-gray-400 hover:text-gray-200">
                    Search
                </button>
            </div>
        </div>
    </form>

        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">

                <div class="shadow overflow-hidden border-b border-gray-400 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date of Birth
                                </th>
                                <th scope="col" class="pl-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $contact->fullName }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $contact->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $contact->company }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $contact->position }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $contact->date_of_birth ? $contact->date_of_birth->format('d/m/Y') : '' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex-col flex">
                                        <a href="{{ route('contacts.show', $contact) }}" class="text-gray-600 hover:text-gray-900">View</a>
                                        <a href="{{ route('contacts.edit', $contact) }}" class="text-gray-600 hover:text-gray-900 mt-2">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
