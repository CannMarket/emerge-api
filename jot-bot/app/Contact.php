<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
     protected $table = 'contacts';

    /**
     * Show a list of all available contacts.
     *
     * @return Response
     */
    public function index()
    {
        $contacts = Contact::all();

        return view('contact.index', ['contacts' => $contacts]);
    }
    
}
