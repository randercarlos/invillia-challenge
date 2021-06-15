<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonFormRequest;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    private $personService;

    public function __construct(PersonService $personService) {
        $this->personService = $personService;
    }

    public function index(Request $request)
    {
        return response()->json($this->personService->loadAll());
    }

    public function show(int $id)
    {
        return response()->json($this->personService->find($id));
    }

}
