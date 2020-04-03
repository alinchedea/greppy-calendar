<?php


namespace App\Services;


use App\Event;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function getEvent($filter,$sort)  {
        $event = DB::table('event');

        if(isset($filter)){
            $event=$event
                ->where('event.from_date','<=',$filter)
                ->Where('event.to_date','>=',$filter);
        }
        if($sort>0){
            $event=$event->orderBy('event.from_date','asc');
        }
        return $event->get()->toArray();
    }

    public function postEvent($data)  {
        $event = Event::create([
            'description' => $data['description'],
            'from_date' => $data['from_date'],
            'to_date' => $data['to_date'],
            'location' => $data['location'],
            'user_id' => auth('api')->id(),
        ]);
        $event->save();
        return $event;
    }

    public function patchEvent($data,$id)  {
        $event = Event::findOrFail($id);
        if($event['user_id'] != auth('api')->id()){
            $event="This event does not belong to you.";
        }else{
            $event->update($data);

        }
        return $event;
    }

    public function deleteEvent($id)  {
        $event = Event::findOrFail($id);
        if($event['user_id'] != auth('api')->id()){
            $event="This event does not belong to you.";
        }else{
            $event->delete();

        }
        return $event;
    }
}
