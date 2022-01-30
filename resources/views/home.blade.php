@extends('layouts.app')

@section ('title')
    Home
@endsection

       
@section('content')

<div class="container">
    @auth
        Вы авторизованы
    @endauth

    @guest
        Авторизуйтесь, пожалуйста
    @endguest

    @if ($showTitle)
        <h1>{{$title}}</h1>

    @else 
        Нет заголовка    
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if (session()->has('categoryAdded'))
    <div class="alert alert-success">
      Информация успешно обновлена
    </div>
  @endif
  @if (session()->has('exportQueued'))
    <div class="alert alert-success">
      Категории выгружены
    </div>
  @endif
  @if (session()->has('importQueued'))
    <div class="alert alert-success">
      Категории загружены
    </div>
  @endif
  
    

    
    @if ($user)
        @if ($user->roles->pluck('name')->contains('Admin'))
            <h2>Управление категориями</h2>
            
            
                <form method="POST" action="{{ route('exportCategories') }}" enctype="multipart/form-data">
                @csrf
                    <label class="form-label">Выгрузка всех категорий в csv-файле</label>
                    <br>
                    <button type="submit" class="btn btn-primary mb-3" >Выгрузить категории</button>
                </form>

                <form method="POST" action="{{ route('importCategories') }}" enctype="multipart/form-data">
                @csrf
                    <label class="form-label">Массовый импорт категорий</label>
                    <input type="file" class="form-control mb-3" name="uploadCategories" placeholder="Загрузите файл csv">
                    <button type="submit" class="btn btn-primary mb-5">Загрузить категории</button>    
                </form>
            

            <h2>Новая категория</h2>
            <form method="POST" action="{{ route('addCategory') }}" enctype="multipart/form-data">
            @csrf
            
                <div class="mb-3">
                    <label class="form-label">Название</label>
                    <input name="name" class="form-control" value="" placeholder="Введите название категории">
                </div>
                    
                <div class="mb-3">
                    <label class="form-label">Описание</label>
                    <textarea class="form-control" name="description" id="description" rows="3"></textarea>
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
        @foreach ($categories as $category)
        
            <div class="col-4 mb-4">
                <a href="/categories/{{$category->id}}">
                    <div class="card" style="width: 300px;">
                        <img class="card-img" src="{{asset('storage/image/categories/')}}/{{$category->picture}}" alt="{{$category->name}}">
                        <div class="card-body">
                            <h5 class="card-title">
                                {{$category->name}} ({{$category->products->count()}})</h5>
                            <p class="card-text">{{$category->description}}</p>
                            <a href="{{route('category', $category->id)}}" class="btn btn-primary">Перейти</a>
                        </div>
                    </div>
                </a>
            </div>  
        @endforeach
    </div>
    {{ $categories->links() }}
</div>
@endsection

