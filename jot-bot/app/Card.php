<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    /**
     * Show a list of all available cards.
     *
     * @return Response
     */
    public function index()
    {
        $cards = Card::all();

        return view('card.index', ['cards' => $cards]);
    }
}
