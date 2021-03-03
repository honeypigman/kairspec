<!--
    Title : Api Layout 
    Date : 2021.02.25
//-->
@extends('layout/header')
@section('content')

  <!-- Apicode Info //-->
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    {{ $result['id'] }} - {{ $result['ename'] }}
    <span class="text-end">
      <button type="button" class="btn btn-primary btn-sm" id="send">SEND</button>
    </span>
  </div>

  <!-- Apicode Form //-->
  <!-- CSRF-TOKEN //-->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <p>
    <form id="form" method="POST">
    @csrf
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link bg-muted active" aria-current="page" href="#">Req</a>
      </li>
    </ul>
    @if(!empty($result['req']))
        <div class="mt-2 row">
          <label class="col-sm-2 col-form-label">URI</label>
          <div class="col-sm-10">
          <input type="text" class="form-control-plaintext text-secondary" name="uri" value="{{ $result['url'] }}" readOnly>
          </div>
        </div>
        <div class="mt-2 row">
          <label class="col-sm-2 col-form-label">Operation</label>
          <div class="col-sm-10">
          <input type="text" class="form-control-plaintext text-secondary" name="operation" value="{{ $result['operation'] }}" readOnly>
          </div>
        </div>
        @foreach( $result['req'] as $name=>$data)
        <div class="mt-2 row">
            <label class="col-sm-2 col-form-label">{{ $name }}</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="{{ strtolower($name) }}" name="data[{{ ($name) }}]" maxlength="{{ $data['len'] }}" value="{{ $data['val'] }}" @if($name=='ServiceKey') readOnly @endif>
            </div>
            <div class="col-sm-7">
                <input type="text" class="form-control-plaintext text-secondary" value="{{ $data['des'] }}" disabled>
            </div>
        </div>
        @endforeach
    @endif
    </form>
  </p>

  <p>
  <!-- <table class="table table-sm table-hover">
    <thead class="table-light">
        <th class="col-md-2">_id</th>
        <th class="col-md-5">reqdate</th>
        <th class="col-md-5">updated</th>
    </thead>
    <tbody id="apiListBody">
        <tr>
            <td colspan="3" align=center class="text-secondary">The data does not exist.</td>
        </tr>
    </tbody>
  </table> -->
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link bg-muted active" aria-current="page" href="#">Res</a>
      </li>
    </ul>
    <div class="mt-2 row">
      <div class="col-sm-12 text-start mt-2 text-center" id="resBody">
        <span class="text-secondary">The data does not exist.</span>
      </div>
    </div>
  </p>

@endsection 