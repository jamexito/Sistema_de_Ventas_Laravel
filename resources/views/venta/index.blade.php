@extends('principal')
@section('contenido')
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">

                <h2>Listado de Ventas</h2><br/>

                    <a href="venta/create">

                        <button class="btn btn-primary btn-lg" type="button" data-toggle="modal" data-target="#abrirmodal">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Venta
                        </button>

                    </a>

                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::open(array('url'=>'venta','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
                                <div class="input-group">

                                <input type="text" name="buscarTexto" class="form-control" placeholder="Buscar texto" value="{{$buscarTexto}}">
                                    <button type="submit"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            {{Form::close()}}
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr class="bg-primary">

                                <th>Ver Detalle</th>
                                <th>Fecha Venta</th>
                                <th>Numero de Venta</th>
                                <th>Cliente</th>
                                <th>Tipo Identificacion</th>
                                <th>Vendedor</th>
                                <th>Total (S/.)</th>
                                <th>Impuesto</th>
                                <th>Estado</th>
                                <th>Cambiar Estado</th>
                                <th>Descargar Reporte</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventas as $vent)

                                <tr>
                                    <td>

                                        <a href="{{URL::action('VentaController@show',$vent->id)}}">

                                            <button type="button" class="btn btn-warning btn-md">
                                                <i class="fa fa-eye fa-2x"></i>Ver detalle
                                            </button> &nbsp;

                                        </a>

                                    </td>
                                    <td>{{$vent->fecha_venta}}</td>
                                    <td>{{$vent->num_venta}}</td>
                                    <td>{{$vent->cliente}}</td>
                                    <td>{{$vent->tipo_identificacion}}</td>
                                    <td>{{$vent->nombre}}</td>
                                    <td>S/.{{number_format($vent->total,2)}}</td>
                                    <td>{{$vent->impuesto}}</td>

                                    <td>
                                        @if ($vent->estado=="Registrado")

                                            <button type="button" class="btn btn-success btn-md">

                                                <i class="fa fa-check fa-2x"></i> Registrado

                                            </button>

                                        @else

                                            <button type="button" class="btn btn-danger btn-md">

                                                <i class="fa fa-check fa-2x"></i> Anulado

                                            </button>

                                        @endif

                                    </td>

                                    {{-- <td>
                                        <button type="button" class="btn btn-info btn-md" data-id_cliente="{{$cli->id}}" data-nombre="{{$cli->nombre}}" data-tipo_documento="{{$cli->tipo_documento}}" data-num_documento="{{$cli->num_documento}}" data-direccion="{{$cli->direccion}}" data-telefono="{{$cli->telefono}}" data-email="{{$cli->email}}" data-toggle="modal" data-target="#abrirmodalEditar">
                                            <i class="fa fa-edit fa-2x"></i> Editar
                                        </button> &nbsp;
                                    </td> --}}

                                    <td>

                                        @if ($vent->estado=="Registrado")

                                            <button type="button" class="btn btn-danger btn-sm" data-id_venta="{{$vent->id}}" data-toggle="modal" data-target="#cambiarEstadoVenta">
                                                <i class="fa fa-times fa-2x"></i> Anular Venta
                                            </button>

                                        @else

                                            <button type="button" class="btn btn-success btn-sm">
                                                <i class="fa fa-lock fa-2x"></i> Anulado
                                            </button>

                                        @endif

                                    </td>

                                    <td>

                                        <a href="{{url('pdfVenta',$vent->id)}}" target="_blank">

                                                <button type="button" class="btn btn-info btn-sm">
                                                    <i class="fa fa-lock fa-2x"></i> Descargar PDF
                                                </button> &nbsp;

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                    {{$ventas->render()}}

                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal cambiar estado de la cventaompra-->
        <div class="modal fade" id="cambiarEstadoVenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-danger" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cambiar Estado de la Venta</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                    <form action="{{route('venta.destroy','test')}}" method="post" class="form-horizontal">

                            {{method_field('delete')}}
                            {{csrf_field()}}

                            <input type="hidden" id="id_venta" name="id_venta" value="">

                            <p>¿Estás seguro de cambiar el estado?</p>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-x2"></i>Cerrar</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-lock fa-x2"></i>Aceptar</button>
                            </div>

                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
@endsection
