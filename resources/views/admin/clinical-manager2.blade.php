@extends('admin.layouts.app')
@section('title')
Dashboard
@endsection
@section('breadcrumb_1')
Dashboard
@endsection
@section('content')
<div class="row">
    <div class="col-md-2">
        <div class="card left-sidebar py-3 px-3 mt-3">
            <ul class="p-0 list-unstyled m-0">
                <li><a href="#" class="text-dark">Infections</a></li>
                <li><a href="#" class="text-dark">Symptoms</a></li>
            </ul>
            <div class="form-group mt-2">
                <select class="form-control symptoms-selected" name="symptoms">
                    <option value="">Select</option>
                    <option value="all" {{$symptom_ids == 'all' ? 'selected': ''}}>Select All Symptoms</option>
                    @foreach($symptoms_collection as $symptom)
                        <option value="{{$symptom->id}}" {{$symptom_ids == $symptom->id ? 'selected': ''}}>{{$symptom->name}}</option>
                    @endforeach
                </select>
            </div>
            <ul class="p-0 mt-2 list-unstyled m-0">
                <li><a href="#" class="text-dark">Diseases</a></li>
            </ul>
            <div class="form-group mt-2">
                <select class="form-control diseases-selected" name="diseases">
                    <option value="">Select</option>
                    <option value="all" {{$disease_ids == 'all' ? 'selected': ''}}>Select All Diseases</option>
                    @foreach($diseases_collection as $disease)
                        <option value="{{$disease->id}}" {{$disease_ids == $disease->id ? 'selected' : ''}}>{{$disease->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow mt-3">
            <div class="card-body">
                <h3 class="text-center">Symptoms Chart</h3>
                <canvas id="symtomsChart"></canvas>
            </div>
            <div class="card-body">
                <h3 class="text-center">Infection Chart</h3>
                <canvas id="infectionChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="sidebar p-4 bg-white mt-3">
            <d class="d-block mb-3">
                <a
                    href="javascript:void(0)" onclick="filterData('{{route('home',['ranking_by' => request()->ranking_by ?? "symptoms",'date_range' => 'today'])}}')">Today</a>
                |
                <a
                    href="javascript:void(0)" onclick="filterData('{{route('home',['ranking_by' => request()->ranking_by ?? "symptoms",'date_range' => 'yesterday'])}}')">Yesterday</a>
                |
                <a href="javascript:void(0)" onclick="filterData('{{route('home',['ranking_by' => request()->ranking_by ?? "symptoms",'date_range' => 'week'])}}')">7
                    Days</a>
                |
                <a href="javascript:void(0)" onclick="filterData('{{route('home',['ranking_by' => request()->ranking_by ?? "symptoms",'date_range' => 'month'])}}')">30
                    Days</a>
            </d>
            <div class="inner-box">
                <div class="button-group">
                    <div class="alert-box">
                        <button type="button" class="btn btn-primary">
                            Add New
                        </button>
                    </div>
                </div>
                <div class="aro mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="room">
                                Room #
                            </h4>
                            <p>Resident</p>
                        </div>
                        <div class="col-md-6">
                            <p>Organism</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inner-box mt-3 pb-3">
                <h4 class="title pb-2">HCW Infections</h4>
                <form action="">
                    <div class="form-group mb-2">
                        <input type="text" placeholder="HCW Name" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" placeholder="Infection" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" placeholder="Est Return Date" class="form-control">
                    </div>
                    <div class="button-group">
                        <button class="btn btn-primary">Set Alert</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>

        let symptoms = '{{json_encode($symptoms)}}';
        let decodedSymptoms = symptoms.replace(/&quot;/g, '"');
        decodedSymptoms = JSON.parse(decodedSymptoms);
        let SymptomsDateArray = [];
        let dataSets = [];
        $.each(decodedSymptoms, function(key,value){
            $.each(value.dates, function(k,v){
                SymptomsDateArray.push(v);
            });
            let dataSetBody = {
                label: value.symptom_name,
                data: value.counts,
                borderWidth: 1
            }
            dataSets.push(dataSetBody);
        });


        let diagnoses = '{{json_encode($diagnoses)}}';
        let decodedDiagnoses = diagnoses.replace(/&quot;/g, '"');
        decodedDiagnoses = JSON.parse(decodedDiagnoses);
        let DiagnosesDateArray = [];
        let dataSetsDiagnoses = [];
        $.each(decodedDiagnoses, function(key,value){
            $.each(value.dates, function(k,v){
                DiagnosesDateArray.push(v);
            });
            let dataSetBodyDiagnose = {
                label: value.diagnose_name,
                data: value.counts,
                borderWidth: 1
            }
            dataSetsDiagnoses.push(dataSetBodyDiagnose);
        });


        const ctx = document.getElementById('symtomsChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: SymptomsDateArray,
                datasets: dataSets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('infectionChart');

        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: DiagnosesDateArray,
                datasets: dataSetsDiagnoses
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function filterData(route){
            let symptoms = $('.symptoms-selected').find(':selected').val();
            let diseases = $('.diseases-selected').find(':selected').val();
            window.location.href = route+'&symptoms='+symptoms+'&diseases='+diseases;
        }

    </script>
@endsection
