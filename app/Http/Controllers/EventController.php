<?php

namespace App\Http\Controllers;

use App\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EventController extends Controller
{
    protected $evService;
    public function __construct(EventService $evService)
    {
        $this->evService = $evService;
    }
    public function index(Request $request){
        $filter=$request->input('filter-by-date');
        $sort=$request->input('sort-chronologically');

        $response=$this->evService->getEvent($filter,$sort);
        return response()->json([
            'response'=>$response
        ], 200);
    }

    public function create(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'description' => ['required','string'],
            'from_date' => ['required','date_format:Y-m-d H:i:s'],
            'to_date' => ['required','date_format:Y-m-d H:i:s'],
            'location' => ['required','string'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 417);
        }
        $response=$this->evService->postEvent($data);
        return response()->json([
            'message'=>"Event succesfully added!",
            'response'=>$response
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'description' => ['required','string'],
            'from_date' => ['required','date_format:Y-m-d H:i:s'],
            'to_date' => ['required','date_format:Y-m-d H:i:s'],
            'location' => ['required','string'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 417);
        }
        $response=$this->evService->patchEvent($data,$id);
        $response = json_decode($response, true);
        return response()->json([
            'message'=>isset($response) ? "Event succesfully updated!" : 'You are not allowed to edit this event!',
            'response'=>$response
        ], 200);
    }

    public function delete($id)
    {
        $response=$this->evService->deleteEvent($id);
        $response = json_decode($response, true);

        return response()->json([
            'message'=>isset($response) ? "Event succesfully deleted!" : 'You are not allowed to delete this event!',
            'response'=>$response
        ], 200);
    }
}
