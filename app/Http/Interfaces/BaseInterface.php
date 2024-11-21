<?php

namespace App\Http\Interfaces;

interface BaseInterface
{
    public function index($request, $model);
    public function store(array $data, $model);
    public function show($id, $model, $resource = null);
    public function update(array $data, $id, $model, $resource = null);
    public function changeStatus($id, $model);
}
