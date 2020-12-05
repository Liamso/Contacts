<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteContactNumberRequest;
use App\Models\ContactNumber;
use Illuminate\Http\Request;

class ContactNumberController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteContactNumberRequest $request)
    {
        ContactNumber::where('id', $request->id)->delete();
        return redirect()->back()->withSuccess('Contact number deleted.');
    }
}
