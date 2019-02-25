<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Person;

class PersonsController extends Controller
{
    /**
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $persons = Person::all();

        return view("pages.website.persons.index", compact('persons'));
    }

    /**
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $person = Person::where('slug', '=', $slug)->first();

        abort_if(empty($person), 404);

        return view("pages.website.persons.show", compact('person'));
    }
}
