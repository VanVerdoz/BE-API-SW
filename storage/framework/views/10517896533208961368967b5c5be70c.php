<?php $__env->startSection('title', 'Detail Permintaan – ' . ($raider->nama_lengkap ?? $raider->username) . ' (' . ($cabang->nama_cabang ?? '') . ')'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.page-title { font-size: 24px; font-weight: 600; margin-bottom: 12px; color: var(--text); }
.sub-title { color: var(--muted); margin-bottom: 20px; }
.table-card { background: var(--surface); border-radius: 16px; box-shadow: var(--shadow-sm); border:1px solid var(--border); padding: 16px; }
.req-table { width: 100%; border-collapse: collapse; }
.req-table th, .req-table td { padding: 12px 14px; border-bottom: 1px solid var(--border); font-size: 14px; color: var(--text); }
.req-table th { background: var(--table-head); }
.actions { display:flex; gap:8px; }
.btn { padding:8px 12px; border:none; border-radius:10px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
.btn-primary { background:#F36F45; color:#fff; }
.btn-secondary { background:#6b7280; color:#fff; }
@media (max-width: 640px) {
    .req-table thead { display:none; }
    .req-table, .req-table tbody { display:block; width:100%; }
    .req-table tr { display:block; margin-bottom:12px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:8px; }
    .req-table td { display:inline-block; width:calc(50% - 8px); margin:0 4px 8px; white-space:normal; vertical-align:top; }
    .req-table td::before { content: attr(data-label); display:block; font-weight:600; color:var(--muted); margin-bottom:4px; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<h2 class="page-title">Detail Permintaan – <?php echo e($raider->nama_lengkap ?? $raider->username); ?> (<?php echo e($cabang->nama_cabang); ?>)</h2>
<div class="sub-title">Daftar permintaan produk dari rider ini</div>

<div class="table-card">
    <table class="req-table">
        <thead>
            <tr>
                <th>Raider</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $permintaan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $namaProduk = optional(optional($req->details->first())->produk)->nama_produk ?? '-';
                    $jumlah = $req->details->sum('jumlah');
                    $status = $req->status_permintaan ?? 'pending';
                ?>
                <tr>
                    <td data-label="Raider"><?php echo e($raider->nama_lengkap ?? $raider->username); ?></td>
                    <td data-label="Produk"><?php echo e($namaProduk); ?></td>
                    <td data-label="Jumlah"><?php echo e(number_format($jumlah,0,',','.')); ?></td>
                    <td data-label="Tanggal"><?php echo e(\Carbon\Carbon::parse($req->dibuat_pada)->format('d/m/Y H:i')); ?></td>
                    <td data-label="Status"><?php echo e(ucfirst($status)); ?></td>
                    <td data-label="Aksi">
                        <div class="actions">
                            <a class="btn btn-secondary" href="<?php echo e(route('kepala.permintaan-stok.detail', $req->id_permintaan)); ?>"><i class="fas fa-list"></i> Lihat Detail Permintaan</a>
                            <form action="<?php echo e(route('kepala.permintaan-stok.approve', $req->id_permintaan)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> ACC</button>
                            </form>
                            <form action="<?php echo e(route('kepala.permintaan-stok.pending', $req->id_permintaan)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-secondary"><i class="fas fa-clock"></i> Pending</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5">Belum ada permintaan dari rider ini.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\RplBo\Be FIx\resources\views/kepala-gudang/permintaan/rider.blade.php ENDPATH**/ ?>