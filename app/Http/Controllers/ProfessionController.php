<?php

namespace App\Http\Controllers;

use App\Exceptions\NotOwnerException;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionController extends Controller
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
        $professions = Profession::orderBy('name')
//            ->take(10)
            ->get();

        return compact('professions');
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
            'name'              => 'string|required',
            'uname'             => 'string|unique:professions|required',
            'description'       => 'string|required'
        ]);

        $profession = Auth::user()
            ->professions()
            ->create([
                'name'      => request('name'),
                'uname'     => request('uname'),
                'description'     => request('description')
            ]);

        return compact('profession');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\Response
     */
    public function show(Profession $profession)
    {
        return compact('profession');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Profession $profession
     * @return \Illuminate\Http\Response
     * @throws NotOwnerException
     */
    public function update(Request $request, Profession $profession)
    {
        $this->validate($request, [
            'name'              => 'string|required',
            'uname'             => 'string|required',
            'description'       => 'string|required'
        ]);

        if ((!Auth::user()->admin) && ($profession->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create profession!", 403);

        $profession->update([
            'name'      => request('name'),
            'uname'     => request('uname'),
            'description'     => request('description')
        ]);

        return compact('profession');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profession $profession
     * @return \Illuminate\Http\Response
     * @throws NotOwnerException
     * @throws \Exception
     */
    public function destroy(Profession $profession)
    {
        if ((!Auth::user()->admin) && ($profession->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create profession!", 403);

        $profession->delete();

        return response()->json();
    }
}
