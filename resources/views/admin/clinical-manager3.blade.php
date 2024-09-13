@extends('admin.layouts.app')
@section('title')
Dashboard
@endsection
@section('breadcrumb_1')
Dashboard
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mt-3">
            <div class="card-body">
                <div class="row justify-content-end">
                    <div class="col-md-7">
                        <div class="topbar d-flex align-items-center justify-content-between">
                            <h2>Reporting</h2>
                            <div class="button-group">
                                <button class="btn btn-primary">Download as PDF</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-report mt-3">
                    <div class="heading">
                        <h3>HAI's</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Case #</th>
                                    <th>Room #</th>
                                    <th>Name</th>
                                    <th>Infection</th>
                                    <th>Date Assessed</th>
                                    <th>Date Confirmed</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#12</td>
                                    <td>W212</td>
                                    <td>Parker, Benjamin</td>
                                    <td>LRTI</td>
                                    <td>Jan 30 2023</td>
                                    <td>Jan 31 2023</td>
                                </tr>
                                <tr>
                                    <td>#13</td>
                                    <td>E111</td>
                                    <td>Mustang, Sally</td>
                                    <td>UTI</td>
                                    <td>Jan 30 2023</td>
                                    <td>Jan 31 2023</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-report mt-3">
                            <div class="heading d-flex align-items-center mb-3">
                            <h3>Total HAI's for</h3>
                            <select class="form-control">
                                <option>January</option>
                                <option>Feburary</option>
                                <option>March</option>
                                <option>April</option>
                                <option>May</option>
                                <option>June</option>
                                <option>July</option>
                                <option>August</option>
                                <option>September</option>
                                <option>October</option>
                                <option>November</option>
                                <option>December</option>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>Infection Name</th>
                                    <th>Total</th>
                                    <th>% Change from Month</th>
                                    <th>Per 1,000 Bed Night</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Lower RTI</td>
                                    <td>7</td>
                                    <td>+17.1%</td>
                                    <td>1.125</td>
                                </tr>
                                <tr>
                                    <td>UTI</td>
                                    <td>12</td>
                                    <td>+4.2%</td>
                                    <td>0.574</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><b>Total</b></td>
                                    <td><b>19</b></td>
                                    <td><b>+12.9%</b></td>
                                    <td><b>0.849</b></td>
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card hai-details p-3" style="margin-top:5rem;">
                            <p class="text-center">Number of infections <br/> + <br/>Number of occupied bed days <u>for the period</u> x 1000<br/> = Rate of infection per 1000 resident bed days</p>
                            <ul class="p-0 m-0 list-unstyled d-flex flex-wrap">
                                <li class="pb-2 me-2"><b>C. Diff <span class="count">0</span></b></li>
                                <li class="pb-2 me-2"><b>Staff <span class="count">0</span></b></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
