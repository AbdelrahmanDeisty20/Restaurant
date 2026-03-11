<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreAddressRequest;
use App\Http\Requests\API\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Services\AddressService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    use ApiResponse;

    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index()
    {
        $addresses = $this->addressService->getAll();
        return $this->success(AddressResource::collection($addresses));
    }

    public function store(StoreAddressRequest $request)
    {
        $address = $this->addressService->store($request->validated());
        return $this->created(new AddressResource($address), 'Address created successfully');
    }

    public function update(UpdateAddressRequest $request, $id)
    {
        $address = auth()->user()->addresses()->find($id);
        if (!$address) {
            return $this->notFound('Address not found');
        }

        $updatedAddress = $this->addressService->update($address, $request->validated());
        return $this->success(new AddressResource($updatedAddress), 'Address updated successfully');
    }

    public function destroy($id)
    {
        $address = auth()->user()->addresses()->find($id);
        if (!$address) {
            return $this->notFound('Address not found');
        }

        $this->addressService->delete($address);
        return $this->deleted('Address deleted successfully');
    }
}
