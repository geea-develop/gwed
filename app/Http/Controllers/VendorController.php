<?php

namespace App\Http\Controllers;

use App\Exceptions\NotOwnerException;
use App\Models\Vendor;
use App\Models\Wedding;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
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
        $vendors = Vendor::orderBy('name')
//            ->take(10)
            ->get();

        return compact('vendors');
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
            'name'      => 'string|required',
            'phone'     => 'required',
            'email'     => 'email|unique:vendors|required',
            'cost'      => 'numeric|required',
            'weddingId' => 'string|exists:weddings,_id|sometimes'
        ]);

        $vendor = Auth::user()
            ->vendors()
            ->create([
                'name'      => request('name'),
                'phone'     => request('phone'),
                'email'     => strtolower(request('email')),
                'cost'      => (double)request('cost')
            ]);

        if ($request->exists('weddingId')) {
            Wedding::find(request('weddingId'))->vendors()->create([
                'vendorId' => $vendor->_id
            ]);
        }

        return compact('vendor');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        return compact('vendor');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $this->validate($request, [
            'name'      => 'string|required',
            'phone'     => 'required',
            'email'     => 'email|required|unique:vendors,_id,'.$vendor->_id,
            'cost'      => 'numeric|required'
        ]);

        if ((!Auth::user()->admin) && ($vendor->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create vendor!", 403);

        $vendor->update([
            'name'      => request('name'),
            'phone'     => request('phone'),
            'email'     => strtolower(request('email')),
            'cost'      => (double)request('cost')
        ]);

        return compact('vendor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor $vendor
     * @return \Illuminate\Http\Response
     * @throws NotOwnerException
     */
    public function destroy(Vendor $vendor)
    {
        if ((!Auth::user()->admin) && ($vendor->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create vendor!", 403);

        $vendor->weddings()->delete();
        $vendor->professions()->delete();

        return response()->json();
    }

    public function byWedding($id) {

        $vendors = Wedding::find($id)->vendors()->orderBy('name')->get();

        foreach ($vendors as $vendor) {
            $vendor->vendor;
        }

        return compact('vendors');
    }
}
