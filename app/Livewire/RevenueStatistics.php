<?php

namespace App\Livewire;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class RevenueStatistics extends Component
{
    use WithPagination;

    public $dateRange = 'day';

    public $startDate;

    public $endDate;

    public $perPage = 12;

    protected $queryString = ['dateRange', 'startDate', 'endDate', 'perPage'];

    public function mount()
    {
        $this->startDate = now()->startOfDay()->toDateString();
        $this->endDate = now()->endOfDay()->toDateString();
    }

    public function updatedDateRange()
    {
        $this->resetPage();
        $this->updateDateRange();
    }

    public function updateDateRange()
    {
        switch ($this->dateRange) {
            case 'day':
                $this->startDate = now()->startOfDay()->toDateString();
                $this->endDate = now()->endOfDay()->toDateString();
                break;
            case 'week':
                $this->startDate = now()->startOfWeek()->toDateString();
                $this->endDate = now()->endOfWeek()->toDateString();
                break;
            case 'month':
                $this->startDate = now()->startOfMonth()->toDateString();
                $this->endDate = now()->endOfMonth()->toDateString();
                break;
        }
    }

    public function getStatisticsProperty()
    {
        $storeId = Auth()->user()->store_id;

        $query = Invoice::whereDate('invoices.created_at', '>=', $this->startDate)
            ->whereDate('invoices.created_at', '<=', $this->endDate)
            ->where('store_id', $storeId)
            ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->join('services', 'invoice_details.service_id', '=', 'services.id');

        switch ($this->dateRange) {
            case 'week':
                $query->selectRaw('YEARWEEK(invoices.created_at, 1) as week, YEAR(invoices.created_at) as year, COUNT(DISTINCT invoices.id) as invoice_count, SUM(services.price) as revenue')
                    ->groupBy('week', 'year')
                    ->orderBy('year', 'desc')
                    ->orderBy('week', 'desc');
                break;
            case 'month':
                $query->selectRaw('MONTH(invoices.created_at) as month, YEAR(invoices.created_at) as year, COUNT(DISTINCT invoices.id) as invoice_count, SUM(services.price) as revenue')
                    ->groupBy('month', 'year')
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc');
                break;
            default:
                $query->selectRaw('DATE(invoices.created_at) as date, COUNT(DISTINCT invoices.id) as invoice_count, SUM(services.price) as revenue')
                    ->groupBy('date')
                    ->orderBy('date', 'desc');
                break;
        }

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.revenue-statistics', [
            'statistics' => $this->statistics,
        ]);
    }
}
