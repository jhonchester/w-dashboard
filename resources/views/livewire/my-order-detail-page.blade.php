<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <h1 class="text-4xl font-bold text-slate-500">Order Details</h1>

  <!-- Grid -->
  <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mt-5">
    <!-- Card -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
      <div class="p-4 md:p-5 flex gap-x-4">
        <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
          <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
          </svg>
        </div>

        <div class="grow">
          <div class="flex items-center gap-x-2">
            <p class="text-xs uppercase tracking-wide text-gray-500">
              Customer
            </p>
          </div>
          <div class="mt-1 flex items-center gap-x-2">
            <div>{{ $user->name}}</div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
      <div class="p-4 md:p-5 flex gap-x-4">
        <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
          <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 22h14" />
            <path d="M5 2h14" />
            <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
            <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
          </svg>
        </div>

        <div class="grow">
          <div class="flex items-center gap-x-2">
            <p class="text-xs uppercase tracking-wide text-gray-500">
              Order Date
            </p>
          </div>
          <div class="mt-1 flex items-center gap-x-2">
            <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200">
              {{$order_items[0]->created_at->format('d-m-y')}}
            </h3>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
      <div class="p-4 md:p-5 flex gap-x-4">
        <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
          
        </div>

        <div class="grow">
          <div class="flex items-center gap-x-2">
            <p class="text-xs uppercase tracking-wide text-gray-500">
              Scheduled Date To Claim
            </p>
          </div>
          <div class="mt-1 flex items-center gap-x-2">
            <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200">
              {{ $formatted_claim_date }}
            </h3>
          </div>
        </div>
      </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    {{-- <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
      <div class="p-4 md:p-5 flex gap-x-4">
        <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
          <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6" />
            <path d="m12 12 4 10 1.7-4.3L22 16Z" />
          </svg>
        </div>

        <div class="grow">
          <div class="flex items-center gap-x-2">
            <p class="text-xs uppercase tracking-wide text-gray-500">
              Order Status
            </p>
          </div>
          <div class="mt-1 flex items-center gap-x-2">
            @php
                $status= '';
                if ($order->status == 'new') {
                          $status = '<span class="bg-blue-500 py-1 px-3 rounded text-white shadow">New</span>';
                      } elseif ($order->status == 'processing') {
                          $status = '<span class="bg-yellow-500 py-1 px-3 rounded text-white shadow">Processing</span>';
                      } elseif ($order->status == 'claimed') {
                          $status = '<span class="bg-green-500 py-1 px-3 rounded text-white shadow">Claimed</span>';
                      } elseif ($order->status == 'cancelled') {
                          $status = '<span class="bg-red-500 py-1 px-3 rounded text-white shadow">Cancelled</span>';
                    }
            @endphp
            {!! $status !!}
          </div>
        </div>
      </div>
    </div> --}}
    <!-- End Card -->

    <!-- Card -->
    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
      <div class="p-4 md:p-5 flex gap-x-4">
        <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
          <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12s2.545-5 7-5c4.454 0 7 5 7 5s-2.546 5-7 5c-4.455 0-7-5-7-5z" />
            <path d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
            <path d="M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2" />
            <path d="M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2" />
          </svg>
        </div>

        <div class="grow">
          <div class="flex items-center gap-x-2">
            <p class="text-xs uppercase tracking-wide text-gray-500">
              Payment Status
            </p>
          </div>
          <div class="mt-1 flex items-center gap-x-2">
            @php
                 $payment_status = '';
                      if ($order->payment_status == 'pending') {
                          $payment_status = '<span class="bg-blue-500 py-1 px-3 rounded text-white shadow">Pending</span>';
                      } elseif ($order->payment_status == 'paid') {
                          $payment_status = '<span class="bg-green-500 py-1 px-3 rounded text-white shadow">Paid</span>';
                      } elseif ($order->payment_status == 'failed') {
                          $payment_status = '<span class="bg-red-500 py-1 px-3 rounded text-white shadow">Failed</span>';
                      }
            @endphp
              {!! $payment_status !!}
          </div>
        </div>
      </div>
    </div>
    <!-- End Card -->
  </div>
  <!-- End Grid -->

  <div class="flex flex-col md:flex-row gap-4 mt-4">
    <div class="md:w-3/4">
      <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
        <table class="w-full">
          <thead>
            <tr>
              <th class="text-left font-semibold">Product</th>
              <th class="text-left font-semibold">Price</th>
              <th class="text-left font-semibold">Quantity</th>
              <th class="text-left font-semibold">Total</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($order_items as $item)
            <tr wire:key="{{$item->id}}">
                <td class="py-4">
                    <div class="flex items-center">
                        <!-- Check if the product exists and if the image is available -->
                        @if ($item->product && isset($item->product->image[0]))
                            <img class="h-16 w-16 mr-4" src="{{ url('storage', $item->product->image[0]) }}" alt="{{ $item->product->name }}">
                        @else
                            <span>{{ $item->product->name ?? 'Product not found' }}</span>
                        @endif
                        
                    </div>
                </td>
                <td class="py-4">{{Number::currency($item->unit_amount, 'PHP')}}</td>
                <td class="py-4">
                    <span class="text-center w-8">{{$item->quantity}}</span>
                </td>
                <td class="py-4">{{Number::currency($item->total_amount, 'PHP')}}</td>
            </tr>
        @endforeach
        
            <!--[if BLOCK]><![endif]-->
            
            
            <!--[if ENDBLOCK]><![endif]-->

          </tbody>
        </table>
      </div>

      <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
        <h1 class="font-3xl font-bold text-slate-500 mb-3">Review</h1>
      
        <!-- Loop through each order item -->
        <div>
          @foreach ($order_items as $item)
            <div class="flex justify-between items-center mb-3">
              <!-- Product Name -->
              <p class="flex-grow text-sm text-gray-700">{{ $item->product->name }}</p>
      
              <!-- Star Rating -->
              <div class="flex items-center space-x-1">
                @for ($i = 1; $i <= 5; $i++) <!-- Loop 5 times for 5 stars -->
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                      fill="{{ isset($productRatings[$item->product->name]) && $productRatings[$item->product->name] >= $i ? 'yellow' : 'gray' }}"
                      viewBox="0 0 24 24" class="star cursor-pointer"
                      wire:click="setRating({{ $i }}, '{{ $item->product->name }}')">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                  </svg>
                @endfor
              </div>
            </div>
      
            <!-- Textarea for Review under each product -->
            <div class="mt-4">
              <textarea class="w-full p-4 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Leave your review here..."
                        rows="4"
                        wire:model="productReviews.{{ $item->product->name }}">
                  {{ $productReviews[$item->product->name] ?? '' }}
              </textarea>
            </div>
          @endforeach
        </div>
      
        <!-- Button to Submit Review -->
        <div class="mt-4">
          <button wire:click="submitReview" 
                  class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                  wire:disabled="{{ $this->canSubmitReview ? '' : 'true' }}">
              <span wire:loading.remove wire:target="submitReview">Submit Review</span>
              <span wire:loading wire:target="submitReview">Submitting...</span>
          </button>
      </div>
      </div>
      
    
    
    
    





      <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
        <h1 class="font-3xl font-bold text-slate-500 mb-3">RGO Location</h1>
        <div class="flex justify-between items-center">
          <div>
            <p>CICS Ground Floor</p>
          </div>
          <div>
            <p class="font-semibold">Phone:</p>
            <p>023-509-0009</p>
          </div>
        </div>
      </div>
      
      
      

    </div>
    <div class="md:w-1/4">
      <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4">Summary</h2>
        <div class="flex justify-between mb-2">
          <span>Subtotal</span>
          <span>{{Number::currency($item->order->grand_total, 'PHP')}}</span>
        </div>
        
        <hr class="my-2">
        <div class="flex justify-between mb-2">
          <span class="font-semibold">Grand Total</span>
          <span class="font-semibold">{{Number::currency($item->order->grand_total, 'PHP')}}</span>
        </div>

      </div>
    </div>
    
  </div>
  
</div>