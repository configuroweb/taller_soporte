<style>
    #cover-img{
        object-fit:cover;
        object-position:center center;
        width: 100%;
        height: 100%;
    }
</style>
<h1>Bienvenid@ al <?php echo $_settings->info('name') ?> - Admin Panel</h1>
<hr class="border-info">
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-info elevation-1"><i class="fas fa-th-list"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Servicios</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `service_list` ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total Clientes</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `client_list` ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-tools"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Reparaciones Pendientes</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `repair_list` where status = 0 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-tools"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Reparaciones Aprobadas</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `repair_list` where status = 1 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-info elevation-1"><i class="fas fa-tools"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Reparaciones en Progreso</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `repair_list` where status = 2 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-tools"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Reparaciones Validadas</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `repair_list` where status = 3 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-tools"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Reparaciones Finalizadas</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `repair_list` where status =4 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-tools"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Reparaciones Canceladas</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `repair_list` where status =5 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<hr>
<div class="w-100" style="height:50vh">
    <img src="<?= validate_image($_settings->info('cover')) ?>" alt="System Cover Image" id="cover-img" class="img-fluid h-100 bg-gradient-dark">
</div>