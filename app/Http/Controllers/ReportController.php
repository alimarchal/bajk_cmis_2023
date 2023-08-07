<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchOutstanding;
use App\Models\BranchOutstandingDaily;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductWiseMonthly;
use App\Models\ProductWiseNplAdvance;
use App\Models\ProductWiseNplMonthly;
use App\Models\Valuation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function branchWisePosition(Request $request)
    {
        // Get all branches id
        $month_date = null;
        $zone_data = null;

        if ($request->input('zone')) {
            $zone_data = $request->zone;
        } else {
            $zone_data = 'Muzaffarabad';
        }

        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }


        $branch_wise_principal_outstanding_target = null;
        $principal_outstanding_previous_month = null;
        $principal_outstanding_last_year = null;


        $month = Carbon::parse($month_date);
        $previous_month = Carbon::parse($month_date)->subMonth();
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();

        $branches = Branch::where('zone', $zone_data)->get();

        $branches_array = Branch::where('zone', $zone_data)->pluck('id')->toArray();

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            $branch_wise_principal_outstanding = DB::table('customers')
                ->select('branch_id', 'principle_amount', DB::raw("SUM(principle_amount) as principle_amount"))
                ->whereIn('branch_id', $branches_array)
                ->groupBy('branch_id')
                ->get();

            $new_date = Carbon::parse($month);

            $branch_wise_principal_outstanding_target = DB::table('branch_targets')
                ->select('branch_targets.branch_id', 'branches.id', 'branches.region', 'branches.zone', DB::raw("SUM(branch_targets.amount) as amount"))
                ->join('branches', 'branch_targets.branch_id', '=', 'branches.id')
                ->whereIn('branch_id', $branches_array)
                ->whereBetween('branch_targets.year', [$new_date->startOfYear()->format('Y-m-d'), $new_date->endOfYear()->format('Y-m-d')])
                ->groupBy('branch_targets.branch_id')
                ->get();
        } else {
            $branch_wise_principal_outstanding = DB::table('branch_outstandings')
                ->select('branch_id', 'principle_outstanding', DB::raw("SUM(principle_outstanding) as branch_outstanding_balance"))
                ->whereIn('branch_id', $branches_array)
                ->whereBetween('created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->groupBy('branch_id')
                ->get();

            $new_date = Carbon::parse($month);
            $branch_wise_principal_outstanding_target = DB::table('branch_targets')
                ->select('branch_targets.branch_id', 'branches.id', 'branches.region', 'branches.zone', DB::raw("SUM(branch_targets.amount) as amount"))
                ->join('branches', 'branch_targets.branch_id', '=', 'branches.id')
                ->whereIn('branch_targets.branch_id', $branches_array)
                ->whereBetween('branch_targets.year', [$new_date->startOfYear()->format('Y-m-d'), $new_date->endOfYear()->format('Y-m-d')])
                ->groupBy('branch_targets.branch_id')
                ->get();

        }

        $principal_outstanding_previous_month = DB::table('branch_outstandings')
            ->select('branch_id', 'principle_outstanding', DB::raw("SUM(principle_outstanding) as branch_outstanding_balance"))
            ->whereIn('branch_id', $branches_array)
            ->whereBetween('created_at', [$previous_month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $previous_month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->groupBy('branch_id')
            ->get();

        $principal_outstanding_last_year = DB::table('branch_outstandings')
            ->select('branch_id', 'principle_outstanding', DB::raw("SUM(principle_outstanding) as branch_outstanding_balance"))
            ->whereIn('branch_id', $branches_array)
            ->whereBetween('created_at', [$last_year->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $last_year->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->groupBy('branch_id')
            ->get();

        $data = [];
        $data_last_year = [];
        $data_total = [$month->format('F') => 0.00, $previous_month->format('F') => 0.00, $last_year->format('F') => 0.00];

        foreach ($branches as $branch) {
            $data[$branch->id] = [$month->format('F') . ' - Target' => 0.00, $month->format('F') => 0.00, $previous_month->format('F') => 0.00, $last_year->format('F') => 0.00];
        }


        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($branch_wise_principal_outstanding as $bo) {
                $data[$bo->branch_id][$month->format('F')] = $bo->principle_amount;
                $data_total[$month->format('F')] = $data_total[$month->format('F')] + $bo->principle_amount;
            }


            foreach ($branch_wise_principal_outstanding_target as $bo) {
                $data[$bo->branch_id][$month->format('F') . ' - Target'] = ($bo->amount / 12);
            }

        } else {
            foreach ($branch_wise_principal_outstanding as $bo) {
                $data[$bo->branch_id][$month->format('F')] = $bo->branch_outstanding_balance;
                $data_total[$month->format('F')] = $data_total[$month->format('F')] + $bo->branch_outstanding_balance;
            }

            foreach ($branch_wise_principal_outstanding_target as $bo) {
                $data[$bo->branch_id][$month->format('F') . ' - Target'] = ($bo->amount / 12);
            }
        }

        foreach ($principal_outstanding_previous_month as $bo) {
            $data[$bo->branch_id][$previous_month->format('F')] = $bo->branch_outstanding_balance;
            $data_total[$previous_month->format('F')] = $data_total[$previous_month->format('F')] + $bo->branch_outstanding_balance;
        }

        foreach ($principal_outstanding_last_year as $bo) {
            $data[$bo->branch_id][$last_year->format('F')] = $bo->branch_outstanding_balance;
            $data_total[$last_year->format('F')] = $data_total[$last_year->format('F')] + $bo->principle_amount;
        }

        return view('reports.index', compact('data', 'data_total', 'last_year', 'previous_month', 'month', 'zone_data'));
    }


    public function overallBankPosition(Request $request)
    {
        $month_date = null;
        $zone_data = null;

        if ($request->input('zone')) {
            $zone_data = $request->zone;
        } else {
            $zone_data = 'Muzaffarabad';
        }

        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }


        $month = Carbon::parse($month_date);
        $previous_month = Carbon::parse($month_date)->subMonth();
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();

        $branches = Branch::all();

        $branches_array = Branch::where('zone', $zone_data)->pluck('id')->toArray();

        $branch_wise_principal_outstanding_target = null;
        $principal_outstanding_previous_month = null;
        $principal_outstanding_last_year = null;






        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
//            DB::enableQueryLog();
            $branch_wise_principal_outstanding = DB::table('customers')
                ->select('customers.branch_id', 'branches.id', 'branches.region', 'branches.zone', DB::raw("SUM(customers.principle_amount) as principle_outstanding"))
                ->join('branches', 'customers.branch_id', '=', 'branches.id')
                ->groupBy('branches.zone')
                ->get();

            $new_date = Carbon::parse($month);
            $branch_wise_principal_outstanding_target = DB::table('branch_targets')
                ->select('branch_targets.branch_id', 'branches.id', 'branches.region', 'branches.zone', DB::raw("SUM(branch_targets.amount) as amount"))
                ->join('branches', 'branch_targets.branch_id', '=', 'branches.id')
                ->whereBetween('branch_targets.year', [$new_date->startOfYear()->format('Y-m-d'), $new_date->endOfYear()->format('Y-m-d')])
                ->groupBy('branches.zone')
                ->get();

        } else {
            $branch_wise_principal_outstanding = DB::table('branch_outstandings')
                ->select('branch_outstandings.branch_id', 'branch_outstandings.id', 'branches.region', 'branches.zone', DB::raw("SUM(branch_outstandings.principle_outstanding) as branch_outstanding_balance"))
                ->join('branches', 'branch_outstandings.branch_id', '=', 'branches.id')
                ->whereBetween('branch_outstandings.created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->groupBy('branches.zone')
                ->get();


            $new_date = Carbon::parse($month);
            $branch_wise_principal_outstanding_target = DB::table('branch_targets')
                ->select('branch_targets.branch_id', 'branches.id', 'branches.region', 'branches.zone', DB::raw("SUM(branch_targets.amount) as amount"))
                ->join('branches', 'branch_targets.branch_id', '=', 'branches.id')
                ->whereBetween('branch_targets.year', [$new_date->startOfYear()->format('Y-m-d'), $new_date->endOfYear()->format('Y-m-d')])
                ->groupBy('branches.zone')
                ->get();
        }


        $principal_outstanding_previous_month = DB::table('branch_outstandings')
            ->select('branch_outstandings.branch_id', 'branch_outstandings.id', 'branches.region', 'branches.zone', DB::raw("SUM(branch_outstandings.principle_outstanding) as branch_outstanding_balance"))
            ->join('branches', 'branch_outstandings.branch_id', '=', 'branches.id')
            ->whereBetween('branch_outstandings.created_at', [$previous_month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $previous_month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->groupBy('branches.zone')
            ->get();


        $principal_outstanding_last_year = DB::table('branch_outstandings')
            ->select('branch_outstandings.branch_id', 'branch_outstandings.id', 'branches.region', 'branches.zone', DB::raw("SUM(branch_outstandings.principle_outstanding) as branch_outstanding_balance"))
            ->join('branches', 'branch_outstandings.branch_id', '=', 'branches.id')
            ->whereBetween('branch_outstandings.created_at', [$last_year->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $last_year->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->groupBy('branches.zone')
            ->get();


        $data = [];
        $data_last_year = [];
        $data_total = [$month->format('F') => 0.00, $previous_month->format('F') => 0.00, $last_year->format('F') => 0.00];

        foreach ($branches as $branch) {
            $data[$branch->zone] = [$month->format('F') . ' - Target' => 0.00, $month->format('F') => 0.00, $previous_month->format('F') => 0.00, $last_year->format('F') => 0.00];
        }

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($branch_wise_principal_outstanding as $bo) {
                $data[$bo->zone][$month->format('F')] = $bo->principle_outstanding;
                $data_total[$month->format('F')] = $data_total[$month->format('F')] + $bo->principle_outstanding;
            }

            foreach ($branch_wise_principal_outstanding_target as $bo) {
                $data[$bo->zone][$month->format('F') . ' - Target'] = ($bo->amount / 12);
            }


        } else {
            foreach ($branch_wise_principal_outstanding as $bo) {
                $data[$bo->zone][$month->format('F')] = $bo->branch_outstanding_balance;
                $data_total[$month->format('F')] = $data_total[$month->format('F')] + $bo->branch_outstanding_balance;
            }

            foreach ($branch_wise_principal_outstanding_target as $bo) {
                $data[$bo->zone][$month->format('F') . ' - Target'] = ($bo->amount / 12);
            }

        }


        foreach ($principal_outstanding_previous_month as $bo) {
            $data[$bo->zone][$previous_month->format('F')] = $bo->branch_outstanding_balance;
            $data_total[$previous_month->format('F')] = $data_total[$previous_month->format('F')] + $bo->branch_outstanding_balance;
        }


        foreach ($principal_outstanding_last_year as $bo) {
            $data[$bo->zone][$last_year->format('F')] = $bo->branch_outstanding_balance;
            $data_total[$last_year->format('F')] = $data_total[$last_year->format('F')] + $bo->branch_outstanding_balance;
        }


//        dd($data);

        return view('reports.overallBankPosition', compact('data', 'data_total', 'last_year', 'previous_month', 'month', 'zone_data'));
    }


    public function bankPosition(Request $request)
    {
        $month_date = null;
        $product_type_id = null;

        if ($request->input('product_type_id')) {
            $product_type_id = $request->product_type_id;
        } else {
            $product_type_id = 1;
        }

        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }


        $month = Carbon::parse($month_date);
        $previous_month = Carbon::parse($month_date)->subMonth();
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();

        $branches = Branch::all();

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {

            $branch_wise_principal_outstanding = DB::table('customers')
                ->select('customers.branch_id', 'branches.id', 'branches.region', 'branches.zone', DB::raw("SUM(customers.principle_amount) as principle_outstanding"))
                ->join('branches', 'customers.branch_id', '=', 'branches.id')
                ->where('customers.product_type_id', $product_type_id)
                ->groupBy('branches.zone')
                ->get();


        } else {


            $branch_wise_principal_outstanding = DB::table('product_wise_monthlies')
                ->select('branches.region', 'branches.zone', DB::raw("SUM(product_wise_monthlies.principle_outstanding) as branch_outstanding_balance"))
                ->join('branches', 'product_wise_monthlies.branch_id', '=', 'branches.id')
                ->where('product_wise_monthlies.product_type_id', $product_type_id)
                ->whereBetween('product_wise_monthlies.created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->groupBy('branches.zone')
                ->get();

        }


        $principal_outstanding_previous_month = DB::table('product_wise_monthlies')
            ->select('branches.region', 'branches.zone', DB::raw("SUM(product_wise_monthlies.principle_outstanding) as branch_outstanding_balance"))
            ->join('branches', 'product_wise_monthlies.branch_id', '=', 'branches.id')
            ->where('product_wise_monthlies.product_type_id', $product_type_id)
            ->whereBetween('product_wise_monthlies.created_at', [$previous_month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $previous_month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->groupBy('branches.zone')
            ->get();


        $principal_outstanding_last_year = DB::table('product_wise_monthlies')
            ->select('branches.region', 'branches.zone', DB::raw("SUM(product_wise_monthlies.principle_outstanding) as branch_outstanding_balance"))
            ->join('branches', 'product_wise_monthlies.branch_id', '=', 'branches.id')
            ->where('product_wise_monthlies.product_type_id', $product_type_id)
            ->whereBetween('product_wise_monthlies.created_at', [$last_year->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $last_year->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->groupBy('branches.zone')
            ->get();


        $data = [];
        $data_last_year = [];
        $data_total = [$month->format('F') => 0.00, $previous_month->format('F') => 0.00, $last_year->format('F') => 0.00];

        foreach ($branches as $branch) {
            $data[$branch->zone] = [$month->format('F') => 0.00, $previous_month->format('F') => 0.00, $last_year->format('F') => 0.00];
        }


        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($branch_wise_principal_outstanding as $bo) {
                $data[$bo->zone][$month->format('F')] = $bo->principle_outstanding;
                $data_total[$month->format('F')] = $data_total[$month->format('F')] + $bo->principle_outstanding;
            }

        } else {
            foreach ($branch_wise_principal_outstanding as $bo) {
                $data[$bo->zone][$month->format('F')] = $bo->branch_outstanding_balance;
                $data_total[$month->format('F')] = $data_total[$month->format('F')] + $bo->branch_outstanding_balance;
            }
        }


        foreach ($principal_outstanding_previous_month as $bo) {
            $data[$bo->zone][$previous_month->format('F')] = $bo->branch_outstanding_balance;
            $data_total[$previous_month->format('F')] = $data_total[$previous_month->format('F')] + $bo->branch_outstanding_balance;
        }


        foreach ($principal_outstanding_last_year as $bo) {
            $data[$bo->zone][$last_year->format('F')] = $bo->branch_outstanding_balance;
            $data_total[$last_year->format('F')] = $data_total[$last_year->format('F')] + $bo->branch_outstanding_balance;
        }

        return view('reports.bankPosition', compact('data', 'data_total', 'last_year', 'previous_month', 'month', 'product_type_id'));
    }

    public function creditGrowth(Request $request)
    {
        $month_date = null;

        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }


        $month = Carbon::parse($month_date);
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();


        $products = Product::all();

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            $product_wise_principal_outstanding = DB::table('customers')
                ->select('customers.branch_id', 'products.product_name', 'product_types.product_type',
                    DB::raw("count(product_types.product_type) as no_of_accounts"),
                    DB::raw("SUM(customers.principle_amount) as principle_amount"))
                ->join('products', 'products.id', '=', 'customers.product_id')
                ->join('product_types', 'product_types.id', '=', 'customers.product_type_id')
                ->groupBy('customers.branch_id', 'products.product_name', 'product_types.product_type')
                ->orderBy('customers.branch_id', 'asc')
                ->get();
        } else {

            $product_wise_principal_outstanding = DB::table('product_wise_monthlies')
                ->select('products.product_name', 'product_types.product_type', 'product_wise_monthlies.no_of_accounts', 'product_wise_monthlies.principle_outstanding')
                ->join('products', 'products.id', '=', 'product_wise_monthlies.product_id')
                ->join('product_types', 'product_types.id', '=', 'product_wise_monthlies.product_type_id')
                ->whereBetween('product_wise_monthlies.created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->get();

        }

        $principal_outstanding_last_year = DB::table('product_wise_monthlies')
            ->select('products.product_name', 'product_types.product_type', 'product_wise_monthlies.no_of_accounts', 'product_wise_monthlies.principle_outstanding')
            ->join('products', 'products.id', '=', 'product_wise_monthlies.product_id')
            ->join('product_types', 'product_types.id', '=', 'product_wise_monthlies.product_type_id')
            ->whereBetween('product_wise_monthlies.created_at', [$last_year->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $last_year->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->get();


        $data = [];
        $data_last_year = [];
        $data_total = [];

        foreach ($products as $product) {
            $data[$product->product_name] = [];
            $data_total[$product->product_name] = [];
            foreach ($product->product_type as $pt) {
                $data[$product->product_name][$pt->product_type] = [$month->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00], $last_year->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00]];
                $data_total[$product->product_name] = [$month->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00], $last_year->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00]];
            }
        }

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['amount'] = $bo->principle_amount;
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['no_of_accounts'] = $bo->no_of_accounts;
            }
        } else {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['amount'] = $bo->principle_outstanding;
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['no_of_accounts'] = $bo->no_of_accounts;
            }
        }

        foreach ($principal_outstanding_last_year as $bo) {
            $data[$bo->product_name][$bo->product_type][$last_year->format('F')]['amount'] = $bo->principle_outstanding;
            $data[$bo->product_name][$bo->product_type][$last_year->format('F')]['no_of_accounts'] = $bo->no_of_accounts;


        }


        foreach ($products as $product) {

            $data_total[$product->product_name][$last_year->format('F')]['amount'] = $principal_outstanding_last_year->where('product_name', $product->product_name)->sum('principle_outstanding');
            $data_total[$product->product_name][$last_year->format('F')]['no_of_accounts'] = $principal_outstanding_last_year->where('product_name', $product->product_name)->sum('no_of_accounts');
            $data_total[$product->product_name][$month->format('F')]['amount'] = $product_wise_principal_outstanding->where('product_name', $product->product_name)->sum('principle_amount');
            $data_total[$product->product_name][$month->format('F')]['no_of_accounts'] = $product_wise_principal_outstanding->where('product_name', $product->product_name)->sum('no_of_accounts');

        }


        return view('reports.creditGrowth', compact('data', 'data_total', 'last_year', 'month'));
    }

    public function outstandingAdvancesProductWise(Request $request)
    {
        $month_date = null;

        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }


        $month = Carbon::parse($month_date);
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();


        $products = Product::all();
        $branches = Branch::all();

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            $product_wise_principal_outstanding = DB::table('customers')
                ->select('customers.branch_id', 'branches.region', 'branches.zone', 'products.product_name', 'product_types.product_type',
                    DB::raw("count(product_types.product_type) as no_of_accounts"),
                    DB::raw("SUM(customers.principle_amount) as principle_amount"))
                ->join('branches', 'customers.branch_id', '=', 'branches.id')
                ->join('products', 'products.id', '=', 'customers.product_id')
                ->join('product_types', 'product_types.id', '=', 'customers.product_type_id')
                ->groupBy('customers.branch_id', 'products.product_name', 'product_types.product_type')
                ->orderBy('customers.branch_id', 'asc')
                ->get();

        } else {

            $product_wise_principal_outstanding = DB::table('product_wise_monthlies')
                ->select('product_wise_monthlies.branch_id', 'branches.region', 'branches.zone', 'products.product_name', 'product_types.product_type', 'product_wise_monthlies.no_of_accounts', 'product_wise_monthlies.principle_outstanding')
                ->join('products', 'products.id', '=', 'product_wise_monthlies.product_id')
                ->join('product_types', 'product_types.id', '=', 'product_wise_monthlies.product_type_id')
                ->join('branches', 'branches.id', '=', 'product_wise_monthlies.branch_id')
                ->whereBetween('product_wise_monthlies.created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->get();

        }


        $data = [];
        $data_last_year = [];
        $data_total = [];

        foreach ($products as $product) {
            $data[$product->product_name] = [];
            $data_total[$product->product_name] = [];
            foreach ($product->product_type as $pt) {
                foreach ($branches as $branch) {
                    $data[$product->product_name][$pt->product_type][$branch->region][$branch->zone] = ['no_of_accounts' => 0, 'amount' => 0.00];
                    $data_total[$product->product_name][$branch->zone] = ['no_of_accounts' => 0, 'amount' => 0.00];
                }

            }
        }


        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->product_name][$bo->product_type][$bo->region][$bo->zone]['amount'] = $bo->principle_amount;
                $data[$bo->product_name][$bo->product_type][$bo->region][$bo->zone]['no_of_accounts'] = $bo->no_of_accounts;


                $data_total[$bo->product_name][$bo->zone]['amount'] = $product_wise_principal_outstanding->where('product_name', $bo->product_name)->where('zone', $bo->zone)->sum('principle_amount');
                $data_total[$bo->product_name][$bo->zone]['no_of_accounts'] = $product_wise_principal_outstanding->where('product_name', $bo->product_name)->where('zone', $bo->zone)->sum('no_of_accounts');


            }
        } else {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->product_name][$bo->product_type][$bo->region][$bo->zone]['amount'] = $bo->principle_outstanding;
                $data[$bo->product_name][$bo->product_type][$bo->region][$bo->zone]['no_of_accounts'] = $bo->no_of_accounts;

                $data_total[$bo->product_name][$bo->zone]['amount'] = $product_wise_principal_outstanding->where('product_name', $bo->product_name)->where('zone', $bo->zone)->sum('principle_outstanding');
                $data_total[$bo->product_name][$bo->zone]['no_of_accounts'] = $product_wise_principal_outstanding->where('product_name', $bo->product_name)->where('zone', $bo->zone)->sum('no_of_accounts');

            }
        }

