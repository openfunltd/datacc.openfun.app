<?php $this->yield_start('content') ?>
<div class="pt-4 pb-3">
    <h1 class="h3 mb-2 text-gray-800">DataCC 地方議會資料瀏覽</h1>
    <p class="mb-4">
        目前瀏覽 API：<a href="https://<?= $this->escape($this->ccapi_host) ?>" target="_blank"><code><?= $this->escape($this->ccapi_host) ?></code></a>
    </p>
    <div class="row">
        <?php foreach (TypeHelper::getTypeConfig() as $key => $config) { ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= $this->escape($config['name']) ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $this->escape($key) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="<?= $this->escape($config['icon']) ?> fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="/collection/list/<?= $key ?>" class="small text-primary">瀏覽資料 &rarr;</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php $this->yield_end() ?>

<?= $this->partial('layout/app', $this) ?>
