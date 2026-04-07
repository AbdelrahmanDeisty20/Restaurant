<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreContactRequest;
use App\Services\ContactService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    use ApiResponse;

    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    // public function store(StoreContactRequest $request)
    // {
    //     $this->contactService->store($request->validated());
    //     return $this->messageOnly(__('messages.contact_message_sent_successfully'));
    // }
}
