@extends('../layouts.app')

@section('title')  
    Управление пользователями
@endsection

@section('content') 

    <div class = "container mb-5">
        <h1>Управление пользователями</h1>
        <table class = "table table-bordered">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Имя пользователя</td>
                    <td>E-mail пользователя</td>
                    <td>Роль</td>
                    <td>Статус блокировки</td>
                    <td>Авторизация</td>
                </tr> 
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <ul>
                            @foreach ($user->roles as $role)
                                <li> 
                                    {{$role->name}}   
                                </li>
                            @endforeach
                            </ul>
                        </td>
                        <td>
                        <ul>
                            @foreach ($user->roles as $role)
                                <li>
                                @if ($role->pivot->blocked)                                         
                                    Заблокировано
                                @else Активно
                                @endif
                                </li>
                            @endforeach
                            </ul>
                        </td>
                        <td>
                            <a href="{{route('enterAsUser', $user->id)}}">Войти</a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    





    
@endsection