//        dd($product_wise_principal_outstanding);
        return view('reports.outstandingAdvancesProduceWise', compact('data', 'data_total', 'month'));
    }

    public function branchWisePositionLoans(Request $request)
    {
        $month_date = null;
        $zone_data = null;
        $product_type_id = null;

        if ($request->input('zone')) {
            $zone_data = $request->zone;
        } else {
            $zone_data = 'Muzaffarabad';
        }


        if ($request->input('product_type_id')) {
            $product_type_id = $request->product_type_id;
        } else {
            $product_type_id = 1;
        }


        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }

        $branches = Branch::orderBy('region', 'asc')->get();
//        dd($branches);
        $month = Carbon::parse($month_date);
        $previous_month = Carbon::parse($month_date)->subMonth();
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();

        $products = Product::all();


        $data = [];
        $data_last_year = [];
        $data_total = [];

        foreach ($branches as $branch) {
            $data[$branch->zone][$branch->name] = [$month->format('F') => ['amount' => 0.00], $previous_month->format('F') => ['amount' => 0.00], $last_year->format('F') => ['amount' => 0.00]];
            $data_total[$branch->region][$branch->zone] = [$month->format('F') => ['amount' => 0.00], $previous_month->format('F') => ['amount' => 0.00], $last_year->format('F') => ['amount' => 0.00]];
        }

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {

            $product_wise_principal_outstanding = DB::table('customers')
                ->select('branches.zone', 'branches.name', 'customers.branch_id', DB::raw("SUM(principle_amount) as principle_amount"))
                ->join('branches', 'customers.branch_id', '=', 'branches.id')
                ->groupBy('customers.branch_id')
                ->where('customers.product_type_id', $product_type_id)
                ->orderBy('customers.branch_id', 'asc')
                ->get();

        } else {
            $product_wise_principal_outstanding = DB::table('product_wise_monthlies')
                ->select('branches.zone', 'branches.name', 'product_wise_monthlies.branch_id', DB::raw("SUM(product_wise_monthlies.principle_outstanding) as principle_amount"))
                ->join('branches', 'product_wise_monthlies.branch_id', '=', 'branches.id')
                ->groupBy('product_wise_monthlies.branch_id')
                ->where('product_wise_monthlies.product_type_id', $product_type_id)
                ->whereBetween('product_wise_monthlies.created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->orderBy('product_wise_monthlies.branch_id', 'asc')
                ->get();

        }

        $principal_outstanding_previous_month = DB::table('product_wise_monthlies')
            ->select('branches.zone', 'branches.name', 'product_wise_monthlies.branch_id', DB::raw("SUM(product_wise_monthlies.principle_outstanding) as principle_amount"))
            ->join('branches', 'product_wise_monthlies.branch_id', '=', 'branches.id')
            ->groupBy('product_wise_monthlies.branch_id')
            ->where('product_wise_monthlies.product_type_id', $product_type_id)
            ->whereBetween('product_wise_monthlies.created_at', [$previous_month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $previous_month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->orderBy('product_wise_monthlies.branch_id', 'asc')
            ->get();


        $principal_outstanding_last_year = DB::table('product_wise_monthlies')
            ->select('branches.zone', 'branches.name', 'product_wise_monthlies.branch_id', DB::raw("SUM(product_wise_monthlies.principle_outstanding) as principle_amount"))
            ->join('branches', 'product_wise_monthlies.branch_id', '=', 'branches.id')
            ->groupBy('product_wise_monthlies.branch_id')
            ->where('product_wise_monthlies.product_type_id', $product_type_id)
            ->whereBetween('product_wise_monthlies.created_at', [$last_year->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $last_year->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->orderBy('product_wise_monthlies.branch_id', 'asc')
            ->get();


        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->zone][$bo->name][$month->format('F')]['amount'] = $bo->principle_amount;
            }
        } else {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->zone][$bo->name][$month->format('F')]['amount'] = $bo->principle_amount;
            }
        }

        foreach ($principal_outstanding_previous_month as $bo) {
            $data[$bo->zone][$bo->name][$previous_month->format('F')]['amount'] = $bo->principle_amount;
        }

        foreach ($principal_outstanding_last_year as $bo) {
            $data[$bo->zone][$bo->name][$last_year->format('F')]['amount'] = $bo->principle_amount;
        }
        return view('reports.branchWisePositionLoans', compact('data', 'data_total', 'last_year', 'month', 'previous_month', 'product_type_id'));
    }


    public function creditGrowthPercentageShare(Request $request)
    {

        $month_date = null;
        $total_share = 0.00;

        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }


        $month = Carbon::parse($month_date);
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();
        $products = Product::all();


        $data = [];
        $data_last_year = [];
        $data_total = [$month->format('F') => 0.00, $last_year->format('F') => 0.00];

        foreach ($products as $product) {
            foreach ($product->product_type as $pt) {
                $data[$pt->product_type] = ['amount' => 0.00];
            }
        }

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            $product_wise_principal_outstanding = DB::table('customers')
                ->select('product_types.product_type', DB::raw("SUM(principle_amount) as principle_amount"))
                ->join('product_types', 'customers.product_type_id', '=', 'product_types.id')
                ->groupBy('customers.product_type_id')
                ->get();

            $total_share = $product_wise_principal_outstanding->sum('principle_amount');

        } else {
            $product_wise_principal_outstanding = DB::table('product_wise_monthlies')
                ->select('product_types.product_type', DB::raw("SUM(product_wise_monthlies.principle_outstanding) as principle_amount"))
                ->join('product_types', 'product_wise_monthlies.product_type_id', '=', 'product_types.id')
                ->groupBy('product_wise_monthlies.product_type_id')
                ->whereBetween('product_wise_monthlies.created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->orderBy('product_wise_monthlies.product_type_id', 'asc')
                ->get();
            $total_share = $product_wise_principal_outstanding->sum('principle_amount');

        }

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->product_type]['amount'] = $bo->principle_amount;
            }
        } else {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->product_type]['amount'] = $bo->principle_amount;
            }
        }


        return view('reports.creditGrowthPercentage', compact('data', 'month', 'total_share'));
    }


    public function branchWiseNplPosition(Request $request)
    {

        $month_date = null;
        $zone_data = null;
        $product_type_id = null;

        if ($request->input('product_type_id')) {
            $product_type_id = $request->product_type_id;
        } else {
            $product_type_id = 1;
        }


        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }

        $branches = Branch::orderBy('region', 'asc')->get();
