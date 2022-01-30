@extends('layouts.app')

@section ('title')
    Все товары
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
  @if (session()->has('importQueued'))
    <div class="alert alert-success">
        Товары загружены
    </div>
  @endif

    <h1>Все товары</h1>
    <br>
    

    @if($user)
        @if($user->roles->pluck('name')->contains('Admin'))

            <h2>Управление товарами</h2>
                
                
            <form method="POST" action="{{ route('exportProducts') }}" enctype="multipart/form-data">
            @csrf
                <label class="form-label">Выгрузка всех товаров в csv-файле</label>
                <br>
                <button type="submit" class="btn btn-primary mb-5" style=" margin-right: 20px">Выгрузить товары</button>    
            </form>

            <form method="POST" action="{{ route('importProducts') }}" enctype="multipart/form-data">
                @csrf
                    <label class="form-label">Массовый импорт товаров</label>
                    <input type="file" class="form-control mb-3" name="uploadProducts" placeholder="Загрузите файл csv">
                    <button type="submit" class="btn btn-primary mb-5">Загрузить товары</button>    
                </form>
                
            <h2>Новый товар</h2>
            <form method="POST" action="{{ route('newProduct') }}" enctype="multipart/form-data">
            @csrf
            
                <div class="mb-3">
                    <label class="form-label">Название</label>
                    <input name="name" class="form-control" value="" placeholder="Введите название товара">
                    <input type="hidden" name="category_id" value="">
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
                <label class="form-label">
                    Категория 
                </label>
                
                <select class="form-select mb-3" name="category_id" required>
                        <option selected disabled>Выберите категорию</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <a href="/categories"><b>Создать новую категорию</b></a>
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
        @foreach ($products as $product)
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
         {{ $products->links() }}
    </div>
</div>
@endsection