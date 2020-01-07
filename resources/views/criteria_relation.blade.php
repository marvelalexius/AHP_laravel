@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Hubungan prioritas antar kriteria</div>

                <div class="card-body row">
                  @if (count($criterias) == 0)
                    <div class="col-md-12">
                      <h2>Kamu belum ada kriteria 😢</h2>
                      <p>tambahkan kriteria pilihanmu pada menu kriteria</p>
                    </div>
                  @else
                    <div class="col-md-12">
                      <form action="{{ route('criteria_relations.store') }}" method="post">
                        @csrf
                        <div class="form-row">
                          <div class="col">
                            <select id="inputState" class="form-control" name="first_criteria">
                              <option>Pilih Kriteria Pertama</option>
                              @foreach ($criterias as $criteria)
                                <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col"><input type="number" name="weight" min="1" max="9" required placeholder="Hubungan kepentingan" class="form-control"></div>
                          <div class="col">
                            <select id="inputState" class="form-control" name="second_criteria">
                              <option>Pilih Kriteria kedua</option>
                              @foreach ($criterias as $criteria)
                                <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col"><button type="submit" class="btn btn-primary">Submit</button></div>
                        </div>
                      </form>
                    </div>
                      
                    <div class="col-md-12 mt-3">
                      <form action="" method="get">
                        <input type="hidden" name="hitung" value="true">
                        <button type="submit" class="btn btn-lg btn-primary">Hitung AHP</button>
                      </form>
                    </div>
                  @endif
                </div>
            </div>
        </div>
            
        <div class="col-md-12 mt-2">
          <div class="card">
            <div class="card-header">Hubungan Antar Kriteria</div>

            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <th>Kriteria Pertama</th>
                    <th>Skala Prioritas</th>
                    <th>Kriteria Kedua</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (@$criteria_relations as $criteria)
                    <tr>
                      <td>{{ $criteria->first_criteria->name }}</td>
                      <td>{{ $criteria->weight }}</td>
                      <td>{{ $criteria->second_criteria->name }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        @if ($hitung)
          <div class="col-md-12 mt-2">
            <div class="card">
              <div class="card-header">Table Relasi</div>

              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Kategori</th>
                      @foreach ($criterias as $criteria)
                        <th>{{ $criteria->name }}</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($criterias as $criteria)
                      <tr>
                        <td>{{ $criteria->name }}</td>
                        @foreach ($criteria_table[$criteria->name] as $table)
                          <td>{{ $table }}</td>
                        @endforeach
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <td>Jumlah</td>
                      @foreach ($criteria_table['Jumlah'] as $item)
                        <td>{{ $item }}</td>
                      @endforeach
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

          <div class="col-md-12 mt-2">
            <div class="card">
              <div class="card-header">Table Eigen Kriteria</div>

              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Kategori</th>
                      @foreach ($criterias as $criteria)
                        <th>{{ $criteria->name }}</th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($criterias as $criteria)
                      <tr>
                        <td>{{ $criteria->name }}</td>
                        @foreach ($criteria_eigen[$criteria->name] as $table)
                          <td>{{ $table }}</td>
                        @endforeach
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <td>Jumlah</td>
                      @foreach ($criteria_eigen['Jumlah'] as $item)
                        <td>{{ $item }}</td>
                      @endforeach
                    </tr>
                    <tr>
                      <td>Eigen</td>
                      @foreach ($avg_eigen as $item)
                        <td>{{ $item }}</td>
                      @endforeach
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        @endif
    </div>
</div>
@endsection
