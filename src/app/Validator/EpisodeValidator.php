<?php

namespace App\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EpisodeValidator
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function validate()
    {
        return Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    public function rules()
    {
        return [
            "episode" => "required|unique:episodes,episode" . $this->request->id,
            "name" => "required|unique:episodes,name" . $this->request->id,
            "characters" => "required",
        ];
    }

    public function messages()
    {
        return [];
    }
}
