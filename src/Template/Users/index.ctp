<?php
$this->Html->css('//cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css', ['block'=> true]);
$this->Html->script('//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js', ['block'=> true]);
$this->Html->script('//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js', ['block'=> true]);
$this->Html->script('dbtable_handle', ['block'=> true]);
$this->Html->scriptStart(['block' => true]);
$options = json_encode([
    'url' => $this->Url->build(['_name' => 'admin_users']),
    'object' => '#data-table',
    'config' => [
        'columns' => [
            ['data'=> 'checkbox', 'orderable' => false, 'type' => 'checkbox'],
            ['data'=>'id', 'type' => 'text'],
            ['data'=>'username'],
            ['data'=>'email'],
            ['data'=>'gender'],
            ['data'=>'phone'],
            ['data'=>'fullname'],
            ['data'=>'role', 'type' => 'text'],
            ['data' =>'action', 'orderable' => false]
        ]
    ]
]);
$data = json_encode($this->viewVars);
echo <<<EOJS
Dt.Handle.init({$options}, {$data});
EOJS;
$this->Html->scriptEnd();
?>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users')?></h3>
    <table id="data-table" class="table table-bordered table-hover table-striped table-responsive">
        <thead>
            <tr>
                <th><input type="checkbox" class="checkall" /></th>
                <th>id</th>
                <th>username</th>
                <th>email</th>
                <th>gender</th>
                <th>phone</th>
                <th>fullname</th>
                <th>role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
