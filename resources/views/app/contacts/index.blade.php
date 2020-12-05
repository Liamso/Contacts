@extends('layouts.app')

@section('content')
    <div class="flex flex-col w-full">
        <form class="min-w-full mb-3 md:h-10">
            <label for="search" class="sr-only">Search</label>
            <div class="relative h-full grid grid-cols-6 gap-4 w-full">

                <div class="h-10 flex shadow-md rounded-md col-span-6 md:col-span-5">
                    <input id="search" name="search" value="{{ request('search') }}" class="focus:outline-none rounded-md rounded-r-none border border-gray-300 form-input pl-3 block w-5/6 h-full  sm:text-sm sm:leading-5" placeholder="Search..." />
                    <button class="w-1/6 bg-gray-300 rounded-md rounded-l-none text-gray-700 hover:bg-gray-400 hover:text-gray-200">
                        Search
                    </button>
                </div>

                <div class="h-full col-span-3 md:col-span-1">
                    <a href="{{ route('contacts.create') }}" class="w-24  md:ml-auto shadow-md text-gray-700 bg-green-500 hover:bg-gray-700 hover:bg-green-700 block px-6 py-2 rounded-md text-base font-medium">
                        Create
                    </a>
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
