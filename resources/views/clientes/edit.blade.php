@extends('home')

@section('title','Editar Clientes')

@push('css')

@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar Clientes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}">Clientes</a></li>
            <li class="breadcrumb-item active">Editar Clientes</li>
        </ol>

        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('clientes.update', ['cliente' => $cliente]) }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="row g-3">

                    <!-- Tipo de persona -->
                    <div class="col-md-6">
                        <label for="tipo_persona" class="form-label">Tipo de Cliente <span class="fw-bold">{{ strtoupper($cliente->persona->tipo_persona) }}</span></label>
                    </div>

                    <!-- Razón Social -->
                    <div class="col-md-12 mb-2" id="box-razon-social">
                        @if ($cliente->persona->tipo_persona == 'natural')
                            <label id="label-natural" for="razon_social" class="form-label">Nombre y Apellido</label>
                        @else
                            <label id="label-juridica" for="razon_social" class="form-label">Nombre de la Empresa</label>
                        @endif
                        
                        

                        <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{ old('razon_socual',$cliente->persona->razon_social) }}">

                        @error('razon_socual')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div class="col-md-12 mb-2">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion',$cliente->persona->direccion) }}">
                        @error('direccion')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>

                    <!-- Documento -->
                    <div class="col-md-6">
                        <label for="documento_id" class="form-label">Tipo de persona</label>
                        <select class="form-select" name="documento_id" id="documento_id">
                            @foreach ($documentos as $item)
                            @if ($cliente->persona->documento_id == $item->id)
                                <option selected value="{{ $item->id }}" {{ old('documento_id') == $item->id ? 'selected' : '' }}>{{ $item->tipo_documento }}</option>
                            @else
                                <option value="{{ $item->id }}" {{ old('documento_id') == $item->id ? 'selected' : '' }}>{{ $item->tipo_documento }}</option>
                            @endif
                            @endforeach
                        </select>
                        @error('documento_id')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>

                    <!-- Numeo de Documento -->
                    <div class="col-md-6 mb-2">
                        <label for="numero_documento" class="form-label">Numero de Documento</label>
                        <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{ old('numero_documento',$cliente->persona->numero_documento) }}">
                        @error('numero_documento')
                            <small class="text-danger">{{ '*'.$message }}</small>
                        @enderror
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>
@endsection

@push('js')

@endpush