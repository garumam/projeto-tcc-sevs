@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">Lista de usuarios </h4>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="noborder" scope="col">#</th>
                        <th class="noborder" scope="col">First</th>
                        <th class="noborder" scope="col">Last</th>
                        <th class="noborder" scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>
                            <button class="btn btn-warning mb-1">Edit</button>
                            <button class="btn btn-danger mb-1">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>
                            <button class="btn btn-warning mb-1">Edit</button>
                            <button class="btn btn-danger mb-1">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry the Bird</td>
                        <td>Larry the Bird</td>
                        <td>
                            <button class="btn btn-warning mb-1">Edit</button>
                            <button class="btn btn-danger mb-1">Delete</button>
                        </td>
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>

@endsection