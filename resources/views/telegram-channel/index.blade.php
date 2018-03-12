@extends('layout.main')

@section ('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Каналы Telegram</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="#">Каналы Telegram</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-6">
                    {{Form::open(['route' => 'telegram.channel.new', 'class' => 'form-inline', 'id' => 'addChannelForm'])}}
                        <div class="form-group">
                            <div class="col col-md-3">{!! Form::label('channel_id', 'Канал', ['class' => 'pr-1  form-control-label']) !!}</div>
                            <div class="col-12 col-md-9">{!! Form::text('channel_id', null, ['class' => 'form-control']) !!}</div>
                        </div>
                    {!! Form::button('Добавить', ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                    {!! Form::close()!!}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Список Каналов</strong>
                        </div>
                        <div class="card-body">
                            @if ($channels->isNotEmpty())
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Название</th>
                                        <th scope="col">Бот</th>
                                        <th scope="col">Статус</th>
                                        <th scope="col">Дата добавления</th>
                                        <th scope="col">Управление</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($channels as $item)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{$item->channel_id}}</td>
                                            <td>{{$item->bot->name}}</td>
                                            <td>{{$item->getStatus()}}</td>
                                            <td>{{$item->created_at}}</td>
                                            <td>
                                                @if ($item->bot->id == null)
                                                    <button class="btn btn-primary btn-sm" data-id="{{$item->id}}" title="Привязать бота">
                                                        <span class="ti-wand"></span>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-warning" role="alert">
                                    Вы еще не добавили ниодного канала.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section ('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{asset('js/notify.js')}}"></script>
    <script>
        $('#addChannelForm').submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '{{route("telegram.channel.new")}}',
                method: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    $.notify(response.message, 'success');
                },
                error: function (response) {
                    $.notify(response.responseJSON.errors.channel_id, 'error');
                }
            });

        });
    </script>
@endsection