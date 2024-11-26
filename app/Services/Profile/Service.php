<?php

namespace App\Services\Profile;

use App\Models\Address;
use App\Models\User;

class Service
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index() {

    }

    public function getUser() {
        return $this->model->where('id', auth()->id())->first();
    }

    public function store($request): void
    {

    }

    public function update($request): void
    {
        User::findOrFail($request['id'])->update($request);
    }

    public function addAddress($request): void
    {
        $user = User::findOrFail($request->input('user_id'));

        $address = Address::create([
            'postal_code' => $request->input('postal_code'),
            'phone' => $request->input('phone'),
            'apartment' => $request->input('apartment'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
        ]);

        $userAddresses = json_decode($user->address_ids, true);
        array_push($userAddresses, $address->id);
        $user->address_ids = json_encode($userAddresses);
        $user->save();
    }

    public function destroy($id): void
    {

    }
}