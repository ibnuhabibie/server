<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Redis;

class ShareRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! Redis::exists($this->getKey());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'error' => 'required',
            'tabs' => 'required|array|min:1',
            'lineSelection' => [],
        ];
    }

    /**
     * Uniquely identify the report object.
     *
     * @return string
     */
    public function getKey()
    {
        return md5(serialize($this->get('error')));
    }
}
