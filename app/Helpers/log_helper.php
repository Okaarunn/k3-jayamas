<?php

use App\Models\DataLogsModel;

if (!function_exists('write_log')) {
    function write_log(
        string $module,
        string $action,
        string $description,
        ?int $targetId = null,
        ?array $oldData = null,
        ?array $newData = null
    ): void {

        $logModel = new DataLogsModel();

        $logModel->insert([
            'user_id'     => user_id(),
            'module'      => $module,
            'action'      => $action,
            'target_id'   => $targetId,
            'description' => $description,
            'old_data'    => $oldData ? json_encode($oldData) : null,
            'new_data'    => $newData ? json_encode($newData) : null,
            'ip_address'  => service('request')->getIPAddress(),
            'user_agent'  => service('request')->getUserAgent()->getAgentString(),
        ]);
    }
}
