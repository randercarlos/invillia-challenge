<?php

namespace App\Http\Requests;

use App\Models\Job;
use App\Models\ShipOrder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => ['required', 'file', 'mimes:xml', 'max:5120'],    // max: 5mb
            'isAsynchronous' => ['required']
        ];
    }
}
