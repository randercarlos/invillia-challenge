<?php

namespace App\Services;

use App\Exceptions\UploadException;
use App\Models\Person;
use App\Models\Phone;
use Illuminate\Support\Facades\Log;

class PersonService extends AbstractService
{
    protected $model;

    public function __construct() {
        $this->model = new Person();
    }

    public function upload($data) {

        if (count($data) > 0) {
            foreach($data as $person) {
                $personObj = new Person(['id' => $person->personid, 'name' => $person->personname]);
                $personObj->save();

                $phones = [];
                if (isset($person->phones->phone) && is_array($person->phones->phone)) {
                    if (count($person->phones->phone) > 0) {
                        foreach($person->phones->phone as $phone) {
                            $phones[] = new Phone(['phone' => $phone]);
                        }
                    }
                } else if (isset($person->phones->phone) && !is_array($person->phones->phone)) {
                    $phones[] = new Phone(['phone' => $person->phones->phone]);
                }

                $personObj->phones()->saveMany($phones);
            }

            Log::info('People imported successfully.');
        }
    }

}
