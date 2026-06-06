<?php

return [
    'tax_rate' => env('SHOP_TAX_RATE', 0),
    'audit_log_retention_days' => (int) env('AUDIT_LOG_RETENTION_DAYS', 90),
];
