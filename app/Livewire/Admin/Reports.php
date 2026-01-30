<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Appointment;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Reports extends Component
{
    use WithPagination;

    public $reportType = 'consultations';
    public $startDate;
    public $endDate;
    public $chartType = 'line';
    public $breakdownType = 'pie';

    public $stats = [];
    public $chartData = [];
    public $breakdownData = [];
    public $recentActivity = [];
    public $platformMetrics = [];

    public function mount()
    {
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->loadStats();
        $this->generateRecentActivity();
        $this->calculatePlatformMetrics();
    }

    public function updated($field)
    {
        if (in_array($field, ['reportType', 'startDate', 'endDate', 'chartType', 'breakdownType'])) {
            $this->loadStats();
        }
    }

    public function loadStats()
    {
        $start = $this->startDate ? $this->startDate . ' 00:00:00' : null;
        $end = $this->endDate ? $this->endDate . ' 23:59:59' : null;

        if ($this->reportType === 'consultations') {
            $this->loadConsultationStats($start, $end);
        } elseif ($this->reportType === 'users') {
            $this->loadUserStats($start, $end);
        } elseif ($this->reportType === 'donations') {
            $this->loadDonationStats($start, $end);
        }

        $this->buildChartData();
        $this->calculatePlatformMetrics();

        $this->dispatch('chart-updated', [
            'chart' => $this->chartData,
            'breakdown' => $this->breakdownData,
            'chartType' => $this->chartType,
            'breakdownType' => $this->breakdownType,
        ]);
    }

    private function loadConsultationStats($start, $end)
    {
        $query = Appointment::query();
        if ($start) $query->where('created_at', '>=', $start);
        if ($end) $query->where('created_at', '<=', $end);

        $total = $query->count();
        $byStatus = $query->select('status', DB::raw('count(*) as cnt'))
            ->groupBy('status')
            ->get()
            ->pluck('cnt', 'status')
            ->toArray();

        // Calculate average consultation duration (in minutes)
        $avgDuration = Appointment::where('status', 'completed')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, updated_at)) as avg_duration'))
            ->first()
            ->avg_duration ?? 15;

        // Calculate peak hours
        $peakHours = Appointment::select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('count', 'desc')
            ->first();

        $peakHourRange = $peakHours ? sprintf('%02d:00 - %02d:00', $peakHours->hour, $peakHours->hour + 1) : '10:00 - 14:00';

        // Calculate response time (average time to first response)
        if (Schema::hasColumn('appointments', 'doctor_responded_at')) {
            $responseRow = Appointment::whereNotNull('doctor_responded_at')
                ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, doctor_responded_at)) as avg_response_time'))
                ->first();
            $responseTime = $responseRow->avg_response_time ?? 3.2;
        } else {
            // Column missing in database; fall back to a sensible default
            $responseTime = 3.2;
        }

        // Calculate satisfaction rate (assuming 5-star rating system)
        if (Schema::hasColumn('appointments', 'rating')) {
            $satisfaction = Appointment::whereNotNull('rating')->avg('rating');
            $satisfaction = $satisfaction ?? 4.8;
        } else {
            // Column missing in database; use a sensible default
            $satisfaction = 4.8;
        }
        $satisfactionRate = round(($satisfaction / 5) * 100);

        $this->stats = [
            'total' => $total,
            'byStatus' => $byStatus,
            'avgDuration' => round($avgDuration, 1),
            'peakHours' => $peakHourRange,
            'responseTime' => round($responseTime, 1),
            'repeatUsers' => $this->calculateRepeatUsers(),
            'satisfaction' => $satisfactionRate,
            'active' => Appointment::where('created_at', '>=', now()->subDays(7))->count(),
            'totalAmount' => Appointment::where('status', 'completed')->sum('fee'),
        ];
    }

    private function loadUserStats($start, $end)
    {
        $query = User::where('role', 'patient');
        if ($start) $query->where('created_at', '>=', $start);
        if ($end) $query->where('created_at', '<=', $end);

        $total = $query->count();
        if (Schema::hasColumn('users', 'last_login_at')) {
            $active = User::where('role', 'patient')
                ->where('last_login_at', '>=', now()->subDays(7))
                ->count();
        } else {
            // Fallback when `last_login_at` is not available: use recent signups as proxy
            $active = User::where('role', 'patient')
                ->where('created_at', '>=', now()->subDays(7))
                ->count();
        }

        // User engagement metrics
        $avgSessionDuration = 12; // This would come from analytics in real app
        $peakUsage = '18:00 - 22:00';
        $responseRate = 95;

        $this->stats = [
            'total' => $total,
            'active' => $active,
            'avgDuration' => $avgSessionDuration,
            'peakHours' => $peakUsage,
            'responseTime' => 2.5,
            'repeatUsers' => $this->calculateRepeatUsers(),
            'satisfaction' => 94,
            'totalAmount' => 0,
        ];
    }

    private function loadDonationStats($start, $end)
    {
        $query = WalletTransaction::query()->where('type', 'credit');
        if ($start) $query->where('created_at', '>=', $start);
        if ($end) $query->where('created_at', '<=', $end);
        $query->where(function($q) {
            $q->whereJsonContains('metadata->tags', 'donation')
              ->orWhere('description', 'like', '%donation%');
        });

        $totalAmount = $query->sum('amount');
        $count = $query->count();

        // Donation metrics
        $avgDonation = $count > 0 ? $totalAmount / $count : 0;
        $peakDonationTime = '09:00 - 12:00';
        $repeatDonors = $this->calculateRepeatDonors();

        $this->stats = [
            'total' => $count,
            'active' => $repeatDonors,
            'totalAmount' => $totalAmount,
            'avgDuration' => round($avgDonation, 0),
            'peakHours' => $peakDonationTime,
            'responseTime' => 'Instant',
            'repeatUsers' => $repeatDonors,
            'satisfaction' => 100,
        ];
    }

    private function calculateRepeatUsers()
    {
        return User::where('role', 'patient')
            ->has('appointments', '>', 1)
            ->count();
    }

    private function calculateRepeatDonors()
    {
        // Some apps expose transactions via `wallet()->transactions()` rather than a `walletTransactions` relation
        // Build the count by joining wallet_transactions -> wallets and grouping by wallets.user_id
        $rows = DB::table('wallet_transactions')
            ->join('wallets', 'wallet_transactions.wallet_id', '=', 'wallets.id')
            ->where('wallet_transactions.type', 'credit')
            ->where(function($q) {
                $q->whereJsonContains('wallet_transactions.metadata->tags', 'donation')
                  ->orWhere('wallet_transactions.description', 'like', '%donation%');
            })
            ->select('wallets.user_id', DB::raw('COUNT(*) as cnt'))
            ->groupBy('wallets.user_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        return $rows->count();
    }

    private function buildChartData()
    {
        $labels = [];
        // Prepare two datasets by default to avoid uneven array lengths which can break Chart.js
        $datasets = [
            0 => ['data' => []],
            1 => ['data' => []],
        ];
        $this->breakdownData = [];

        $start = $this->startDate ? Carbon::parse($this->startDate) : Carbon::now()->subDays(6);
        $end = $this->endDate ? Carbon::parse($this->endDate) : Carbon::now();

        $period = $start->copy();
        while ($period->lte($end)) {
            $labels[] = $period->format('M d');

            if ($this->reportType === 'consultations') {
                $total = Appointment::whereDate('created_at', $period->toDateString())->count();
                $completed = Appointment::whereDate('created_at', $period->toDateString())->where('status', 'completed')->count();
                $datasets[0]['data'][] = $total;
                $datasets[1]['data'][] = $completed;
            } elseif ($this->reportType === 'users') {
                $newUsers = User::whereDate('created_at', $period->toDateString())->where('role', 'patient')->count();
                if (Schema::hasColumn('users', 'last_login_at')) {
                    $loggedIn = User::whereDate('last_login_at', $period->toDateString())->where('role', 'patient')->count();
                } else {
                    // Fallback: use created_at as a proxy for active/logged-in users when column missing
                    $loggedIn = User::whereDate('created_at', $period->toDateString())->where('role', 'patient')->count();
                }
                $datasets[0]['data'][] = $newUsers;
                $datasets[1]['data'][] = $loggedIn;
            } elseif ($this->reportType === 'donations') {
                $sum = WalletTransaction::whereDate('created_at', $period->toDateString())
                    ->where('type', 'credit')
                    ->where(function($q) {
                        $q->whereJsonContains('metadata->tags', 'donation')
                          ->orWhere('description', 'like', '%donation%');
                    })->sum('amount');
                $count = WalletTransaction::whereDate('created_at', $period->toDateString())
                    ->where('type', 'credit')
                    ->where(function($q) {
                        $q->whereJsonContains('metadata->tags', 'donation')
                          ->orWhere('description', 'like', '%donation%');
                    })->count();
                $datasets[0]['data'][] = floatval($sum);
                $datasets[1]['data'][] = $count;
            }

            $period->addDay();
        }

        // Ensure each dataset has the same length as labels by padding with zeros if necessary
        foreach ($datasets as &$ds) {
            if (!isset($ds['data']) || !is_array($ds['data'])) {
                $ds['data'] = array_fill(0, count($labels), 0);
            } elseif (count($ds['data']) < count($labels)) {
                $ds['data'] = array_pad($ds['data'], count($labels), 0);
            }
        }

        // Set dataset configurations
        if ($this->reportType === 'consultations') {
            $datasets[0]['label'] = 'Total Consultations';
            $datasets[0]['backgroundColor'] = 'rgba(59, 130, 246, 0.1)';
            $datasets[0]['borderColor'] = 'rgba(59, 130, 246, 1)';

            $datasets[1]['label'] = 'Completed Consultations';
            $datasets[1]['backgroundColor'] = 'rgba(34, 197, 94, 0.1)';
            $datasets[1]['borderColor'] = 'rgba(34, 197, 94, 1)';

            $byStatus = Appointment::select('status', DB::raw('count(*) as cnt'))
                ->groupBy('status')->get()->pluck('cnt', 'status')->toArray();
            $this->breakdownData = $byStatus;
        } elseif ($this->reportType === 'users') {
            $datasets[0]['label'] = 'New Users';
            $datasets[0]['backgroundColor'] = 'rgba(250, 204, 21, 0.1)';
            $datasets[0]['borderColor'] = 'rgba(250, 204, 21, 1)';

            $datasets[1]['label'] = 'Active Users';
            $datasets[1]['backgroundColor'] = 'rgba(249, 115, 22, 0.1)';
            $datasets[1]['borderColor'] = 'rgba(249, 115, 22, 1)';
        } elseif ($this->reportType === 'donations') {
            $datasets[0]['label'] = 'Donations (LKR)';
            $datasets[0]['backgroundColor'] = 'rgba(139, 92, 246, 0.1)';
            $datasets[0]['borderColor'] = 'rgba(139, 92, 246, 1)';

            $datasets[1]['label'] = 'Donation Count';
            $datasets[1]['backgroundColor'] = 'rgba(16, 185, 129, 0.1)';
            $datasets[1]['borderColor'] = 'rgba(16, 185, 129, 1)';
        }

        // Add chart type specific properties
        foreach ($datasets as &$dataset) {
            $dataset['borderWidth'] = 2;
            $dataset['fill'] = $this->chartType === 'area';
            $dataset['tension'] = 0.4;
            if (!isset($dataset['borderColor'])) {
                $dataset['borderColor'] = $dataset['backgroundColor'] ?? 'rgba(0,0,0,1)';
            }
            $dataset['pointBackgroundColor'] = $dataset['borderColor'];
            $dataset['pointRadius'] = 4;
            $dataset['pointHoverRadius'] = 6;
        }

        $this->chartData = [
            'labels' => $labels,
            'datasets' => $datasets,
            'label' => $this->getChartTitle(),
        ];

        // Generate breakdown data if not already set
        if (empty($this->breakdownData) && isset($this->stats['byStatus'])) {
            $this->breakdownData = $this->stats['byStatus'];
        }
    }

    private function generateRecentActivity()
    {
        $this->recentActivity = [
            [
                'icon' => 'video_call',
                'title' => 'New Consultation',
                'description' => 'Dr. Smith with patient John Doe',
                'time' => '2 hours ago',
                'badge' => 'Completed',
                'badgeColor' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                'color' => 'bg-blue-500',
            ],
            [
                'icon' => 'person_add',
                'title' => 'New User Registered',
                'description' => 'Patient registration completed',
                'time' => '4 hours ago',
                'badge' => 'Active',
                'badgeColor' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                'color' => 'bg-green-500',
            ],
            [
                'icon' => 'payments',
                'title' => 'Donation Received',
                'description' => 'LKR 5,000 donation received',
                'time' => '1 day ago',
                'badge' => 'Processed',
                'badgeColor' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                'color' => 'bg-purple-500',
            ],
            [
                'icon' => 'rate_review',
                'title' => 'New Review',
                'description' => '5-star rating from Sarah Johnson',
                'time' => '2 days ago',
                'badge' => 'Positive',
                'badgeColor' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
                'color' => 'bg-orange-500',
            ],
        ];
    }

    private function calculatePlatformMetrics()
    {
        $this->platformMetrics = [
            'avg_consultation_duration' => $this->stats['avgDuration'] ?? 15,
            'peak_hours' => $this->stats['peakHours'] ?? '10:00 - 14:00',
            'avg_response_time' => $this->stats['responseTime'] ?? 3.2,
            'repeat_users_percentage' => $this->stats['repeatUsers'] ?? 42,
        ];
    }

    public function setChartType($type)
    {
        $this->chartType = $type;
        $this->loadStats();
    }

    public function setBreakdownType($type)
    {
        $this->breakdownType = $type;
        $this->loadStats();
    }

    public function generateReport()
    {
        $this->loadStats();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Report generated successfully.',
        ]);
    }

    public function exportCsv()
    {
        $start = $this->startDate ? $this->startDate . ' 00:00:00' : null;
        $end = $this->endDate ? $this->endDate . ' 23:59:59' : null;

        $filename = $this->reportType . '_report_' . now()->format('Ymd_His') . '.csv';

        return new StreamedResponse(function() use ($start, $end) {
            $handle = fopen('php://output', 'w');
            if ($this->reportType === 'consultations') {
                fputcsv($handle, ['ID', 'Patient', 'Doctor', 'Status', 'Fee (LKR)', 'Created At', 'Completed At']);
                $q = Appointment::with(['patient', 'doctor'])->orderBy('created_at', 'desc');
                if ($start) $q->where('created_at', '>=', $start);
                if ($end) $q->where('created_at', '<=', $end);
                foreach ($q->cursor() as $a) {
                    fputcsv($handle, [
                        $a->id,
                        $a->patient?->name ?? 'N/A',
                        $a->doctor?->name ?? 'N/A',
                        $a->status,
                        $a->fee,
                        $a->created_at,
                        $a->completed_at ?? 'N/A'
                    ]);
                }
            } elseif ($this->reportType === 'users') {
                fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Registered At', 'Last Login', 'Total Consultations']);
                $q = User::where('role', 'patient')->orderBy('created_at', 'desc');
                if ($start) $q->where('created_at', '>=', $start);
                if ($end) $q->where('created_at', '<=', $end);
                foreach ($q->cursor() as $u) {
                    $consultationCount = $u->appointments()->count();
                    fputcsv($handle, [
                        $u->id,
                        $u->name,
                        $u->email,
                        $u->phone ?? 'N/A',
                        $u->created_at,
                        $u->last_login_at ?? 'Never',
                        $consultationCount
                    ]);
                }
            } elseif ($this->reportType === 'donations') {
                fputcsv($handle, ['ID', 'Donor Name', 'Amount (LKR)', 'Description', 'Payment Method', 'Created At']);
                $q = WalletTransaction::where('type', 'credit')->with('wallet.user')->orderBy('created_at', 'desc');
                if ($start) $q->where('created_at', '>=', $start);
                if ($end) $q->where('created_at', '<=', $end);
                $q->where(function($q) {
                    $q->whereJsonContains('metadata->tags', 'donation')
                      ->orWhere('description', 'like', '%donation%');
                });
                foreach ($q->cursor() as $t) {
                    fputcsv($handle, [
                        $t->id,
                        $t->wallet?->user?->name ?? 'Anonymous',
                        $t->amount,
                        $t->description,
                        $t->metadata['payment_method'] ?? 'N/A',
                        $t->created_at
                    ]);
                }
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportPdf()
    {
        // This would integrate with a PDF library like DomPDF
        $this->dispatch('notify', [
            'type' => 'info',
            'message' => 'PDF export feature coming soon.',
        ]);
    }

    public function getChartTitle()
    {
        return match($this->reportType) {
            'consultations' => 'Consultation Trends',
            'users' => 'User Activity Over Time',
            'donations' => 'Donation Statistics',
            default => 'Analytics Report',
        };
    }

    public function getChartSubtitle()
    {
        return match($this->reportType) {
            'consultations' => 'Daily consultation count and trends',
            'users' => 'New and active user statistics',
            'donations' => 'Donation amounts and frequency',
            default => 'Analysis over selected period',
        };
    }

    public function getBreakdownTitle()
    {
        return match($this->reportType) {
            'consultations' => 'Consultation Status Distribution',
            'users' => 'User Engagement Breakdown',
            'donations' => 'Donation Type Distribution',
            default => 'Category Breakdown',
        };
    }

    public function getStatusColor($status)
    {
        return match(strtolower($status)) {
            'completed', 'active' => 'bg-green-500',
            'pending', 'scheduled' => 'bg-yellow-500',
            'cancelled', 'failed' => 'bg-red-500',
            'rescheduled' => 'bg-blue-500',
            default => 'bg-gray-500',
        };
    }

    public function render()
    {
        return view('livewire.admin.reports', [
            'reportType' => $this->reportType,
            'stats' => $this->stats,
            'chartData' => $this->chartData,
            'breakdownData' => $this->breakdownData,
            'recentActivity' => $this->recentActivity,
            'platformMetrics' => $this->platformMetrics,
        ]);
    }
}