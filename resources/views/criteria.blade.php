@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Kriteria</div>

                <div class="card-body">
                    <form action="{{ route('criterias.store') }}" method="post">
                      @csrf
                      <div class="form-row">
                        <div class="col"><label for="inputEmail4">Kriteria</label></div>
                        <div class="col"><input type="text" name="criteria" id="" required class="form-control" placeholder="masukkan nama kriteria"></div>
                        <div class="col"><button type="submit" class="btn btn-primary">Submit</button></div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-2">
          <div class="card">
            <div class="card-header">Kriteria</div>

            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (@$criterias as $criteria)
                    <tr>
                      <td>{{ $criteria->name }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
