<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AnticorruptionReport;
use App\Models\Appeal;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $slaDays = max(1, (int) env('APPEAL_RESPONSE_SLA_DAYS', 7));

        $appealsTotal = Appeal::count();
        $appealsNew = Appeal::whereNull('responded_at')->count();
        $appealsResolved = Appeal::whereNotNull('responded_at')->count();

        $anticorruptionTotal = AnticorruptionReport::count();
        $anticorruptionNew = AnticorruptionReport::whereNull('responded_at')->count();
        $anticorruptionResolved = AnticorruptionReport::whereNotNull('responded_at')->count();

        $incomingTotal = $appealsTotal + $anticorruptionTotal;
        $incomingNew = $appealsNew + $anticorruptionNew;
        $incomingResolved = $appealsResolved + $anticorruptionResolved;

        $monthlyAppeals = Appeal::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyReports = AnticorruptionReport::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthLabels = $monthlyAppeals->keys()
            ->merge($monthlyReports->keys())
            ->unique()
            ->sort()
            ->values();

        if ($monthLabels->count() > 8) {
            $monthLabels = $monthLabels->slice(-8)->values();
        }

        if ($monthLabels->isEmpty()) {
            $monthLabels = collect(['Нет данных']);
        }

        $appealsMonthlyValues = $monthLabels->map(fn ($month) => (int) ($monthlyAppeals[$month] ?? 0));
        $reportsMonthlyValues = $monthLabels->map(fn ($month) => (int) ($monthlyReports[$month] ?? 0));

        [$onTimeResolved, $overdueResolved] = $this->countResolvedBySla($slaDays);
        $resolvedWithSla = $onTimeResolved + $overdueResolved;
        $overdueShare = $resolvedWithSla > 0
            ? round(100 * $overdueResolved / $resolvedWithSla, 1)
            : 0.0;

        $avgResponseHours = $this->calculateAverageResponseHours();

        $topCategories = Appeal::query()
            ->leftJoin('problem_categories as pc', 'pc.id', '=', 'appeals.problem_category_id')
            ->selectRaw("COALESCE(pc.name, 'Без категории') as name, COUNT(*) as total")
            ->groupBy('name')
            ->orderByDesc('total')
            ->limit(8)
            ->get();
        $topSubcategories = Appeal::query()
            ->leftJoin('problem_subcategories as psc', 'psc.id', '=', 'appeals.problem_subcategory_id')
            ->selectRaw("COALESCE(psc.name, 'Без подкатегории') as name, COUNT(*) as total")
            ->groupBy('name')
            ->orderByDesc('total')
            ->limit(8)
            ->get();
        $topDetails = Appeal::query()
            ->leftJoin('problem_details as pd', 'pd.id', '=', 'appeals.problem_detail_id')
            ->selectRaw("COALESCE(pd.name, 'Без детальной проблемы') as name, COUNT(*) as total")
            ->groupBy('name')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $topCategoryLabels = $topCategories->pluck('name')->values();
        $topCategoryValues = $topCategories->pluck('total')->map(fn ($v) => (int) $v)->values();
        $topSubcategoryLabels = $topSubcategories->pluck('name')->values();
        $topSubcategoryValues = $topSubcategories->pluck('total')->map(fn ($v) => (int) $v)->values();
        $topDetailLabels = $topDetails->pluck('name')->values();
        $topDetailValues = $topDetails->pluck('total')->map(fn ($v) => (int) $v)->values();
        if ($topCategoryLabels->isEmpty()) {
            $topCategoryLabels = collect(['Нет данных']);
            $topCategoryValues = collect([0]);
        }
        if ($topSubcategoryLabels->isEmpty()) {
            $topSubcategoryLabels = collect(['Нет данных']);
            $topSubcategoryValues = collect([0]);
        }
        if ($topDetailLabels->isEmpty()) {
            $topDetailLabels = collect(['Нет данных']);
            $topDetailValues = collect([0]);
        }

        return view('staff.analytics.index', compact(
            'slaDays',
            'incomingTotal',
            'incomingNew',
            'incomingResolved',
            'appealsTotal',
            'appealsNew',
            'appealsResolved',
            'anticorruptionTotal',
            'anticorruptionNew',
            'anticorruptionResolved',
            'monthLabels',
            'appealsMonthlyValues',
            'reportsMonthlyValues',
            'onTimeResolved',
            'overdueResolved',
            'overdueShare',
            'avgResponseHours',
            'topCategories',
            'topCategoryLabels',
            'topCategoryValues',
            'topSubcategoryLabels',
            'topSubcategoryValues',
            'topDetailLabels',
            'topDetailValues',
        ));
    }

    /**
     * @return array{0: int, 1: int}
     */
    private function countResolvedBySla(int $slaDays): array
    {
        $appealRows = Appeal::query()
            ->whereNotNull('responded_at')
            ->selectRaw(
                'SUM(CASE WHEN responded_at <= DATE_ADD(created_at, INTERVAL ? DAY) THEN 1 ELSE 0 END) as on_time',
                [$slaDays]
            )
            ->selectRaw(
                'SUM(CASE WHEN responded_at > DATE_ADD(created_at, INTERVAL ? DAY) THEN 1 ELSE 0 END) as overdue',
                [$slaDays]
            )
            ->first();

        $reportRows = AnticorruptionReport::query()
            ->whereNotNull('responded_at')
            ->selectRaw(
                'SUM(CASE WHEN responded_at <= DATE_ADD(created_at, INTERVAL ? DAY) THEN 1 ELSE 0 END) as on_time',
                [$slaDays]
            )
            ->selectRaw(
                'SUM(CASE WHEN responded_at > DATE_ADD(created_at, INTERVAL ? DAY) THEN 1 ELSE 0 END) as overdue',
                [$slaDays]
            )
            ->first();

        $onTime = (int) (($appealRows->on_time ?? 0) + ($reportRows->on_time ?? 0));
        $overdue = (int) (($appealRows->overdue ?? 0) + ($reportRows->overdue ?? 0));

        return [$onTime, $overdue];
    }

    private function calculateAverageResponseHours(): float
    {
        $appealAvg = Appeal::query()
            ->whereNotNull('responded_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, responded_at)) as avg_hours')
            ->value('avg_hours');

        $reportAvg = AnticorruptionReport::query()
            ->whereNotNull('responded_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, responded_at)) as avg_hours')
            ->value('avg_hours');

        $appealResolved = Appeal::whereNotNull('responded_at')->count();
        $reportResolved = AnticorruptionReport::whereNotNull('responded_at')->count();
        $resolvedTotal = $appealResolved + $reportResolved;

        if ($resolvedTotal === 0) {
            return 0.0;
        }

        $weightedHours = ((float) $appealAvg * $appealResolved) + ((float) $reportAvg * $reportResolved);

        return round($weightedHours / $resolvedTotal, 1);
    }
}
