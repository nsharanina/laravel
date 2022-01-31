@extends('layouts.app')

@section('style')
        <style>
            .itogo{
                text-align:right;
            }
        </style>
@endsection


@section('content')
<div class="container">
@if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach

        @if ($errors ->has('email'))
            Пользователь с таким адресом уже существует, авторизуйтесь, пожалуйста, <a href= "{{ route('login') }}">здесь</a>.
        @endif
      </ul>
    </div>
  @endif


    @if (session()->has('orderCreated'))
        <div class="alert alert-success">
            Заказ создан. 
            Содержание заказа отправлено на e-mail
        </div>
    @endif 

    <table class="table table-bordered">
        <thead>
            <td>Название</td> 
            <td>Цена, ₽</td>
            <td>Количество</td>
            <td>Сумма, ₽ </td>
        </thead>

        <tbody>

            @forelse ($products as $product)
            <tr>
                    <td>{{$product['name']}}</td> 
                    <td>{{$product['price']}} ₽</td>
                    <td>{{$product['quantity']}}</td>
                    <td>{{$product['quantity'] * $product['price'] }} ₽ </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">
                    Ваша корзина пока пуста. Выберите товары в <a href = "/">каталоге</a>
                </td>
            </tr>
            @endforelse
            @if ($products->count())
            <tr>
                    <td colspan=3 class="itogo"><b>Итого:</b></td>
                <td>{{$products->map(function($product)
                        {return $product['price'] * $product['quantity'];})->
                        sum();}} ₽
                </td>
             </tr>   
        </tbody>
    </table>
    
    <form method="post" action="{{ route('createOrder')}}">
    @csrf    
        <label>Имя</label>
        <input class="form-control mb-3" name="name" value="{{ $name ?? '' }}">

        <label>Адрес доставки</label>
        <input class="form-control mb-3" name="address" value="{{$mainAddress->address ?? ''}}">

        <label>Почта</label>
        <input class="form-control mb-5"name="email" value="{{$email ?? ''}}">


        @if($products->isEmpty())
            <button class="btn btn-success mb-3" disabled>Оформить заказ</button>
        @else
            <button class="btn btn-success mb-3">Оформить заказ</button>
        @endif
    </form>
    @endif
</div>
@endsection