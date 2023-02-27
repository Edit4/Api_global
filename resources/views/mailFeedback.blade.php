@php
    use App\Http\Controllers\MailController;

@endphp



<form role="form"  method="post" class="m-t-15" enctype="multipart/form-data">

    <div class="form-group form-group-default">

        Имя фамилия:    {{$fio}}
        <br>
        Email:    {{$email}}
        <br>
        Телефон:  {{$phone}}
        <br>
        Компания:     {{$company}}





    </div>
</form>
