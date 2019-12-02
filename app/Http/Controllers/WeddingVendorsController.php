<?php

namespace App\Http\Controllers;

use App\Exceptions\NotOwnerException;
use App\Models\WeddingVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeddingVendorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
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
            'vendorId'      => 'string|exists:vendors,_id|required',
            'weddingId'     => 'string|exists:weddings,_id|required'
        ]);

        $vendor = WeddingVendor::create([
            'vendorId'      => request('vendorId'),
            'weddingId'     => request('weddingId')
        ]);

        return compact('vendor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeddingVendor $weddingVendor
     * @return \Illuminate\Http\Response
     * @throws NotOwnerException
     * @throws \Exception
     */
    public function destroy(WeddingVendor $weddingVendor)
    {
        if ((!Auth::user()->admin) && ($weddingVendor->wedding->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create wedding!", 403);

        $weddingVendor->delete();

        return response()->json();
    }
}
