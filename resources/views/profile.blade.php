@extends('layouts.app')


@section('title')
    Личный кабинет
@endsection




@section('content')
  <profile-component>
    
  </profile-component>

  <div class="container">

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if (session()->has('profileUpdated'))
    <div class="alert alert-success">
      Информация успешно обновлена
    </div>
  @endif
  
  @if (session()->has('currentPasswordError'))
    <div class="alert alert-warning">
      Текущий пароль введен неверно
    </div>
  @endif

    <form method="POST" action="{{ route('profileUpdate') }}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class = "col-8">
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">
              Почта
            </label>
            <input type="email" name="email" class="form-control" value="{{$user->email}}">
            <div id="emailHelp" class="form-text">
              We'll never share your email with anyone else.
            </div>
          </div>

          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">
              Имя
            </label>
            <input
              class="form-control @if ($errors->has('name')) text-danger @endif" 
              name="name"
              value="{{$user->name}}">
          </div>

          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">
              Текущий пароль
            </label>
            <input
              class="form-control " 
              name="current_password"
              type="password"
              autocomplete="new-password"
            >
          </div>

          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">
              Новый пароль
            </label>
            <input
              class="form-control " 
              name="password"
              type="password"
            >
          </div>

          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">
              Подтверждение пароля
            </label>
            <input
              class="form-control" 
              name="password_confirmation"
              type="password">
          </div>

          <div class = "mb-3">
            <label class = "form-label">
              Список адресов 
              @if ($user->addresses->isEmpty())
                пока пуст
              @endif
            </label>
            <br>
            @foreach ($user->addresses as $address)
              @if ($address->main)
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="main_address" id="{{$address->id}}" value = "{{$address->id}}" checked>
                  <label class="form-check-label" for="{{$address->id}}" title = "Основной адрес">
                      <strong>{{$address->address}}</strong>
                  </label>
                </div>
              @else
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="main_address" id="{{$address->id}}" value = "{{$address->id}}" >
                          <label class="form-check-label" for="{{$address->id}}" title = "Сделать этот адрес основным">
                          {{$address->address}}
                          </label>
                        </div>
                      @endif
                  @endforeach
                </div>
                  
                

                <div class = "mb-3">
                  <label class = "form-label">
                   Добавить адрес
                  </label>
                 
                 @if ($user->addresses->isEmpty())
                 <div class="form-check mb-3">
                      <input class="form-check-input" name="isMain" type="checkbox" id="main" value="1" disabled checked>
                      <input type="hidden" id="main" name="isMain" value="1">
                      <label class="form-check-label" for="main">
                        Сделать основным
                      </label>
                  </div> 
                 @else
                  <div class="form-check mb-3">
                      <input class="form-check-input" type="checkbox" name="isMain" value="1" id="main" >
                      <label class="form-check-label" for="main">
                        Сделать основным
                      </label>
                  </div>
                 @endif
                

                  <input name = "new_address" class ="form-control" placeholder = "Введите адрес доставки">
                </div>
                 

                 
                </div>  



              <div class="col-4 mb-3 text-center">
                <label class="form-label">
                    Изображение
                </label>
                <br>
                <img 
                  style="height:98px; margin-bottom: 10px; border-radius:98px; border:2px solid grey" 
                  src="{{asset('storage/image/users/')}}/{{$user->picture}}"
                >
                             
                <input class="form-control" name="picture" type="file">
              </div> 
            </div>                         
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection