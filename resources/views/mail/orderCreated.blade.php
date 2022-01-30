<h1>
    {{ $data['user']['name'] }}, здравствуйте. Вы оформили заказ:
</h1>
<div class="container">
    <table class="table table-bordered">
            <thead>
                <td>Название</td> 
                <td>Цена, ₽</td>
                <td>Количество</td>
                <td>Сумма, ₽ </td>
            </thead>

            <tbody>

                @foreach ($data['products'] as $product)
                <tr>
                        <td>{{$product['name']}}</td> 
                        <td>{{$product['price']}} ₽</td>
                        <td>{{$product['quantity']}}</td>
                        <td>{{$product['quantity'] * $product['price'] }} ₽ </td>
                </tr>
                @endforeach
                <tr>
                        <td colspan=3 style ="text-align: right"><b>Итого:</b></td>
                    <td>{{$data['products']->map(function($product)
                            {return $product['price'] * $product['quantity'];})->
                            sum();}} ₽
                    </td>
                </tr>   
            </tbody>
        </table>
    </div>