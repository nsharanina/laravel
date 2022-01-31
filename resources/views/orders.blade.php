@extends ('layouts.app')

@section('content')
    <div class="container">

        @foreach ($user->orders as $order)
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
                            {{$user->id}}
                            <p>Товар: {{ $product->name }} </p> 
                            <p>Цена: {{ $product->pivot->price }} ₽</p> 
                            <p>Количество: {{ $product->pivot->quantity}} </p> 
                            
                        </li>
                    @endforeach
                </ul>

                <form method="POST" action="{{ route('repeatOrder') }}" enctype="multipart/form-data">
                @csrf
                    <input name="order_id" type="hidden" value="{{ $order->id }}">
                    <button class="btn btn-primary" type="submit">Повторить</button>
                </form>

            </div>
           

        </div>

        @endforeach
        
</div>
@endsection