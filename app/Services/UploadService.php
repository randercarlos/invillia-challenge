<?php

namespace App\Services;

use App\Exceptions\UploadException;
use App\Models\Person;
use App\Models\Phone;
use App\Models\ShipOrder;

class UploadService extends AbstractService
{
    protected $model;
    protected $personService;
    protected $shipOrderService;

    public function __construct(PersonService $personService, ShipOrderService $shipOrderService) {
        $this->model = new \stdClass();
        $this->personService = new PersonService();
        $this->shipOrderService = new ShipOrderService();
    }

    public function upload($content) {

        if (empty($content)) {
            throw new UploadException('File is empty.');
        }

        try {
            $xml = simplexml_load_string($content);
            $json = json_encode($xml);
            $data = json_decode($json,false);

            if (isset($data->person)) {
                $this->personService->upload($data->person);
            } else if (isset($data->shiporder)) {
                $this->shipOrderService->upload($data->shiporder);
            }
        } catch(\Exception $e) {
            return redirect()->route('upload_screen')->with('error', 'Fail on import xml from file: ' . $e->getMessage());
        }

    }

}
