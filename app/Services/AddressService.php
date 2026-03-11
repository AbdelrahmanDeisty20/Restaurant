<?php

namespace App\Services;

use App\Models\Address;

class AddressService
{
    public function getAll()
    {
        return auth()->user()->addresses()->latest()->get();
    }

    public function store(array $data)
    {
        if (isset($data['is_default']) && $data['is_default']) {
            $this->resetDefault();
        }

        return auth()->user()->addresses()->create($data);
    }

    public function update(Address $address, array $data)
    {
        if (isset($data['is_default']) && $data['is_default']) {
            $this->resetDefault();
        }

        $address->update($data);
        return $address;
    }

    public function delete(Address $address)
    {
        return $address->delete();
    }

    protected function resetDefault()
    {
        auth()->user()->addresses()->update(['is_default' => false]);
    }
}
