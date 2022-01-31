<template>
    <div>
        <h1>Профиль пользователя</h1>
        <div class="row">

            <div class = "col-8">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">
                        Почта
                    </label>
                    <input v-model = "user.email" type="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Имя</label>
                    <input v-model = "user.name" class="form-control" name="name">
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Текущий пароль</label>
                    <input class="form-control" name="current_password" type="password" autocomplete="new-password">
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Новый пароль</label>
                    <input class="form-control" name="password" type="password">
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Подтверждение пароля</label>
                    <input class="form-control" name="password_confirmation" type="password">
                </div>

                <div class = "mb-3">
                    <label class = "form-label">Список адресов </label>
                                        
                   <div v-for="address in addresses" :key="address.id">
                       <div v-if="address.main==1">
                            <input checked id="address.id" type="radio" name="main_address" value="address.id">
                            <label for="address.id">
                                {{address.address}}
                            </label>
                        </div>
                        <!--<div v-if="(addres.main == 0)">
                            <input checked id="address.id" type="radio" name="main_address" :value="address.id">
                            <label :for="address.id">
                                {{address.address}}
                            </label>
                        </div>-->


                    </div>
                        <!--@else
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="main_address" id="{{$address.id}}" value = "{{$address.id}}" >
                                <label class="form-check-label" for="{{$address.id}}" title = "Сделать этот адрес основным">
                                {{$address->address}}
                                </label>
                                </div>
                        @endif-->
                    
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
                <label class="form-label mb-3">Изображение</label>
                <div >
                    <img :src="`../storage/image/users/`+ user.picture" 
                        style="height:98px; margin-bottom: 10px; border-radius:98px; border:2px solid grey" >
                </div>           
                <input class="form-control" name="picture" type="file">
            </div> 


            

        </div>    

            

            
             
    </div>
</template>

<script>
    export default {
        props: [
            'user', 
            'addresses'
            
        ],
        data() {
            return{
                
            }    
        },
        mounted() {
           
        console.log (this.addresses)

        
               
        }
    }
</script>
<style scoped>

</style>