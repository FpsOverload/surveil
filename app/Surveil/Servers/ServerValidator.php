<?php

namespace App\Surveil\Servers;

use App\Exceptions\ServerCreationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServerValidator {

    public function validateCreate($input)
    {
        return $this->runValidation($input, $this->createValidationRules());
    }

    public function validateUpdate($input)
    {
        return $this->runValidation($input, $this->updateValidationRules());
    }

    protected function runValidation($input, $rules)
    {
        Validator::extend('server_path', 'App\Surveil\Servers\ServerValidator@validateServerPath');
        Validator::extend('server_binary', 'App\Surveil\Servers\ServerValidator@validateServerBinary');

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            throw new ServerCreationException($validator->errors());
        }
        
        return true;
    }

    protected function createValidationRules()
    {
        return [
            'name' => 'required|unique:servers',
            'path' => 'required|server_path',
            'binary' => 'required|server_binary',
            'game' => 'required|in:' . implode(',', available_games()),
            'ip' => 'required',
            'port' => 'required|numeric',
            'rcon' => 'required',
            'default_params' => 'required',
            'default_surveil' => 'required|boolean'
        ];
    }

    protected function updateValidationRules()
    {
        return [
            'name' => 'required|unique:servers,' . $this->server->id,
            'path' => 'required|server_path',
            'binary' => 'required|server_binary',
            'game' => 'required|in:' . implode(',', available_games()),
            'ip' => 'required',
            'port' => 'required|numeric',
            'rcon' => 'required',
            'default_params' => 'required',
            'default_surveil' => 'required|boolean'
        ];
    }

    public function validateServerBinary($attribute, $value, $parameters, $validator)
    {
        return is_file(rtrim($validator->getData()['path'], '/') . '/' . $value);
    }

    public function validateServerPath($attribute, $value, $parameters, $validator)
    {
        return is_dir($value);
    }

}