//        dd($branches);
        $month = Carbon::parse($month_date);
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();

        $products = Product::all();


        $data = [];
        $data_last_year = [];
        $data_total = [];

        foreach ($branches as $branch) {
            $data[$branch->region][$branch->zone][$branch->name] = [$month->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00], $last_year->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00]];
            $data_total[$branch->region][$branch->zone] = [$month->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00], $last_year->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00]];
        }


        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {

            $product_wise_principal_outstanding = DB::table('customers')
                ->select('branches.region', 'branches.zone', 'branches.name', 'customers.branch_id', 'customers.product_id', 'customers.product_type_id',
                    DB::raw("COUNT(customers.id) as no_of_accounts"), DB::raw("SUM(customers.principle_amount) as principle_amount"))
                ->join('branches', 'customers.branch_id', '=', 'branches.id')
                ->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])
                ->where('customers.status', '=', 1)
                ->groupBy('customers.branch_id')
                ->orderBy('customers.branch_id', 'asc')
                ->get();

        } else {
            $product_wise_principal_outstanding = DB::table('product_wise_npl_monthlies')
                ->select('branches.region', 'branches.zone', 'branches.name', 'product_wise_npl_monthlies.branch_id', 'product_wise_npl_monthlies.product_id', 'product_wise_npl_monthlies.product_type_id',
                    DB::raw("COUNT(product_wise_npl_monthlies.id) as no_of_accounts"), DB::raw("SUM(product_wise_npl_monthlies.principle_outstanding) as principle_amount"))
                ->join('branches', 'product_wise_npl_monthlies.branch_id', '=', 'branches.id')
                ->groupBy('product_wise_npl_monthlies.branch_id')
                ->whereBetween('product_wise_npl_monthlies.created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->orderBy('product_wise_npl_monthlies.branch_id', 'asc')
                ->get();

        }

        $principal_outstanding_last_year = DB::table('product_wise_npl_monthlies')
            ->select('branches.region', 'branches.zone', 'branches.name', 'product_wise_npl_monthlies.branch_id', 'product_wise_npl_monthlies.product_id', 'product_wise_npl_monthlies.product_type_id',
                DB::raw("COUNT(product_wise_npl_monthlies.id) as no_of_accounts"), DB::raw("SUM(product_wise_npl_monthlies.principle_outstanding) as principle_amount"))
            ->join('branches', 'product_wise_npl_monthlies.branch_id', '=', 'branches.id')
            ->groupBy('product_wise_npl_monthlies.branch_id')
            ->whereBetween('product_wise_npl_monthlies.created_at', [$last_year->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $last_year->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->orderBy('product_wise_npl_monthlies.branch_id', 'asc')
            ->get();


//        dd($product_wise_principal_outstanding);

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->region][$bo->zone][$bo->name][$month->format('F')]['amount'] = $bo->principle_amount;
                $data[$bo->region][$bo->zone][$bo->name][$month->format('F')]['no_of_accounts'] = $bo->no_of_accounts;

                $data_total[$bo->region][$bo->zone][$month->format('F')]['amount'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('principle_amount');
                $data_total[$bo->region][$bo->zone][$month->format('F')]['no_of_accounts'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('no_of_accounts');

            }
        } else {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->region][$bo->zone][$bo->name][$month->format('F')]['amount'] = $bo->principle_amount;
                $data[$bo->region][$bo->zone][$bo->name][$month->format('F')]['no_of_accounts'] = $bo->no_of_accounts;


                $data_total[$bo->region][$bo->zone][$month->format('F')]['amount'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('principle_amount');
                $data_total[$bo->region][$bo->zone][$month->format('F')]['no_of_accounts'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('no_of_accounts');
            }
        }

        foreach ($principal_outstanding_last_year as $bo) {
            $data[$bo->region][$bo->zone][$bo->name][$last_year->format('F')]['amount'] = $bo->principle_amount;
            $data[$bo->region][$bo->zone][$bo->name][$last_year->format('F')]['no_of_accounts'] = $bo->no_of_accounts;


            $data_total[$bo->region][$bo->zone][$last_year->format('F')]['amount'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('principle_amount');
            $data_total[$bo->region][$bo->zone][$last_year->format('F')]['no_of_accounts'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('no_of_accounts');
        }

        return view('reports.branchWiseNPLPosition', compact('data', 'month', 'last_year', 'data_total'));

    }


    public function branchWiseNplToAdvances(Request $request)

    {
        $month_date = null;
        $zone_data = null;
        $product_type_id = null;

        if ($request->input('product_type_id')) {
            $product_type_id = $request->product_type_id;
        } else {
            $product_type_id = 1;
        }


        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }

        $branches = Branch::orderBy('region', 'asc')->get();
//        dd($branches);
        $month = Carbon::parse($month_date);
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();

        $products = Product::all();


        $data = [];
        $data_last_year = [];
        $data_total = [];

        foreach ($branches as $branch) {
            $data[$branch->region][$branch->zone][$branch->name] = [$month->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00], $last_year->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00]];
            $data_total[$branch->region][$branch->zone] = [$month->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00], $last_year->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00]];
        }


        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {

            $product_wise_principal_outstanding =
                DB::table('customers')
                    ->select('branches.region', 'branches.zone', 'branches.name', 'customers.branch_id', 'customers.product_id',
                        'customers.product_type_id', DB::raw("SUM(IF(customers.customer_status != 'Regular', 1, 0)
                         and IF(customers.customer_status != 'Irregular', 1, 0)) as no_of_accounts"),
                        DB::raw("SUM(customers.principle_amount) as principle_amount"))
                    ->join('branches', 'customers.branch_id', '=', 'branches.id')
                    ->where('customers.status', '=', 1)
                    ->groupBy('customers.branch_id')
                    ->orderBy('customers.branch_id', 'asc')
                    ->get();


        } else {
            $product_wise_principal_outstanding = DB::table('product_wise_npl_advances')
                ->select('branches.region', 'branches.zone', 'branches.name', 'product_wise_npl_advances.branch_id', 'product_wise_npl_advances.product_id', 'product_wise_npl_advances.product_type_id',
                    DB::raw("COUNT(product_wise_npl_advances.id) as no_of_accounts"), DB::raw("SUM(product_wise_npl_advances.principle_outstanding) as principle_amount"))
                ->join('branches', 'product_wise_npl_advances.branch_id', '=', 'branches.id')
                ->groupBy('product_wise_npl_advances.branch_id')
                ->whereBetween('product_wise_npl_advances.created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->orderBy('product_wise_npl_advances.branch_id', 'asc')
                ->get();

        }

        $principal_outstanding_last_year = DB::table('product_wise_npl_advances')
            ->select('branches.region', 'branches.zone', 'branches.name', 'product_wise_npl_advances.branch_id', 'product_wise_npl_advances.product_id', 'product_wise_npl_advances.product_type_id',
                DB::raw("SUM(product_wise_npl_advances.no_of_accounts) as no_of_accounts"), DB::raw("SUM(product_wise_npl_advances.principle_outstanding) as principle_amount"))
            ->join('branches', 'product_wise_npl_advances.branch_id', '=', 'branches.id')
            ->groupBy('product_wise_npl_advances.branch_id')
            ->whereBetween('product_wise_npl_advances.created_at', [$last_year->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $last_year->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
            ->orderBy('product_wise_npl_advances.branch_id', 'asc')
            ->get();

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->region][$bo->zone][$bo->name][$month->format('F')]['amount'] = $bo->principle_amount;
                $data[$bo->region][$bo->zone][$bo->name][$month->format('F')]['no_of_accounts'] = $bo->no_of_accounts;

                $data_total[$bo->region][$bo->zone][$month->format('F')]['amount'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('principle_amount');
                $data_total[$bo->region][$bo->zone][$month->format('F')]['no_of_accounts'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('no_of_accounts');

            }
        } else {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->region][$bo->zone][$bo->name][$month->format('F')]['amount'] = $bo->principle_amount;
                $data[$bo->region][$bo->zone][$bo->name][$month->format('F')]['no_of_accounts'] = $bo->no_of_accounts;


                $data_total[$bo->region][$bo->zone][$month->format('F')]['amount'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('principle_amount');
                $data_total[$bo->region][$bo->zone][$month->format('F')]['no_of_accounts'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('no_of_accounts');
            }
        }

        foreach ($principal_outstanding_last_year as $bo) {
            $data[$bo->region][$bo->zone][$bo->name][$last_year->format('F')]['amount'] = $bo->principle_amount;
            $data[$bo->region][$bo->zone][$bo->name][$last_year->format('F')]['no_of_accounts'] = $bo->no_of_accounts;


            $data_total[$bo->region][$bo->zone][$last_year->format('F')]['amount'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('principle_amount');
            $data_total[$bo->region][$bo->zone][$last_year->format('F')]['no_of_accounts'] = $product_wise_principal_outstanding->where('region', $bo->region)->where('zone', $bo->zone)->sum('no_of_accounts');
        }

        return view('reports.branchWiseNPLToAdvances', compact('data', 'month', 'last_year', 'data_total', 'product_type_id'));

    }

    public function productWiseNplToAdvances(Request $request)

    {
        $month_date = null;
        $zone_data = null;
        $product_type_id = null;

        if ($request->input('product_type_id')) {
            $product_type_id = $request->product_type_id;
        } else {
            $product_type_id = 1;
        }


        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }

        $branches = Branch::orderBy('region', 'asc')->get();
//        dd($branches);
        $month = Carbon::parse($month_date);
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();

        $products = Product::all();


        $data = [];
        $data_last_year = [];
        $data_total = [];

        foreach ($products as $product) {
            $data[$product->product_name] = [];
            $data_total[$product->product_name] = [];
            foreach ($product->product_type as $pt) {
                $data[$product->product_name][$pt->product_type] = [$month->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00], $last_year->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00]];
            }
        }


        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {


            $product_wise_principal_outstanding =
                DB::table('customers')
                    ->select('branches.region', 'branches.zone', 'branches.name', 'customers.branch_id',
                        'products.product_name', 'product_types.product_type', 'customers.product_id',
                        'customers.product_type_id', DB::raw("SUM(IF(customers.customer_status != 'Regular', 1, 0)
                         and IF(customers.customer_status != 'Irregular', 1, 0)) as no_of_accounts"),
                        DB::raw("SUM(customers.principle_amount) as principle_amount"))
                    ->join('branches', 'customers.branch_id', '=', 'branches.id')
                    ->join('products', 'products.id', '=', 'customers.product_id')
                    ->join('product_types', 'product_types.id', '=', 'customers.product_type_id')
                    ->where('customers.status', '=', 1)
                    ->groupBy('customers.product_id', 'customers.product_type_id')
                    ->orderBy('customers.branch_id', 'asc')
                    ->get();

        } else {
            $product_wise_principal_outstanding = DB::table('product_wise_npl_advances')
                ->select('products.product_name', 'product_types.product_type', 'product_wise_npl_advances.no_of_accounts', 'product_wise_npl_advances.principle_outstanding')
                ->join('products', 'products.id', '=', 'product_wise_npl_advances.product_id')
                ->join('product_types', 'product_types.id', '=', 'product_wise_npl_advances.product_type_id')
                ->whereBetween('product_wise_npl_advances.created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->groupBy('product_wise_npl_advances.product_id', 'product_wise_npl_advances.product_type_id')
                ->orderBy('product_wise_npl_advances.branch_id', 'asc')
                ->get();
        }


        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['amount'] = $bo->principle_amount;
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['no_of_accounts'] = $bo->no_of_accounts;
            }
        } else {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['amount'] = $bo->principle_outstanding;
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['no_of_accounts'] = $bo->no_of_accounts;
            }
        }

        foreach ($products as $product) {
            $data_total[$product->product_name][$month->format('F')]['amount'] = $product_wise_principal_outstanding->where('product_name', $product->product_name)->sum('principle_outstanding');
            $data_total[$product->product_name][$month->format('F')]['no_of_accounts'] = $product_wise_principal_outstanding->where('product_name', $product->product_name)->sum('no_of_accounts');
        }

