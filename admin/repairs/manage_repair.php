<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `repair_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
    
    $service_list = $conn->query("SELECT rs.*,s.service FROM `repair_services` rs inner join service_list s on rs.service_id = s.id where rs.repair_id = '{$id}' ")->fetch_all(MYSQLI_ASSOC);
    $material_list = $conn->query("SELECT * FROM `repair_materials` where repair_id = '{$id}' ")->fetch_all(MYSQLI_ASSOC);
        
    }
}
?>
<div class="content py-3">
    <div class="container-fluid">
        <div class="card card-outline card-info rounded-0 shadow">
            <div class="card-header rounded-0">
                <h4 class="card-title"><?= isset($code) ? "Actualizar detalles de Reparación" : "Agregar Nueva Reparación" ?></h4>
            </div>
            <div class="card-body rounded-0">
                <div class="container-fluid">
                    <form action="" id="entry-form">
                        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                        <fieldset>
                            <div class="row">
                                <div class="form-group col-md-8">
                                   <select name="client_id" id="client_id" class="form-control form-control-sm form-control-border select2" data-placeholder="Selecciona Cliente Aquí">
                                       <option value="" disabled <?= !isset($client_id) ? "selected" : "" ?>></option>
                                       <?php 
                                       $clients = $conn->query("SELECT *,CONCAT(lastname,', ',firstname,' ', middlename) as `name` FROM `client_list` order by CONCAT(lastname,', ',firstname,' ', middlename) asc");
                                       while($row = $clients->fetch_assoc()):
                                        if($row['delete_flag'] == 1 && (!isset($client_id) || (isset($client_id) && $client_id != $row['id'])))
                                            continue;
                                       ?>
                                       <option value="<?= $row['id'] ?>" <?= isset($client_id) && $client_id == $row['id'] ? "selected" : "" ?>><?= $row['name'] ?></option>
                                       <?php endwhile; ?>
                                   </select>
                                    <small class="text-muted px-4">Nombre Cliente</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend class="text-muted border-bottom">Servicios</legend>
                                        <div class="row">
                                            <div class="form-group col-md-9">
                                                <select  id="service" class="form-control form-control-sm form-control-border select2" data-placeholder="Selecciona Servicio Aquí">
                                            <option value="" disabled selected></option>
                                                <?php 
                                                $service_arr = [];
                                                $services = $conn->query("SELECT * FROM `service_list`  order by `service` asc");
                                                while($row = $services->fetch_assoc()):
                                                    $service_arr[$row['id']] = $row;
                                                    if($row['delete_flag'] == 1)
                                                        continue;
                                                ?>
                                                <option value="<?= $row['id'] ?>" <?= isset($service_id) && $service_id == $row['id'] ? "selected" : "" ?>><?= $row['service'] ?></option>
                                                <?php endwhile; ?>
                                                </select>
                                                <small class="text-muted px-4">Servicio</small>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" id="cost" class="form-control form-control-sm form-control-border text-right" value="0.00" disabled>
                                                <small class="text-muted px-4">Pago</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <button class="btn btn-flat btn-primary btn-sm" type="button" id="add_service"><i class="fa fa-plus"></i> Agregar a la Lista</button>
                                            </div>
                                        </div>
                                        <table class="table table-stripped table-bordered" data-placeholder='true' id="service_list">
                                            <colgroup>
                                                <col width="10%">
                                                <col width="65%">
                                                <col width="25%">
                                            </colgroup>
                                            <thead>
                                                <tr class='bg-gradient-dark text-light'>
                                                    <th class="text-center py-1"></th>
                                                    <th class="text-center py-1">Servicio</th>
                                                    <th class="text-center py-1">Pago</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </fieldset>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-md-12">
                                    <input type="hidden" name="total_amount" value="0">
                                    <h3><b>Monto Total a Pagar: <span id="total_amount" class="pl-3">0.00</span></b></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-8 col-lg-7">
                                <small class="text-muted px-4">Observaciones</small>
                                    <textarea name="remarks" id="remarks" rows="3" class="form-control form-control-sm rounded-0"><?= isset($remarks) ? $remarks : "" ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <select name="payment_status" id="payment_status" class="form-control form-control-sm form-control-border" required>
                                        <option value="0" <?= isset($payment_status) && $payment_status == 0 ? "selected" : "" ?>>Sin-Pagar</option>
                                        <option value="1" <?= isset($payment_status) && $payment_status == 1 ? "selected" : "" ?>>Pagado</option>
                                    </select>
                                    <small class="text-muted px-4">Estado Pago</small>
                                </div>
                                <div class="form-group col-md-4">
                                    <select name="status" id="status" class="form-control form-control-sm form-control-border" required>
                                        <option value="0" <?= isset($status) && $status == 0 ? "selected" : "" ?>>Pendiente</option>
                                        <option value="1" <?= isset($status) && $status == 1 ? "selected" : "" ?>>Aprobado</option>
                                        <option value="2" <?= isset($status) && $status == 2 ? "selected" : "" ?>>En-progreso</option>
                                        <option value="3" <?= isset($status) && $status == 3 ? "selected" : "" ?>>Validación</option>
                                        <option value="4" <?= isset($status) && $status == 4 ? "selected" : "" ?>>Finalizado</option>
                                        <option value="5" <?= isset($status) && $status == 5 ? "selected" : "" ?>>Cancelado</option>
                                    </select>
                                    <small class="text-muted px-4">Estado</small>
                                </div>
                            </div>
                        </fieldset>
                        
                        <hr class="bg-navy">
                        <center>
                            <button class="btn btn-sm bg-primary btn-flat mx-2 col-3">Guardar</button>
                            <?php if(isset($id)): ?>
                                <a class="btn btn-sm btn-light border btn-flat mx-2 col-3" href="./?page=repairs/view_details&id=<?= $id ?>">Cancelar</a>
                            <?php else: ?>
                                <a class="btn btn-sm btn-light border btn-flat mx-2 col-3" href="./?page=repairs">Cancelar</a>
                            <?php endif; ?>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var service_list  = $.parseJSON('<?= json_encode(isset($service_list) ? $service_list : []) ?>')
    var material_list  = $.parseJSON('<?= json_encode(isset($material_list) ? $material_list : []) ?>')
    var services = $.parseJSON('<?= json_encode($service_arr) ?>')
    function submit_entry(){
        var _this = $("#entry-form")
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_repair",
				data: new FormData($("#entry-form")[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("Ocurrió un error",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        location.href="./?page=repairs/view_details&id="+resp.id;
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("Se produjo un error debido a un motivo desconocido.")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    $('html, body').animate({scrollTop:0},'fast')
                    end_loader();
                }
            })
    }
    function calc_total(){
        var total = 0;
        $('#service_list tbody tr').each(function(){
            cost = $(this).find('td:nth-child(3)').text().trim()
            cost = cost.replace(/\,/gi,'')
            total += parseFloat(cost)
        })
        $('#material_list tbody tr').each(function(){
            cost = $(this).find('td:nth-child(3)').text().trim()
            cost = cost.replace(/\,/gi,'')
            total += parseFloat(cost)
        })
        $('#total_amount').text(parseFloat(total).toLocaleString('en-US',{style:"decimal",maximumFractionDigits:2, minimumFractionDigits:2}))
        $('input[name="total_amount"]').val(parseFloat(total))
    }
    function add_service(id,fee=''){
        if(!!services[id]){
            fee = fee == '' ? services[id].cost : fee;
            var tr = $('<tr>')
            tr.append('<td class="px-2 py-1 text-center"><input type="hidden" name="service_id[]" value="'+id+'"/><input type="hidden" name="fee[]" value="'+fee+'"/> <button class="btn btn-remove btn-rounded btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>')
            tr.attr('data-id',id)
            tr.append("<td class='px-2 py-1'>"+services[id].service+"</td>")
            tr.append("<td class='px-2 py-1 text-right'>"+(parseFloat(fee).toLocaleString('en-US',{style:'decimal', maximumFractionFigits:2, minimumFractionDigits:2}))+"</td>")
            $('#service_list tbody').append(tr)
            tr.find('.btn-remove').click(function(){
                tr.remove();
            })
            $('#service').val('').trigger('change')
            $('#cost').val('0.00')
            calc_total()
        }
    }
    function add_material(material,cost){
        var tr = $('<tr>')
        tr.append('<td class="px-2 py-1 text-center"><input type="hidden" name="material[]" value="'+material+'"/><input type="hidden" name="mcost[]" value="'+cost+'"/> <button class="btn btn-remove btn-rounded btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>')
        tr.append("<td class='px-2 py-1'>"+material+"</td>")
        tr.append("<td class='px-2 py-1 text-right'>"+(parseFloat(cost).toLocaleString('en-US',{style:'decimal', maximumFractionFigits:2, minimumFractionDigits:2}))+"</td>")
        $('#material_list tbody').append(tr)
        tr.find('.btn-remove').click(function(){
            tr.remove();
        })
        $('#material').val('')
        $('#mcost').val('0.00')
        $('#material').focus()
        calc_total()
    }
    $(function(){
        if(Object.keys(service_list).length > 0){
            Object.keys(service_list).map(k=>{
                add_service(service_list[k].service_id,service_list[k].fee)
            })
        }
        if(Object.keys(material_list).length > 0){
            Object.keys(material_list).map(k=>{
                add_material(material_list[k].material,material_list[k].cost)
            })
        }
        $('#service').change(function(){
            var id = $(this).val()
            if(!!services[id]){
                $('#cost').val(parseFloat(services[id].cost).toLocaleString('en-US',{style:'decimal', maximumFractionFigits:2, minimumFractionDigits:2}));
            }
        })
        $('#add_service').click(function(){
            var id = $('#service').val()
            if($('#service_list tbody tr[data-id="'+id+'"]').length > 0){
                alert_toast(" Servicio Listado Actualmente",'warning')
                return false;
            }
            add_service(id)
            
        })
        $('#add_material').click(function(){
            var material = $('#material').val()
            var cost = $('#mcost').val()
            add_material(material,cost)
        })
        $('.select2').each(function(){
            var _this = $(this)
            _this.select2({
                placeholder:_this.attr('data-placeholder') || 'Selecciona aquí',
                width:'100%'
            })
        })
        $('#entry-form').submit(function(e){
            e.preventDefault()
            _conf("Asegúrese de haber revisado el formulario antes de continuar guardando los detalles de la entrada.","submit_entry",[])
            
        })
    })
</script>