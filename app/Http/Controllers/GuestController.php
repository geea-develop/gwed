<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFieldsException;
use App\Exceptions\NotOwnerException;
use App\Models\Guest;
use App\Models\Wedding;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class GuestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guests = Guest::latest()
            ->orderBy('name')
            ->take(10)
            ->get();

        return compact('guests');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'phone'     => '',
            'side'     => 'in:groom,bride',
            'type'     => 'in:family,work,friend,other',
            'email'     => 'email',
            'weddingId' => 'string|exists:weddings,_id|sometimes'
        ]);

        $guest = Auth::user()
            ->guests()
            ->create([
                'name'      => request('name'),
                'phone'     => request('phone'),
                'email'     => strtolower(request('email')),
                'side'      => request('side'),
                'type'      => request('type')
            ]);

        if ($request->exists('weddingId')) {
            Wedding::find(request('weddingId'))->guests()->create([
                'guestId' => $guest->_id
            ]);
        }

        return compact('guest');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function show(Guest $guest)
    {
        return compact('guest');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guest $guest)
    {
        $this->validate($request, [
            'name'      => 'string|required',
            'phone'     => '',
            'side'     => 'in:groom,bride',
            'type'     => 'in:family,work,friend,other',
            'email'     => 'email'
        ]);

        if ((!Auth::user()->admin) && ($guest->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create guest!", 403);

        $guest->update([
            'name'      => request('name'),
            'phone'     => request('phone'),
            'email'     => strtolower(request('email')),
            'side'      => request('side'),
            'type'      => request('type')
        ]);

        return compact('guest');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guest $guest)
    {
        if ((!Auth::user()->admin) && ($guest->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create guest!", 403);


        $guest->delete();

        return response()->json();
    }

    public function byWedding($id) {

        $guests = Wedding::find($id)->guests()->get();

        foreach ($guests as $guest) {
            $guest->guest;
        }

        return compact('guests');
    }

    public function upload($id, Request $request)
    {

        $this->validate($request, [
            'importFile' => 'file|mimes:csv,xls,txt|required'
        ]);

        $wedding = Wedding::find($id);

        if ((!Auth::user()->admin) && ($wedding->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create wedding!", 403);

        if (is_null($wedding))
            throw new ModelNotFoundException();

        if($request->hasFile('importFile')){
            $path = $request->file('importFile')->getRealPath();

            $data = Excel::load($path, function($reader) {})->get();

            $requiredFields = ['name', 'phone', 'email', 'type', 'side'];

            if (!empty($data) && $data->count()) {

                foreach ($data->toArray() as $guest) {

                    foreach ($requiredFields as $field) {
                        if (!isset($guest[$field]))
                            $this->makeExceptionMissingField($field);
                    }

                    if ($wedding->guests()->count() > 800) $this->makeExceptionMissingField("Exceeded guests quota.");

                    $newGuest = Guest::create([
                        'name'      => (string)$guest['name'],
                        'phone'     => (string)$guest['phone'],
                        'email'     => (string)$guest['email'],
                        'type'     => in_array($guest['side'], getGuestTypes()) ? $guest['type'] : null,
                        'side'      => in_array($guest['side'], getPartners()) ? $guest['side'] : null,
                    ]);

                    $wedding->guests()->create([
                        'guestId' => $newGuest->_id
                    ]);
                }
            }

        }

        $guests = $wedding->guests;


    return compact('id', 'guests');

    }

    /**
     * @param $field string
     * @throws InvalidFieldsException
     */
    private function makeExceptionMissingField($field)
    {
        throw new InvalidFieldsException("Missing or invalid field: {$field}");
    }
}
