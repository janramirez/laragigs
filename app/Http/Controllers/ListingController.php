<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Listing;
use Faker\Provider\Lorem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    // show all listings
    public function index()
    {
        return view('listings.index', [
            "listings" => Listing::latest()->filter(request(['tag', 'search']))->paginate(10)
        ]);
    }

    // show single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            "listing" => $listing
        ]);
    }

    // show create form
    public function create()
    {
        return view('listings.create');
    }

    // store listing data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // dd(auth()->id());
        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    // show edit form
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    // update listing
    public function update(Request $request, Listing $listing)
    {

        // make sure user is owner before making changes
        if($listing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized Action!');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);
        return back()->with('message', 'Listing updated successfully!');
    }

    // delete listing
    public function destroy(Listing $listing)
    {

        // make sure user is owner before making changes
        if($listing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized Action!');
        }
        
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    //manage listing
    /** @var \App\Models\User  $user */
    public function manage()
    {
        $user = auth()->user();
        // dd(Listing::users()->get());
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

    public function myself() {
        $user = auth()->user();

        if($user) {
            return User::find($user->id);
        }
    }

}
