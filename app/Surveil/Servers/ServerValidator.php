<?php

namespace App\Surveil\Servers;

use Illuminate\Validation\Validator;

class ServerValidator extends Validator {

    public function validateCreate($input)
    {
        $this->runValidation($input, $this->createValidationRules());
    }

    public function validateUpdate($input)
    {
        $this->runValidation($input, $this->updateValidationRules());
    }

    protected function runValidation($input, $rules)
    {
        $this->extend('server_path', $this->validateServerPath);
        $this->extend('server_binary', $this->validateServerBinary);


    }

    protected function createValidationRules()
    {
        return [
            'name' => 'required|unique:servers',
            'path' => 'required',
            'binary' => 'required',
            'game' => 'required|in:' . implode(',', available_games()),
            'ip' => 'required',
            'port' => 'required|numeric',
            'rcon' => 'required',
            'params' => 'required',
            'surveil' => 'required|boolean'
        ];
    }

    protected function updateValidationRules()
    {
        return [
            'name' => 'required|unique:servers,' . $this->server->id,
            'path' => 'required',
            'binary' => 'required',
            'game' => 'required|in:' . implode(',', available_games()),
            'ip' => 'required',
            'port' => 'required|numeric',
            'rcon' => 'required',
            'params' => 'required',
            'surveil' => 'required|boolean'
        ];
    }

    protected function validateServerBinary()
    {

    }

    protected function validateServerPath()
    {

    }

}
