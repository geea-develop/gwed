<?php

namespace App\Http\Controllers;

use App\Exceptions\NotOwnerException;
use App\Models\Wedding;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class WeddingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
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
        $weddings = Auth::user()
            ->weddings()
            ->orderBy('date')
            ->get();

        return compact('weddings');
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
                'brideName'     => 'string|required',
                'groomName'     => 'string|required',
                'location'      => 'string|required',
                'budget'        => 'numeric',
                'guests'        => 'numeric|max:800|required',
                'date'          => 'required|date|after:now'
            ]);

        $date = Carbon::createFromFormat('Y-m-d', request('date'));

        $wedding = Auth::user()
            ->weddings()
            ->create([
                'brideName' => request('brideName'),
                'groomName' => request('groomName'),
                'date'      => $date,
                'location'  => request('location'),
                'guests'    => (int)request('guests')
            ]);

        return compact('wedding');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wedding  $wedding
     * @return \Illuminate\Http\Response
     */
    public function show(Wedding $wedding)
    {
        return compact('wedding');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Wedding $wedding
     * @return \Illuminate\Http\Response
     * @throws NotOwnerException
     */
    public function update(Request $request, Wedding $wedding)
    {

        $this->validate($request, [
            'brideName'     => 'string',
            'groomName'     => 'string',
            'location'      => 'string',
            'budget'        => 'numeric',
            'guests'        => 'numeric|max:800',
            'date'          => 'required|date|after:now'
        ]);

        $date = Carbon::createFromFormat('Y-m-d', request('date'));

        if ((!Auth::user()->admin) && ($wedding->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create wedding!", 403);

        $wedding->update([
            'brideName' => request('brideName'),
            'groomName' => request('groomName'),
            'date'      => $date,
            'location'  => request('location'),
            'budget'    => (float)request('budget'),
            'guests'    => (int)request('guests'),
        ]);

        return compact('wedding');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wedding $wedding
     * @return \Illuminate\Http\Response
     * @throws NotOwnerException
     * @throws \Exception
     */
    public function destroy(Wedding $wedding)
    {
        if ((!Auth::user()->admin) && ($wedding->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create wedding!", 403);

        $wedding->delete();

        return response()->json();
    }
}
