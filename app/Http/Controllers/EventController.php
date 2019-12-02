<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFieldsException;
use App\Exceptions\NotOwnerException;
use App\Models\Event;
use App\Models\Wedding;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
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
        $events = Event::latest()
            ->orderBy('date')
            ->take(10)
            ->get();

        return compact('events');
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
            'date'      => 'date_format:Y-m-d|required|after:now',
            'description'      => 'string',
            'weddingId' => 'exists:weddings,_id|string|required'
        ]);

        $date = Carbon::createFromFormat('Y-m-d', request('date'));

        $wedding = Auth::user()->weddings()->where('_id',$request->input('weddingId'))->first();

        $this->validate($request, [
            'date'      => 'date_format:Y-m-d|required|before:'. $wedding->date->toDateTimeString(),
        ]);

        $event = $wedding
            ->events()
            ->create([
                'name'      => request('name'),
                'description'     => request('description'),
                'date'     => $date
            ]);

        return compact('event');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return compact('event');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $this->validate($request, [
            'name'      => 'string|required',
            'description'      => 'string',
            'date'      => 'date|required|after:now'
        ]);

        $date = Carbon::createFromFormat('Y-m-d', request('date'));

        $wedding = $event->wedding;
        $this->validate($request, [
            'date'      => 'date_format:Y-m-d|required|before:'. $wedding->date->toDateTimeString(),
        ]);

        if ((!Auth::user()->admin) && ($event->wedding->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create wedding!", 403);

        $event->update([
            'name'      => request('name'),
            'description'     => request('description'),
            'date'     => $date
        ]);

        return compact('event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if ((!Auth::user()->admin) && ($event->wedding->userId !== Auth::user()->_id))
            throw new NotOwnerException("User did not create wedding!", 403);

        $event->delete();

        return response()->json();
    }

    public function byWedding($id) {

        $events = Event::where('weddingId', '=', $id)->orderBy('date')->get();

        return compact('events');
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

            $requiredFields = ['name', 'description', 'date'];

            if (!empty($data) && $data->count()) {

                foreach ($data->toArray() as $event) {

                    foreach ($requiredFields as $field) {
                        if (!isset($event[$field]))
                            $this->makeExceptionMissingField($field);
                    }

                    $date = Carbon::createFromFormat('Y-m-d', $event['date']);

                    $wedding->events()->create([
                        'name'      => (string)$event['name'],
                        'description'     => (string)$event['description'],
                        'date'     => $date
                    ]);
                }
            }

        }

        $events = $wedding->events;


        return compact('id', 'events');

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
