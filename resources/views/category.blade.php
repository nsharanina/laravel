@extends('layouts.app')


@section ('title')
{{ $category->name }}
@endsection


@section ('content')


<div class = "container">
@if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if (session()->has('newProduct'))
    <div class="alert alert-success">
      Информация успешно обновлена
    </div>
  @endif

  @if (session()->has('exportQueued'))
    <div class="alert alert-success">
      Создана задача экспорта
    </div>
  @endif


    <h1>Категория {{ $category->name }} </h1>
    <h3>Название категории: {{ $category->name }} </h3>
    <h3>Описание категории: {{ $category->description }} </h3>
    <br>
    

    @if($user)
        @if($user->roles->pluck('name')->contains('Admin'))
           
                <h2>Новый товар</h2>
                <form method="POST" action="{{ route('newProduct') }}" enctype="multipart/form-data">
                @csrf
                
                    <div class="mb-3">
                        <label class="form-label">Название</label>
                        <input name="name" class="form-control" value="" placeholder="Введите название товара">
                        <input type="hidden" name="category_id" value="{{$category->id}}">
                    </div>
                        
                    <div class="mb-3">
                        <label class="form-label">Описание</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Цена</label>
                        <input type = "number" name="price" class="form-control" value="" step="0.01" placeholder="Введите цену товара">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Изображение</label>
                        <input type="file" name="picture" class="form-control" value="" placeholder="Загрузите файл">
                    </div>

                    <button type="submit" class="btn btn-primary mb-5">Сохранить</button>
                    
                </form>
        @endif
    @endif    
   
    
    <div class="row">
        @foreach ($category->products as $product)
            <div class="col-4 mb-4">
                <a href="/">
                    <div class="card" style="width:300px">
                        <img class="card-img" src="{{asset('storage/image/products/')}}/{{$product->picture}}" alt="{{$product->picture}}">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{$product->name}} </h5>
                            <p class="card-text">
                            {{substr($product->description, 0, 90)}}...
                            </p>
                            <div class="card-basket-buttons">
                                <form method="post" action="{{ route('removeProduct')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$product->id}}"> 
                                    <button class="btn btn-danger" >-</button>
                                </form>
                                <div class="card-basket-quantity">
                                {{ session("products.{$product->id}") }}
                                </div>
                                    
                                <form method="post" action="{{ route('addProduct')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$product->id}}"> 
                                    <button type="submit" class="btn btn-success">+</button>
                                </form>
                            </div>
                            <div class="card-price">
                                {{$product->price}} ₽
                            </div>
                            
                        </div>
                    </div>
                </a>
            </div>

        @endforeach
    </div>
    
</div>
@endsection