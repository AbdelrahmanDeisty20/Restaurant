<?php
 
 namespace App\Observers;
 
 use App\Models\Offer;
 use App\Models\AppNotification;
 use App\Services\NotificationService;
 
 class OfferObserver
 {
     protected $notificationService;
 
     public function __construct(NotificationService $notificationService)
     {
         $this->notificationService = $notificationService;
     }
 
     /**
      * Handle the Offer "created" event.
      */
     public function created(Offer $offer): void
     {
         $productName = $offer->product->name ?? '';
         
         $this->notificationService->broadcastNotification(
             __('messages.new_offer_title'),
             __('messages.new_offer_body', ['product_name' => $productName]),
             [
                 'type' => 'new_offer',
                 'offer_id' => $offer->id,
                 'product_id' => $offer->product_id,
             ]
         );
 
         // Save notification to database
         AppNotification::create([
             'user_id' => null, // Broadcast
             'title' => __('messages.new_offer_title'),
             'body' => __('messages.new_offer_body', ['product_name' => $productName]),
             'type' => 'new_offer',
             'data' => [
                 'offer_id' => $offer->id,
                 'product_id' => $offer->product_id,
             ],
         ]);
     }
 }
