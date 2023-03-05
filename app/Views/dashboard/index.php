<?= $this->include('header') ?>
<div class="content-wrapper">
    <section class="content mx-2">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Karyawan</span>
                                <span class="info-box-number">
                                    <?= karyawan(); ?>
                                </span>
                            </div>

                        </div>

                    </div>

                    <!-- <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Likes</span>
                                <span class="info-box-number">41,410</span>
                            </div>

                        </div>

                    </div>


                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Sales</span>
                                <span class="info-box-number">760</span>
                            </div>

                        </div>

                    </div> -->

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Keuntungan</span>
                                <span class="info-box-number">Rp <?= nf(keuntungan()); ?>,00</span>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Grafik Perbandingan</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="grafik" height="100"></canvas>
                                </div>
                                <div>
                                    <canvas id="myChart"></canvas>
                                </div>
                                <form role="form" action="<?= base_url(); ?>/laporan/grafik" method="post" enctype="multipart/form-data">

                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<script src="<?= base_url(); ?>/theme/admin/assets/plugins/chart.js/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/1.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-XulchVN83YTvsOaBGjLeApZuasKd8F4ZZ28/aMHevKjzrrjG0lor+T4VU248fWYMNki3Eimk+uwdlQS+uZmu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 1900000, 3, 5, 2, 3],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script> -->
<?php if (empty($grafik)) { ?>
    <?php foreach ($bulan as $key => $d) {
        $periode[] = label_grafik($d['periode']);
        $blibli[] = 0;
        $shopee[] = 0;
        $tokped[] = 0;
    } ?>
    <script>
        var ctx = document.getElementById('grafik').getContext('2d');
        var grafik = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($periode) ?>,
                datasets: [{
                        label: 'BliBli',
                        backgroundColor: 'rgba(0,143,210, 0.9)',
                        borderColor: 'rgba(0,143,210,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(0,143,210, 1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(0,143,210, 1)',
                        data: <?php echo json_encode($blibli) ?>
                    },
                    {
                        label: 'Shopee',
                        backgroundColor: 'rgba(239,66,46, 1)',
                        borderColor: 'rgba(239,66,46, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(239,66,46, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: <?php echo json_encode($shopee) ?>
                    },
                    {
                        label: 'Tokopedia',
                        backgroundColor: '#00AA5B',
                        borderColor: 'rgba(64,175,71, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(64,175,71, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: <?php echo json_encode($tokped) ?>
                    },
                ]
            },
            options: {
                scaleShowLabels: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                <?php $dat = date_create("2022-12-01") ?>
                title: {
                    display: true,
                    text: ''
                }

            }
        });
    </script>
<?php } ?>
<?php if (!empty($grafik)) { ?>
    <?php foreach ($grafik as $key => $d) {
        $periode[] = label_grafik($d['periode']);
        $blibli[] = $d['blibli'];
        $shopee[] = $d['shopee'];
        $tokped[] = $d['tokped'];
    } ?>
    <script>
        var ctx = document.getElementById('grafik').getContext('2d');
        var grafik = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($periode) ?>,
                datasets: [{
                        label: 'BliBli',
                        backgroundColor: 'rgba(0,143,210, 1)',
                        borderColor: 'rgba(0,143,210,0.8)',
                        pointRadius: false,
                        pointColor: '#0095da',
                        pointStrokeColor: 'rgba(0,143,210, 1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(0,143,210, 1)',
                        data: <?php echo json_encode($blibli) ?>
                    },
                    {
                        label: 'Shopee',
                        backgroundColor: 'rgba(239,66,46, 1)',
                        borderColor: 'rgba(239,66,46, 1)',
                        pointRadius: false,
                        pointColor: '#f84a2f',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: <?php echo json_encode($shopee) ?>
                    },
                    {
                        label: 'Tokopedia',
                        backgroundColor: 'rgba(64,175,71, 1)',
                        borderColor: 'rgba(64,175,71, 1)',
                        pointRadius: false,
                        pointColor: '#6D7588',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: <?php echo json_encode($tokped) ?>
                    },
                ]
            },
            options: {
                scaleShowLabels: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                <?php $dat = date_create("2022-12-01") ?>
                title: {
                    display: true,
                    text: ''
                }

            }
        });
    </script>
<?php } ?>
<?= $this->include('footer') ?>