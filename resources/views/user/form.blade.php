<div class="form-group row">
    <label class="col-md-3 form-control-label" for="nombre">Nombre</label>
    <div class="col-md-9">
        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el Nombre" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">

    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="documento">Documento</label>

    <div class="col-md-9">

        <select class="form-control" name="tipo_documento" id="tipo_documento">

            <option value="0" disabled>Seleccione</option>
            <option value="DNI">DNI</option>
            <option value="RUC">RUC</option>
            
        </select>

    </div>

</div>


<div class="form-group row">
    <label class="col-md-3 form-control-label" for="num_documento">Número documento</label>
    <div class="col-md-9">
        <input type="text" id="num_documento" name="num_documento" class="form-control" placeholder="Ingrese el número documento" pattern="[0-9]{0,15}">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="direccion">Dirección</label>
    <div class="col-md-9">
        <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Ingrese la dirección" pattern="^[a-zA-Z0-9_áéíóúñ°\s.]{0,200}$">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="telefono">Telefono</label>
    <div class="col-md-9">

        <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Ingrese el telefono" pattern="[0-9]{0,15}">

    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="telefono">Correo</label>
    <div class="col-md-9">

        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el correo">

    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="usuario">Usuario</label>
    <div class="col-md-9">

        <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Ingrese el usuario" pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">

    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="password">Password</label>
    <div class="col-md-9">

        <input type="password" id="password" name="password" class="form-control" placeholder="Ingrese el password" required>

    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="rol">Rol</label>

    <div class="col-md-9">

        <select class="form-control" name="id_rol" id="id_rol">

        <option value="0" disabled>Seleccione</option>

        @foreach($roles as $rol)

           <option value="{{$rol->id}}">{{$rol->nombre}}</option>

        @endforeach

        </select>

    </div>

</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="imagen">Imagen</label>
    <div class="col-md-9">

        <input type="file" id="imagen1" name="imagen1" class="form-control">

    </div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
<button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>

</div>
