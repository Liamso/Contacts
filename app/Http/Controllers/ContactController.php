<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\ContactNumber;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::query()
            ->search(request('search'))
            ->paginate(20)
            ->appends(request()->query());

        return view('app.contacts.index', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.contacts.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $contact = Contact::create(
            $request->only([
                'first_name',
                'last_name',
                'date_of_birth',
                'position',
                'company',
                'email'
            ])
        );

        ContactNumber::syncAll($request->numbers, $request->primary_number, $contact->id);

        return redirect(route('contacts.edit', $contact))->withSuccess('Contact created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return view('app.contacts.show', [
            'contact' => $contact
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactRequest  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('app.contacts.edit', [
            'contact' => $contact
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\ContactRequest  $contact
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update(
            $request->only([
                'first_name',
                'last_name',
                'date_of_birth',
                'position',
                'company',
                'email'
            ])
        );

        ContactNumber::syncAll($request->numbers, $request->primary_number, $contact->id);

        return redirect()->back()->withSuccess('Contact updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect(route('contacts.index'))->withSuccess('Contact deleted.');
    }
}
