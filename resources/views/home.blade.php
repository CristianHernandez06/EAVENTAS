@extends('layouts.theme.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bienvenido al Sistema de Control de Ventas TecnoAka') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Usted ha iniciado sesion Correctamente!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
