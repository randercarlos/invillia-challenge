<?php

namespace App\Services;

use App\Exceptions\UploadException;
use App\Models\Person;
use App\Models\Phone;
use App\Models\ShipOrder;
use App\Models\ShipOrderDetail;
use Illuminate\Support\Facades\Log;

class ShipOrderService extends AbstractService
{
    protected $model;

    public function __construct() {
        $this->model = new ShipOrder();
    }

    public function upload($data) {

//        dd($data);
        if (count($data) > 0) {
            foreach($data as $order) {
                $person = Person::findorfail((int) $order->orderperson);

                $orderObj = new ShipOrder([
                    'id' => $order->orderid,
                    'destinatary_name' => $order->shipto->name,
                    'destinatary_address' => $order->shipto->address,
                    'destinatary_city' => $order->shipto->city,
                    'destinatary_country' => $order->shipto->country,
                ]);
                $orderObj->person()->associate($person);
                $orderObj->save();

                $items = [];

                if (isset($order->items->item) && is_array($order->items->item)) {
                    if (count($order->items->item) > 0) {
                        foreach($order->items->item as $item) {
                            $items[] = new ShipOrderDetail([
                                'title' => $item->title,
                                'note' => $item->note,
                                'quantity' => $item->quantity,
                                'price' => $item->price,
                            ]);
                        }
                    }
                } else if (isset($order->items->item) && !is_array($order->items->item)) {
                    $items[] = new ShipOrderDetail([
                        'title' => $order->items->item->title,
                        'note' => $order->items->item->note,
                        'quantity' => $order->items->item->quantity,
                        'price' => $order->items->item->price,
                    ]);
                }

                $orderObj->shipOrderDetails()->saveMany($items);
            }

            Log::info('Ship orders imported successfully.');
        }

    }

}
