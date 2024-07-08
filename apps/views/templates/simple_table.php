<div class="table-responsive">
    <table class="table table-striped table-sm table-search">
        <thead>
            <tr>
                <?php foreach ($header as $th):?>
                    <th><?=$th;?></th>
                <?php endforeach;?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($body as $tr):?>
                <tr class="<?=$tr['class_tr']?>">
                    <?php foreach ($tr['tds'] as $td):?>
                        <td><?=$td;?></td>
                    <?php endforeach;?>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>