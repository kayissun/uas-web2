<?php $this->load->view('templates/header'); ?>
<?php $this->load->view('templates/sidebar'); ?>
<?php $this->load->view('templates/navbar'); ?>

<style>
    :root {
        --ink: #14213D;
        --ink-soft: #1F3A5F;
        --brass: #C9A227;
        --brass-soft: #E4C766;
        --paper: #F7F5F0;
        --text-dark: #23272F;
        --text-muted: #6B7280;
        --border: #E8E6E1;
        --success: #10B981;
        --warning: #F59E0B;
        --info: #3B82F6;
        --danger: #EF4444;
    }

    .stat-card {
        border: 1px solid var(--border);
        border-radius: .9rem;
        overflow: hidden;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(20,33,61,.12); }

    .stat-card-accent {
        height: .28rem;
        background: var(--ink);
    }

    .stat-card-accent.success { background: var(--success); }
    .stat-card-accent.warning { background: var(--warning); }
    .stat-card-accent.info { background: var(--info); }
    .stat-card-accent.danger { background: var(--danger); }

    .stat-card-body { padding: 1.5rem; }

    .stat-label { font-size: .85rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .03em; margin-bottom: .5rem; }

    .stat-value { font-size: 2.2rem; font-weight: 700; color: var(--ink); font-family: 'Poppins', serif; }

    .chart-card { border: 1px solid var(--border); border-radius: .9rem; }

    .chart-title { font-size: 1.05rem; font-weight: 600; color: var(--text-dark); margin-bottom: 1.5rem; }

    .chart-container { position: relative; height: 300px; }

    .status-box { padding: 1.2rem; background: var(--paper); border-radius: .6rem; margin-bottom: .75rem; }

    .status-label { font-size: .8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .03em; margin-bottom: .25rem; }

    .status-value { font-size: 1.4rem; font-weight: 700; color: var(--ink); }
</style>

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="page-title">Dashboard</h1>
        <p style="color: var(--text-muted); font-size: .95rem;">Pantau ringkasan kamar dan reservasi hotel Anda</p>
    </div>

    <!-- Stat Cards -->
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="stat-card-accent"></div>
                <div class="stat-card-body">
                    <div class="stat-label"><i class="fas fa-door-open me-1" style="color: var(--brass);"></i>Total Kamar</div>
                    <div class="stat-value"><?= $total_rooms ?></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="stat-card-accent success"></div>
                <div class="stat-card-body">
                    <div class="stat-label"><i class="fas fa-check-circle me-1" style="color: var(--success);"></i>Tersedia</div>
                    <div class="stat-value"><?= $available_rooms ?></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="stat-card-accent info"></div>
                <div class="stat-card-body">
                    <div class="stat-label"><i class="fas fa-bed me-1" style="color: var(--info);"></i>Sedang Dipesan</div>
                    <div class="stat-value"><?= $reserved_rooms ?></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card h-100">
                <div class="stat-card-accent danger"></div>
                <div class="stat-card-body">
                    <div class="stat-label"><i class="fas fa-x me-1" style="color: var(--danger);"></i>Dibatalkan</div>
                    <div class="stat-value"><?= $cancelled_reservations ?></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts & Status -->
    <div class="row g-4">

        <div class="col-xl-8">
            <div class="card chart-card h-100">
                <div class="card-body">
                    <h5 class="chart-title"><i class="fas fa-chart-doughnut me-2" style="color: var(--brass);"></i>Statistik Reservasi</h5>
                    <div class="chart-container">
                        <canvas id="reservasiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card chart-card h-100">
                <div class="card-body">
                    <h5 class="chart-title"><i class="fas fa-info-circle me-2" style="color: var(--brass);"></i>Status Terkini</h5>
                    
                    <div class="status-box">
                        <div class="status-label"><i class="fas fa-door-open me-1" style="color: var(--info);"></i>Check In</div>
                        <div class="status-value"><?= $checkin_reservations ?></div>
                    </div>

                    <div class="status-box">
                        <div class="status-label"><i class="fas fa-sign-out-alt me-1" style="color: var(--success);"></i>Check Out</div>
                        <div class="status-value"><?= $checkout_reservations ?></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/scripts'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
var ctx = document.getElementById('reservasiChart');
if(ctx){
    var labels = [
        <?php foreach($chart_data as $item): ?>
            '<?= ucfirst(str_replace('_', ' ', $item->status)) ?>',
        <?php endforeach; ?>
    ];
    var data = [
        <?php foreach($chart_data as $item): ?>
            <?= $item->total ?>,
        <?php endforeach; ?>
    ];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#14213D', '#10B981', '#3B82F6', '#EF4444'],
                borderColor: '#FFFFFF',
                borderWidth: 2,
                hoverBorderColor: 'rgba(234, 236, 244, 1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: "'Inter', sans-serif", size: 13 },
                        padding: 15,
                        boxWidth: 12,
                        color: '#6B7280'
                    }
                }
            },
            cutout: '65%'
        }
    });
}
</script>