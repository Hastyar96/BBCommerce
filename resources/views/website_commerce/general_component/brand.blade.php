 @php
 $brands = App\Models\Brand::all();
 @endphp
 <!-- Brands Section -->
 <div class="container">
     <!-- Brands Section -->
     <section class="brands-section">
         <h2 class="section-title">{{ __('f.our_brand') }}</h2>
         <div class="brands-container">
             @foreach($brands as $brand)
             <a href="{{ url('products?brand_id=/'.$brand->id) }}" style="">
                 <div class="brand-card">
                     <img src="{{ asset($brand->logo) }}" alt="alt">
                 </div>
             </a>
             @endforeach
         </div>
     </section>
 </div>


 <style>
     /* Brands Section */
     .brands-section {
         max-width: 1200px;
         margin: 60px auto;
     }

     .brands-container {
         display: grid;
         grid-template-columns: repeat(6, 1fr);
         gap: 20px;
         margin-top: 20px;
     }

     .brand-card {
         background-color: #fff;
         border-radius: 10px;
         padding: 20px;
         display: flex;
         justify-content: center;
         align-items: center;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
         transition: transform 0.3s;
     }

     .brand-card:hover {
         transform: translateY(-5px);
     }

     .brand-card img {
         max-width: 100%;
         max-height: 60px;
         filter: grayscale(100%);
         opacity: 0.7;
         transition: all 0.3s;
     }

     .brand-card:hover img {
         filter: grayscale(0%);
         opacity: 1;
     }

     /* Responsive Styles for Brands Section */
     @media (max-width: 1024px) {
         .brands-container {
             grid-template-columns: repeat(3, 1fr);
             grid-template-rows: repeat(2, auto);
             gap: 15px;
             padding: 0 15px;
         }
     }

     @media (max-width: 768px) {
         .brands-container {
             grid-template-columns: repeat(3, 1fr);
             grid-template-rows: repeat(2, auto);
             padding: 0 10px;
         }

         .brand-card {
             padding: 15px;
         }

         .brand-card img {
             max-height: 50px;
         }
     }

     @media (max-width: 480px) {
         .brands-container {
             grid-template-columns: repeat(3, 1fr);
             grid-template-rows: repeat(2, auto);
         }
     }

 </style>
