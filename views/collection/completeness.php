<?php
// Helper: render count + status badge
function completeness_cell($count, $status) {
    if ($status === 'ok') {
        $badge = '<span class="badge badge-success ml-1">ok</span>';
    } elseif ($status === 'incomplete') {
        $badge = '<span class="badge badge-warning ml-1">不完整</span>';
    } else {
        $badge = '<span class="badge badge-danger ml-1">缺</span>';
    }
    $color = ($status === 'ok') ? 'text-success' : (($status === 'incomplete') ? 'text-warning' : 'text-danger');
    return '<span class="' . $color . ' font-weight-bold">' . $count . '</span>' . $badge;
}
?>
<?php $this->yield_start('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">資料完整度</h1>
    <?php if ($this->councils): ?>
        <?php $updated = $this->councils[0]->{'updated_at'} ?? ''; ?>
        <?php if ($updated): ?>
        <small class="text-muted">更新於 <?= htmlspecialchars($updated) ?></small>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php if ($this->cc_code): ?>
    <?= $this->partial('collection/completeness_detail', $this) ?>
<?php else: ?>

<?php
// Split councils: active vs defunct
$active = array_filter($this->councils ?? [], fn($c) => $c->{'現存'} ?? false);
$defunct = array_filter($this->councils ?? [], fn($c) => !($c->{'現存'} ?? false));
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">現存議會（<?= count($active) ?> 個）</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>議會</th>
                    <th class="text-center">屆</th>
                    <th class="text-center">議員</th>
                    <th class="text-center">會期</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($active as $c): ?>
                <?php $types = $c->types; ?>
                <tr>
                    <td>
                        <a href="/collection/completeness/<?= htmlspecialchars($c->{'代碼'}) ?>">
                            <?= htmlspecialchars($c->{'議會名稱'}) ?>
                        </a>
                        <small class="text-muted ml-1"><?= htmlspecialchars($c->{'代碼'}) ?></small>
                    </td>
                    <td class="text-center"><?= completeness_cell($types->term->total, $types->term->status) ?></td>
                    <td class="text-center"><?= completeness_cell($types->councilor->total, $types->councilor->status) ?></td>
                    <td class="text-center"><?= completeness_cell($types->session->total, $types->session->status) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-secondary">已廢止議會（<?= count($defunct) ?> 個）</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>議會</th>
                    <th class="text-center">屆</th>
                    <th class="text-center">議員</th>
                    <th class="text-center">會期</th>
                </tr>
            </thead>
            <tbody class="text-muted">
            <?php foreach ($defunct as $c): ?>
                <?php $types = $c->types; ?>
                <tr>
                    <td>
                        <a href="/collection/completeness/<?= htmlspecialchars($c->{'代碼'}) ?>">
                            <?= htmlspecialchars($c->{'議會名稱'}) ?>
                        </a>
                        <small class="text-muted ml-1"><?= htmlspecialchars($c->{'代碼'}) ?></small>
                    </td>
                    <td class="text-center"><?= completeness_cell($types->term->total, $types->term->status) ?></td>
                    <td class="text-center"><?= completeness_cell($types->councilor->total, $types->councilor->status) ?></td>
                    <td class="text-center"><?= completeness_cell($types->session->total, $types->session->status) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<?php endif; ?>
<?php $this->yield_end() ?>

<?= $this->partial('layout/app', $this) ?>
