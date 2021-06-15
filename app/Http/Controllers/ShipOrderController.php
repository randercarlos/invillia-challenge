<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShipOrderFormRequest;
use App\Models\ShipOrder;
use App\Services\ShipOrderService;
use Illuminate\Http\Request;

class ShipOrderController extends Controller
{
    private $shipOrderService;

    public function __construct(ShipOrderService $shipOrderService) {
        $this->shipOrderService = $shipOrderService;
    }

    public function index(Request $request)
    {
        return response()->json($this->shipOrderService->loadAll());
    }

    public function show(int $id)
    {
        return response()->json($this->shipOrderService->find($id));
    }
}
