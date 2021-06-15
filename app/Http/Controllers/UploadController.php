<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFormRequest;
use App\Jobs\ProcessUpload;
use App\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    private $uploadService;

    public function __construct(UploadService $uploadService) {
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        return view('index');
    }

    public function upload(UploadFormRequest $request)
    {
        if ($request->has('isAsynchronous') && $request->boolean('isAsynchronous')) {
            ProcessUpload::dispatch(request()->file('file')->getContent());

            return redirect()->route('upload_screen')->with('info', 'Upload está sendo processado.');
        } else {
            $this->uploadService->upload(request()->file('file')->getContent());

            return redirect()->route('upload_screen')->with('success', 'Upload importado com sucesso.');
        }
    }
}
