<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <section class="overflow-hidden bg-white py-11 font-poppins dark:bg-gray-800">
    <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
      <div class="flex flex-wrap -mx-4">
        <!-- Product Images Section -->
        <div class="w-full mb-8 md:w-1/2 md:mb-0" x-data="{ mainImage: '{{url('storage', $product->images[0])}}' }">
          <div class="sticky top-0 z-50 overflow-hidden">
            <div class="relative mb-6 lg:mb-10 lg:h-2/4">
              <img x-bind:src="mainImage" alt="" class="object-cover w-full lg:h-full">
            </div>
            <div class="flex-wrap hidden md:flex">
              @foreach ($product->images as $image)
                <div class="w-1/2 p-2 sm:w-1/4" x-on:click="mainImage='{{url('storage', $image)}}'">
                  <img src="{{url('storage', $image)}}" alt="{{$product->name}}" class="object-cover w-full lg:h-20 cursor-pointer hover:border hover:border-blue-500">
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Product Details Section -->
        <div class="w-full px-4 md:w-1/2">
          <div class="lg:pl-20">
            <div class="mb-8 [&>ul]:list-disc [&>ul]:ml-4">
              <h2 class="max-w-xl mb-6 text-2xl font-bold dark:text-gray-400 md:text-4xl">{{$product->name}}</h2>
              <p class="inline-block mb-6 text-4xl font-bold text-gray-700 dark:text-gray-400">
                <span>{{Number::currency($product->price, 'PHP')}}</span>
              </p>
              <p class="max-w-md text-gray-700 dark:text-gray-400">{!! Str::markdown($product->description) !!}</p>
            </div>

            <div class="w-32 mb-8">
              <label for="" class="w-full pb-1 text-xl font-semibold text-gray-700 border-b border-blue-300 dark:border-gray-600 dark:text-gray-400">Quantity</label>
              <div class="relative flex flex-row w-full h-10 mt-6 bg-transparent rounded-lg">
                <button wire:click="decreaseQty" class="w-20 h-full text-gray-600 bg-gray-300 rounded-l outline-none cursor-pointer dark:hover:bg-gray-700 dark:text-gray-400 hover:text-gray-700 dark:bg-gray-900 hover:bg-gray-400">
                  <span class="m-auto text-2xl font-thin">-</span>
                </button>
                <input type="number" wire:model='quantity' readonly class="flex items-center w-full font-semibold text-center text-gray-700 placeholder-gray-700 bg-gray-300 outline-none dark:text-gray-400 dark:placeholder-gray-400 dark:bg-gray-900 focus:outline-none text-md hover:text-black" placeholder="1">
                <button wire:click="increaseQty" class="w-20 h-full text-gray-600 bg-gray-300 rounded-r outline-none cursor-pointer dark:hover:bg-gray-700 dark:text-gray-400 dark:bg-gray-900 hover:text-gray-700 hover:bg-gray-400">
                  <span class="m-auto text-2xl font-thin">+</span>
                </button>
              </div>
            </div>

            <div class="flex flex-wrap items-center gap-4">
              <button wire:click="addToCart({{$product->id}})" class="w-full p-4 bg-blue-500 rounded-md lg:w-2/5 dark:text-gray-200 text-gray-50 hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-700">
                <span wire:loading.remove wire:target="addToCart({{$product->id}})">Add to cart</span><span wire:loading wire:target="addToCart({{$product->id}})">Adding...</span>
              </button>
            </div>

            <div class="flex items-center space-x-2 mt-4">
              <span class="text-lg font-medium">Average Rating:</span>
              @for ($i = 1; $i <= 5; $i++)
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                       fill="{{ $averageRating >= $i ? 'yellow' : 'gray' }}" viewBox="0 0 24 24" class="star">
                      <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                  </svg>
              @endfor
              <span class="text-sm text-gray-600">({{ number_format($averageRating, 1) }} / 5)</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Customer Reviews Section -->
    <div class="mt-12 px-4 lg:px-8">
      <h3 class="pl-4 text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Customer Reviews</h3>
      <div class="mt-8 space-y-8">
        @foreach ($reviews as $review)
          <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="flex items-start space-x-4">
              <!-- Avatar Section -->
              <div class="flex-shrink-0">
                <div class="w-14 h-14 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-gray-600 dark:text-gray-200">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4z"/>
                  </svg>
                </div>
              </div>
              <!-- Review Content -->
              <div class="w-full">
                <div class="flex justify-between items-center mb-4">
                  <div class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                    {{ $review['user_name'] }}
                  </div>
                  <div class="flex items-center space-x-1">
                    <!-- Star Ratings -->
                    @for ($i = 1; $i <= 5; $i++)
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="{{ $review['rating'] >= $i ? 'yellow' : 'gray' }}" viewBox="0 0 24 24" class="star">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                      </svg>
                    @endfor
                  </div>
                </div>
                <p class="text-gray-700 dark:text-gray-400 text-md leading-relaxed">
                  {{ $review['review'] }}
                </p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    
  </section>
</div>
