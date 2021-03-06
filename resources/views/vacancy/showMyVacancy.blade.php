@extends('app')
<link href="{{ asset('/css/myVacancyShow.css') }}" rel="stylesheet">
@section('content')
    {!!Form::open(['route' => 'head', 'method' => 'post', 'name' => 'filthForm', 'id' => 'aform'])!!}
    <input type = "hidden" name = "filterName" id = "filterName"/>
    <input type = "hidden" name = "filterValue" id = "filterValue"/>
    {!!Form::close()!!}

    {!! Form::file('fileImg', array( 'id'=>'fileImg', 'style'=>'display:none', 'accept'=>'.jpg, .jpeg, .gif, .png, .svg')) !!}
    <input type="hidden" name="fcoords" id="coords" class="coords" value="" data-id="{{$vacancy->company_id}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="panel" id="vrBlock">
    <div class="row">
        <div class="col-xs-12 col-md-2">
            <div class="panel panel-orange" id="vimg">
                @if(File::exists(public_path('image/company/' . $vacancy->Company->users_id .'/'. $vacancy->Company->image)) and $vacancy->Company->image != '')
                    {!! Html::image('image/company/' . $vacancy->Company->users_id .'/'. $vacancy->Company->image, 'logo', ['id' => 'vacImg', 'width' => '100%', 'height' => '100%']) !!}
                @else
                    <h3 style="text-align: center; color: #f48952; margin-top: 40px">логотип вiдсутнiй</h3>
                @endif
            </div>
            {{--<div class="change-img-myVacancy">--}}
                {{--<div class="orange-link-myVacancy"  id="changeImage">--}}
                    {{--<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>--}}
                    {{--<span>Змiнити лого</span>--}}
                {{--</div>--}}
                {{--<br>--}}
                {{--@if(File::exists(public_path('image/company/' . $vacancy->Company->users_id .'/'. $vacancy->Company->image)) and $vacancy->Company->image != '')--}}
                    {{--<span class="orange-link-myVacancy" id="deleteImage">--}}
                            {{--<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>--}}
                            {{--<span>Видалити лого</span>--}}
                    {{--</span>--}}
                {{--@endif--}}
            {{--</div>--}}
        </div>
        <div class="col-xs-12 col-md-10">
            <div>
                <p class="position-myVacancy">
                    <a class="orangColor-myVacancy-name" href="javascript:submit('selectSpecialisation', '{{$vacancy->position}}')">{!!$vacancy->position!!}</a>
                    <br>
                </p>
                <p class="price-myVacancy">
                    <span>{{$vacancy->salary}} - {{$vacancy->salary_max}} {{$vacancy->Currency()[0]['currency']}}</span>
                </p>
            </div>
            <div>
                <p class="position-myVacancy">  <a class="orangColor-myVacancy" href="javascript:submit('selectIndustry', {{$vacancy->Industry()->id}})">{{$industry->name}}</a></p>
                {{--<p class="company-name-myVacancy">{{auth()->user()->name}}</p>--}}
            </div>
            <div>
                <p class="description-footer-myVacancy">{!! strip_tags($vacancy->description, '<em><a><s><p><span><b><ul><ol><li><strong><h1><h2><h3><h4><h5><blockquote><body><table><tr><td>') !!}</p>
            </div>
            <div>
                <a target="_blank" class="nameCompany-myVacancy" href="/company/{{$company->id}}">{{$company->company_name}}</a>
            </div>
            <div>
                <p class="cityTime-myVacancy">
                    @foreach($cities->get() as $city)
                        <a class="city-myVacancy" href="javascript:submit('selectCity' {{$city->id}})">{{$city->name}} </a>
                    @endforeach
                    <span id="yellowCircle-myVacancy">&#183;</span> {{ date('j m Y', strtotime($vacancy->updated_at))}}
                </p>
            </div>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <div class="col-xs-12 col-md-3">
                <a class="orangColor-myVacancy" href="{{$vacancy->id}}/destroy" onclick="return ConfirmDelete();">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    <span>видалити</span>
                </a>
            </div>
            <div class="col-xs-12 col-md-3">
                <a class="orangColor-myVacancy" href="{{$vacancy->id}}/edit">
                    {!! Html::image('image/edit.png', 'del') !!}
                    <span>редагувати</span>
                </a>
            </div>
            <div class="col-xs-12 col-md-3">
                <a class="orangColor-myVacancy" href="#">
                    {!! Html::image('image/podiumOrenge.png', 'del') !!}
                    <span> розмістити в ТОПі</span>
                </a>
            </div>
            <div class="col-xs-12 col-md-3">
                <a class="orangColor-myVacancy" href="#">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <span>оновити дату вакансіїї</span>
                </a>
            </div>
        </div>
    </div>

    <div id="changeImageBox" class="modal fade">
        @include('newDesign.cropModal')
    </div>

    {!!Html::script('js/crop.js')!!}
    <script>
        $(document).ready(function () {
            $('#changeImage').on('click', function () {
                $('#fileImg').click();
            });

            $('#fileImg').on('change', function (e) {
                $('#changeImageBox').modal({
                    show: true,
                    backdrop: 'static'
                });
                crop(e, 'img-src', '#crop', '#changeImageBox');
            });

            $('#changeImageBox').on('hidden.bs.modal', function () {
                if($('#coords').val()){
                    var $input = $("#fileImg");
                    var fd = new FormData;
                    fd.append('fileImg', $input.prop('files')[0]);
                    fd.append('coords', $('.coords').val());
                    fd.append('id', $('.coords').attr('data-id'));
                    $.ajax({
                        url: '{{ route('upimg') }}',
                        data: fd,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function (data) {
                            $('#vimg img').attr('src', window.location.origin + '/' + data);
                        }
                    });
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });

            $('#deleteImage').on('click', function () {
                if(ConfirmDelete()){
                    $.ajax({
                        url: '{{ route('deleteimg') }}',
                        data: {'id' : $('.coords').attr('data-id')},
                        type: 'POST',
                        success: function (data) {
                            $('#vimg img').attr('src', window.location.origin + '/' + data);
                        }
                    })
                }
            })
        });

        function ConfirmDelete()
        {
            confirm("Ви дійсно хочете видалити вакансію?");
        }
    </script>

@stop