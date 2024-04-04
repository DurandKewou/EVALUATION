@extends('layout/layout-common')

@section('space-work')

    @php
        $time = explode(':', $exam[0]['time']);
    @endphp

    <div class="container">
        <div class="d-flex flex-row mt-5">


            <!-- DEVISE EN FRANCAIS -->
            <div class="text-center" style="margin-bottom:30px; flex:1">

                <div>
                    <h5 class="fw-bold text-uppercase">république du cameroun</h5>
                    <h6><i>Paix - travail - Patrie</i></h6>
                    <h6>- . - . - . -</h6>
                </div>

                <div>
                    <h5 class="fw-bold text-uppercase">université de yaoundé i</h5>
                    <h6 class="fw-bold">Faculté des sciences</h6>
                    <h6><i>Département d'informatique</i></h6>
                    <h6><i>B.P 812 Yaoundé</i></h6>
                </div>

            </div>

            <!-- LOGO UNIVERSITE -->
            <div class="text-center " style="margin-bottom:50px; flex:1">
                <img src="{{ asset('img/logo_universite.png') }}" width="90" alt="" srcset="">
            </div>

            <!-- DEVISE EN ANGLAIS -->
            <div class="text-center" style="margin-bottom:30px; flex:1">

                <div>
                    <h5 class="fw-bold text-uppercase">Republic of Cameroon</h5>
                    <h6><i>Peace - Work - Fatherland</i></h6>
                    <h6>- . - . - . -</h6>
                </div>
                
                <div>
                    <h5 class="fw-bold text-uppercase">University of Yaoundé I</h5>
                    <h6 class="fw-bold">Faculty of Science</h6>
                    <h6><i>Department of Computer Science</i></h6>
                    <h6><i>P.O. Box 812 Yaoundé</i></h6>
                </div>                                    

            </div>
        </div>
        <h4 class="text-center">Subject: {{$exam[0]['subject']}} </h4>
        <h4 class="text-center">{{$exam[0]['exam_name']}} </h4>
        <h5 class="text-right" style="color: black">Student Name: {{Auth::user()->name}}</h5>
        @php
            $qcount = 1;
        @endphp 
        @if ($success == true)

            @if (count($qna)>0)
                <h1 class="text-center time">Top Start:{{$exam[0]['time']}}</h1>
                <form action="{{route('examSubmit')}}" method="POST" id="exam_form" class="mt-5">
                    <input type="hidden" name="exam_id" value="{{$exam[0]['id']}}">
                    @csrf

                    
                    @foreach ($qna as $data)
                        <div>
                            <h5>Q:{{$qcount++}} {{$data['question'][0]['question']}}</h5>
                            <input type="hidden" name="q[]" value="{{$data['question'][0]['id']}}">
                            <input type="hidden" name="ans_{{$qcount-1}}" id="ans_{{$qcount-1}}">
                            @php
                                $acount = 1;
                            @endphp
                            @foreach ($data['question'][0]['answers'] as $answer)
                                <p> 
                                    <br>{{$acount++}}).</b> {{$answer['answer']}}
                                    <input type="radio" name="radio_{{$qcount-1}}" data-id="{{$qcount-1}}" class="select_ans" value="{{$answer['id']}}">
                                </p>
                            @endforeach
                            <br>
                        </div>
                    @endforeach
                    <div class="text-center">
                        <input type="submit" value="Submit" class="btn btn-info">
                    </div>
                </form>
            @else
                <h3 style="color: red" class="text-center">Question and Answers no Available</h3>
            @endif
        @else
            <h3 style="color: red" class="text-center">{{$msg}}</h3>
        @endif
    </div>

    <script>
        $(document).ready(function(){
            $('.select_ans').click(function(){
                var no = $(this).attr('data-id');
                $('#ans_'+no).val($(this).val());
            });

            var time = @json($time);

            $('.time').text(time[0]+ ':' +time[1] +':00 Left time');

            var second = 59;
            var hour = parseInt([0]);
            var minute = parseInt([1]);

            var time = setInterval(() => {
                if (hour==0 && minute==0 && second==0) {
                    setInterval(time);
                    $('#exam_form').submit();
                }
                if (second <= 0) {
                    minute--;
                    second=59;
                }

                if (minute<=0 && hour !=0) {
                    hour--;
                    minute=59;
                    second=59;
                }
                let tempHour = hour.toString().length > 1 ? hour:'0'+hour;
                let tempMinute = minute.toString().length > 1 ? minute:'0'+minute;
                let tempSeconde = second.toString().length > 1 ? second:'0'+second;
                $('.time').text(tempHour+ ':' +tempMinute +':'+tempSeconde +'Left time');

                second--;
            }, 1000);
        });

        function isValid() {
            var result = true;

            var qlength = parseInt("{{$qcount}}")-1;
            $('.error_msg').remove();

            for (let i = 0; i < qlength.length; i++) {
                if ($('#ans_'+i).val() == "") {
                    result = false;
                    $('#ans_'+i).parent().append('<span style="color:red;" class="error_msg">Please select Answer</span>');
                    setTimeout(() => {
                        $('.error_msg').remove();
                    }, 5000);
                }
            }

            return result;
        }
    </script>
@endsection