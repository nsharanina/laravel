@extends('../layouts.app')

@section('title')  
    Админка
@endsection

@section('content') 
<div class="container mb-5">
    <h1>Разделы</h1>
    <div class="row">
        <div class="col-4">
            <a href="admin/categories">
                <div class="card" style="width:300px;">
                    <img class="card-img" style="width:300px" src="{{asset('storage/image/admin/categories.jpg')}}" alt="Categories"> 
                    
                    <div class="card-body">
                        <h5 class="card-title">
                            Категории товаров</h5>
                        <a href="{{route('categories')}}" class="btn btn-primary">Перейти</a>
                    </div>

                </div>
            </a>
        </div>

        <div class="col-4">
            <a href="/admin/products">
                <div class="card" style="width: 300px;">
                    <img class="card-img" style="width:300px" src="{{asset('storage/image/admin/products.png')}}" alt="Categories"> 
                    <div class="card-body">
                            <h5 class="card-title">
                               Товары</h5>
                            <a href="{{route('products')}}" class="btn btn-primary">Перейти</a>
                    </div>

                </div>
            </a>
        </div>

        <div class="col-4">
            <a href="/admin/users">
                <div class="card" style="width: 300 px;">
                    <img class="card-img" style="width:300px" src="{{asset('storage/image/admin/users.png')}}" alt="Categories"> 
                    <div class="card-body">
                            <h5 class="card-title">
                                Пользователи</h5>
                            <a href="{{route('users')}}" class="btn btn-primary">Перейти</a>
                    </div>

                </div>
            </a>
        </div>
    </div>

</div>
       
@endsection