<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422, $validator->errors());
        }

        $address = $this->addressService->store($request->all());
        return $this->created(new AddressResource($address), 'Address created successfully');
    }

    public function update(Request $request, $id)
    {
        $address = auth()->user()->addresses()->find($id);
        if (!$address) {
            return $this->notFound('Address not found');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422, $validator->errors());
        }

        $updatedAddress = $this->addressService->update($address, $request->all());
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
