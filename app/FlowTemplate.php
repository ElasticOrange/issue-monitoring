<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class FlowTemplate extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'name'
    ];

    public function locationStep()
    {
        return $this->hasMany('Issue\LocationStep');
    }

    public function setAll($request)
    {
        $this->name = $request->get('name');

        $this->save();
    }

    public function syncLocations($locations)
    {
        $currentLocations = $this->locationStep()->get();

        if (! is_array($locations)) {
            $locations = [];
        }

        $index = 0;
        foreach ($locations as $id => $location) {
            $index++;
            $locations[$id]['step_order'] = $index;
        }

        foreach ($currentLocations as $currentLocation) {
            if (! array_key_exists($currentLocation->id, $locations)) {
                $currentLocation->delete();
                continue;
            }

            $currentLocation->fill($locations[$currentLocation->id]);
            $this->locationStep()->save($currentLocation);
            if (! array_key_exists('flow_steps', $locations[$currentLocation->id])) {
                $locations[$currentLocation->id]['flow_steps'] = [];
            }
            $currentLocation->syncSteps($locations[$currentLocation->id]['flow_steps']);

            unset($locations[$currentLocation->id]);
        }

        foreach ($locations as $locationData) {
            $newLocation = new LocationStep;
            $newLocation->fill($locationData);

            if (!isset($locationData['location_id']) || $locationData['location_id'] == "") {
                $newLocation['location_id'] = 1;
            }
//            dd($newLocation['location_id']);
            $this->locationStep()->save($newLocation);

            if (! array_key_exists('flow_steps', $locationData)) {
                $locationData['flow_steps'] = [];
            }
            $newLocation->syncSteps($locationData['flow_steps']);
        }
        return true;
    }
}