//        dd($product_wise_principal_outstanding);

        return view('reports.productWiseNplToAdvances', compact('data', 'data_total', 'last_year', 'month'));
    }


    public function productWiseContributionInTotalPortfolio(Request $request)

    {
        $month_date = null;
        $zone_data = null;
        $product_type_id = null;

        if ($request->input('product_type_id')) {
            $product_type_id = $request->product_type_id;
        } else {
            $product_type_id = 1;
        }


        if ($request->input('month')) {
            $month_date = Carbon::parse($request->month);
        } else {
            $month_date = Carbon::now();
        }

        $branches = Branch::orderBy('region', 'asc')->get();
//        dd($branches);
        $month = Carbon::parse($month_date);
        $last_year = Carbon::parse($month_date)->startOfYear()->subMonth();

        $products = Product::all();


        $data = [];
        $data_last_year = [];
        $data_total = [];

        foreach ($products as $product) {
            $data[$product->product_name] = [];
            $data_total[$product->product_name] = [];
            foreach ($product->product_type as $pt) {
                $data[$product->product_name][$pt->product_type] = [$month->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00], $last_year->format('F') => ['no_of_accounts' => 0, 'amount' => 0.00]];
            }
        }


        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            $product_wise_principal_outstanding = DB::table('customers')
                ->select('customers.branch_id', 'products.product_name', 'product_types.product_type',
                    DB::raw("count(product_types.product_type) as no_of_accounts"),
                    DB::raw("SUM(customers.principle_amount) as principle_amount"))
                ->join('products', 'products.id', '=', 'customers.product_id')
                ->join('product_types', 'product_types.id', '=', 'customers.product_type_id')
                ->groupBy('customers.branch_id', 'products.product_name', 'product_types.product_type')
                ->orderBy('customers.branch_id', 'asc')
                ->get();

        } else {
            $product_wise_principal_outstanding = DB::table('product_wise_monthlies')
                ->select('products.product_name', 'product_types.product_type', 'product_wise_monthlies.no_of_accounts', 'product_wise_monthlies.principle_outstanding')
                ->join('products', 'products.id', '=', 'product_wise_monthlies.product_id')
                ->join('product_types', 'product_types.id', '=', 'product_wise_monthlies.product_type_id')
                ->whereBetween('product_wise_monthlies.created_at', [$month->startOfMonth()->format('Y-m-d') . ' 00:00:00.000000', $month->endOfMonth()->format('Y-m-d') . ' 23:59:59.000000'])
                ->get();
        }

        if ($month_date->format('Y-m') == Carbon::now()->format('Y-m')) {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['amount'] = $bo->principle_amount;
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['no_of_accounts'] = $bo->no_of_accounts;
            }
        } else {
            foreach ($product_wise_principal_outstanding as $bo) {
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['amount'] = $bo->principle_outstanding;
                $data[$bo->product_name][$bo->product_type][$month->format('F')]['no_of_accounts'] = $bo->no_of_accounts;
            }
        }

        foreach ($products as $product) {
            $data_total[$product->product_name][$month->format('F')]['amount'] = $product_wise_principal_outstanding->where('product_name', $product->product_name)->sum('principle_outstanding');
            $data_total[$product->product_name][$month->format('F')]['no_of_accounts'] = $product_wise_principal_outstanding->where('product_name', $product->product_name)->sum('no_of_accounts');
        }

        return view('reports.productWiseContributionInTotalPortfolio', compact('data', 'data_total', 'last_year', 'month'));
    }
}
