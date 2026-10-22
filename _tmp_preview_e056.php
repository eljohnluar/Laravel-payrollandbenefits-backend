<?php
// Read-only payroll PREVIEW (persist=false) for run 4 (Oct 1-15), extracting hris-e056.
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$svc = new App\PayrollService(App\Database::pdo());
$run = $svc->getRun(4);
foreach ($run['items'] ?? [] as $it) {
    if (($it['employee_id'] ?? '') === 'hris-e056') {
        $keys = ['employee_name','department','days_worked','ot_hours','basic_pay','overtime_pay',
                 'night_differential','holiday_pay','allowances','claims_amount','incentives','gross_pay',
                 'sss_ee','philhealth_ee','pagibig_ee','withholding_tax','loans_deduction',
                 'unpaid_leave_deduction','hmo_deduction','attendance_deduction','total_deductions','net_pay'];
        $out = [];
        foreach ($keys as $k) $out[$k] = $it[$k] ?? null;
        echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), "\n";
        exit;
    }
}
echo "hris-e056 not in run items — seeding needed. Run status: " . ($run['run']['status'] ?? $run['status'] ?? '?') . "\n";
