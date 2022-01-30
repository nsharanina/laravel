@extends ('layouts.app')

@section('content')
    <div class="container">

        @foreach (Auth::user()->orders as $order)
        <p>
            <a class="btn btn-link" data-bs-toggle="collapse" href="#order{{ $order->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                #{{ $order->id }} 
            </a>
            {{date('d.m.Y H:i:s', strtotime($order->created_at))}}
        </p>
        <div class="collapse mb-3" id="order{{ $order->id }}">
            <div class="card card-body">
                <ul>
                    @foreach ($order->products as $product)
                        <li> 
                            <p>Товар: {{ $product->name }} </p> 
                            <p>Цена: {{ $product->pivot->price }} ₽</p> 
                            <p>Количество: {{ $product->pivot->quantity}} </p> 
                            
                        </li>
                    @endforeach
                    
                </ul>
            </div>
           
        </div>

        @endforeach
        
</div>
@endsection