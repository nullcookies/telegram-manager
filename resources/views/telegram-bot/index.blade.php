@extends('layout.main')

@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Боты Telegram</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="#">Боты Telegram</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#smallmodal">Добавить бота</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <dov class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Список ботов</strong>
                        </div>
                        <div class="card-body">
                            @if ($bots != null)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Название</th>
                                            <th scope="col">Дата добавления</th>
                                            <th scope="col">Управление</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bots as $item)
                                            <tr>
                                                <td>{{$loop->index + 1}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->created_at}}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    Вы еще не добавили ниодного бота. Нажмите на <a href="#" class="alert-link">кнопку</a> чтобы добавить бота.
                                </div>
                            @endif

                        </div>
                    </div>
                </dov>
            </div>
        </div>
    </div>


    <!-- Add bot modal -->
    <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Добавить нового бота</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['id' => 'newBotForm']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Имя бота') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('token', 'Ключ доступа') !!}
                        {!! Form::text('token', null, ['class' => 'form-control', 'required' => true]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    {!! Form::button('Добавить', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{asset('js/notify.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#newBotForm").submit(function (e) {
                e.preventDefault();
                console.log('Form submit');

                var data = new FormData(this);

                $.ajax({
                    url: '{{route("telegram.post.bot")}}',
                    method: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success == true) {
                            setTimeout(function () {
                                $.notify("Бот добавлен, страница будет перезагружена.", "success");
                            }, 2000);
                            window.location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endsection