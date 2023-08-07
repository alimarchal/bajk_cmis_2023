<?php

namespace App\Console;

use App\Models\BranchOutstanding;
use App\Models\BranchOutstandingDaily;
use App\Models\Insurance;
use App\Models\ProductWiseDaily;
use App\Models\ProductWiseMonthly;
use App\Models\ProductWiseNplAdvance;
use App\Models\ProductWiseNplMonthly;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('hello:world')->everyFiveMinutes();
        $schedule->call(function () {
            // Daily Process Branches
            DB::beginTransaction();
            try {
                $branches_ids = DB::table('customers')
                    ->select('branch_id', 'principle_amount', DB::raw("SUM(principle_amount) as principle_amount"))
                    ->groupBy('branch_id')
                    ->pluck('branch_id')->toArray();
                $branch_outstanding_today = BranchOutstandingDaily::whereDate('created_at', Carbon::today())->get();

                if ($branch_outstanding_today->isNotEmpty()) {
                    $collection = DB::table('customers')
                        ->select('branch_id', 'principle_amount', DB::raw("SUM(principle_amount) as principle_amount"))
                        ->groupBy('branch_id')
                        ->get();
                    foreach ($branches_ids as $key) {
                        if ($branch_outstanding_today->where('branch_id', $key)->first()) {
                            $item = $collection->where('branch_id', $key)->first();
                            $record = $branch_outstanding_today->where('branch_id', $key)->first();
                            $record->branch_id = $item->branch_id;
                            $record->principle_outstanding = $item->principle_amount;
                            $record->save();
                        } else {
                            $item = $collection->where('branch_id', $key)->first();
                            BranchOutstandingDaily::create([
                                'branch_id' => $item->branch_id,
                                'principle_outstanding' => $item->principle_amount,
                            ]);
                        }
                    }
                } else {
                    $collection = DB::table('customers')
                        ->select('branch_id', 'principle_amount', DB::raw("SUM(principle_amount) as principle_amount"))
                        ->groupBy('branch_id')
                        ->get();
                    foreach ($collection as $item) {
                        BranchOutstandingDaily::create([
                            'branch_id' => $item->branch_id,
                            'principle_outstanding' => $item->principle_amount,
                        ]);
                    }
                }
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
            }

            // Monthly Process Branches
            try {
                $branches_ids = DB::table('customers')
                    ->select('branch_id', 'principle_amount', DB::raw("SUM(principle_amount) as principle_amount"))
                    ->groupBy('branch_id')
                    ->pluck('branch_id')->toArray();

                // This is monthly outstanding of all branches check and update weather record exist or not
                $branch_outstanding_monthly = BranchOutstanding::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

                if ($branch_outstanding_monthly->isNotEmpty()) {

                    $collection = DB::table('customers')
                        ->select('branch_id', 'principle_amount', DB::raw("SUM(principle_amount) as principle_amount"))
                        ->groupBy('branch_id')
                        ->get();

                    foreach ($branches_ids as $key) {
                        if ($branch_outstanding_monthly->where('branch_id', $key)->first()) {
                            $item = $collection->where('branch_id', $key)->first();
                            $record = $branch_outstanding_monthly->where('branch_id', $key)->first();
                            $record->branch_id = $item->branch_id;
                            $record->principle_outstanding = $item->principle_amount;
                            $record->save();
                        } else {
                            $item = $collection->where('branch_id', $key)->first();
                            BranchOutstanding::create([
                                'branch_id' => $item->branch_id,
                                'principle_outstanding' => $item->principle_amount,
                            ]);
                        }
                    }
                } else {
                    $collection = DB::table('customers')
                        ->select('branch_id', 'principle_amount', DB::raw("SUM(principle_amount) as principle_amount"))
                        ->groupBy('branch_id')
                        ->get();

                    foreach ($collection as $item) {
                        BranchOutstanding::create([
                            'branch_id' => $item->branch_id,
                            'principle_outstanding' => $item->principle_amount,
                        ]);
                    }
                }
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
            }

            // Daily Process Product Wise
            DB::beginTransaction();
            try {

                $branch_outstanding_today = ProductWiseDaily::whereDate('created_at', Carbon::today())->get();

                if ($branch_outstanding_today->isNotEmpty()) {

                    $collection = DB::table('customers')
                        ->select('customers.branch_id', 'customers.product_id', 'customers.product_type_id',
                            DB::raw("COUNT(product_types.product_type) as no_of_accounts"),
                            DB::raw("SUM(customers.principle_amount) as principle_outstanding"))
                        ->join('products', 'products.id', '=', 'customers.product_id')
                        ->join('product_types', 'product_types.id', '=', 'customers.product_type_id')
                        ->groupBy('customers.branch_id', 'products.product_name', 'product_types.product_type')
                        ->get();

                    foreach ($collection as $item) {

                        $data_from_table = $branch_outstanding_today->where('branch_id', $item->branch_id)->where('product_id', $item->product_id)->where('product_type_id', $item->product_type_id)->first();

                        if (!empty($data_from_table)) {
                            $data_from_table->branch_id = $item->branch_id;
                            $data_from_table->product_id = $item->product_id;
                            $data_from_table->product_type_id = $item->product_type_id;
                            $data_from_table->no_of_accounts = $item->no_of_accounts;
                            $data_from_table->principle_outstanding = $item->principle_outstanding;
                            $data_from_table->save();

                        } else {
                            ProductWiseDaily::create([
                                'branch_id' => $item->branch_id,
                                'product_id' => $item->product_id,
                                'product_type_id' => $item->product_type_id,
                                'no_of_accounts' => $item->no_of_accounts,
                                'principle_outstanding' => $item->principle_outstanding,
                            ]);
                        }
                    }
                } else {
                    $collection = DB::table('customers')
                        ->select('customers.branch_id', 'customers.product_id', 'customers.product_type_id',
                            DB::raw("COUNT(product_types.product_type) as no_of_accounts"),
                            DB::raw("SUM(customers.principle_amount) as principle_outstanding"))
                        ->join('products', 'products.id', '=', 'customers.product_id')
                        ->join('product_types', 'product_types.id', '=', 'customers.product_type_id')
                        ->groupBy('customers.branch_id', 'products.product_name', 'product_types.product_type')
                        ->get();
                    foreach ($collection as $item) {
                        ProductWiseDaily::create([
                            'branch_id' => $item->branch_id,
                            'product_id' => $item->product_id,
                            'product_type_id' => $item->product_type_id,
                            'no_of_accounts' => $item->no_of_accounts,
                            'principle_outstanding' => $item->principle_outstanding,
                        ]);
                    }
                }
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
            }

            // Monthly Process Product Wise

            DB::beginTransaction();
            try {

                $branch_outstanding_today = ProductWiseMonthly::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

                if ($branch_outstanding_today->isNotEmpty()) {

                    $collection = DB::table('customers')
                        ->select('customers.branch_id', 'customers.product_id', 'customers.product_type_id',
                            DB::raw("COUNT(product_types.product_type) as no_of_accounts"),
                            DB::raw("SUM(customers.principle_amount) as principle_outstanding"))
                        ->join('products', 'products.id', '=', 'customers.product_id')
                        ->join('product_types', 'product_types.id', '=', 'customers.product_type_id')
                        ->groupBy('customers.branch_id', 'products.product_name', 'product_types.product_type')
                        ->get();

                    foreach ($collection as $item) {

                        $data_from_table = $branch_outstanding_today->where('branch_id', $item->branch_id)->where('product_id', $item->product_id)->where('product_type_id', $item->product_type_id)->first();

                        if (!empty($data_from_table)) {
                            $data_from_table->branch_id = $item->branch_id;
                            $data_from_table->product_id = $item->product_id;
                            $data_from_table->product_type_id = $item->product_type_id;
                            $data_from_table->no_of_accounts = $item->no_of_accounts;
                            $data_from_table->principle_outstanding = $item->principle_outstanding;
                            $data_from_table->save();

                        } else {
                            ProductWiseMonthly::create([
                                'branch_id' => $item->branch_id,
                                'product_id' => $item->product_id,
                                'product_type_id' => $item->product_type_id,
                                'no_of_accounts' => $item->no_of_accounts,
                                'principle_outstanding' => $item->principle_outstanding,
                            ]);
                        }
                    }
                } else {
                    $collection = DB::table('customers')
                        ->select('customers.branch_id', 'customers.product_id', 'customers.product_type_id',
                            DB::raw("COUNT(product_types.product_type) as no_of_accounts"),
                            DB::raw("SUM(customers.principle_amount) as principle_outstanding"))
                        ->join('products', 'products.id', '=', 'customers.product_id')
                        ->join('product_types', 'product_types.id', '=', 'customers.product_type_id')
                        ->groupBy('customers.branch_id', 'products.product_name', 'product_types.product_type')
                        ->get();
                    foreach ($collection as $item) {
                        ProductWiseMonthly::create([
                            'branch_id' => $item->branch_id,
                            'product_id' => $item->product_id,
                            'product_type_id' => $item->product_type_id,
                            'no_of_accounts' => $item->no_of_accounts,
                            'principle_outstanding' => $item->principle_outstanding,
                        ]);
                    }
                }
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
            }


            // Product Wise Monthly NPL
            DB::beginTransaction();
            try {

                $branch_outstanding_today = ProductWiseNplMonthly::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

                if ($branch_outstanding_today->isNotEmpty()) {
                    $collection = DB::table('customers')
                        ->select('branches.region', 'branches.zone', 'branches.name', 'customers.branch_id', 'customers.product_id', 'customers.product_type_id',
                            DB::raw("COUNT(customers.id) as no_of_accounts"),
                            DB::raw("SUM(customers.principle_amount) as principle_amount"))
                        ->join('branches', 'customers.branch_id', '=', 'branches.id')
                        ->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])
                        ->where('customers.status', '=', 1)
                        ->groupBy('customers.branch_id', 'customers.product_id', 'customers.product_type_id')
                        ->get();


                    $ids = $branch_outstanding_today->pluck('id')->toArray();
                    $collection_ids = [];

                    foreach ($collection as $item) {
                        $data_from_table = $branch_outstanding_today->where('branch_id', $item->branch_id)->where('product_id', $item->product_id)->where('product_type_id', $item->product_type_id)->first();

                        if (!empty($data_from_table)) {
                            $collection_ids[] = $data_from_table->id;
                        }

                        if (!empty($data_from_table)) {
                            $data_from_table->branch_id = $item->branch_id;
                            $data_from_table->product_id = $item->product_id;
                            $data_from_table->product_type_id = $item->product_type_id;
                            $data_from_table->no_of_accounts = $item->no_of_accounts;
                            $data_from_table->principle_outstanding = $item->principle_amount;
                            $data_from_table->save();
                        } else {
                            ProductWiseNplMonthly::create([
                                'branch_id' => $item->branch_id,
                                'product_id' => $item->product_id,
                                'product_type_id' => $item->product_type_id,
                                'no_of_accounts' => $item->no_of_accounts,
                                'principle_outstanding' => $item->principle_amount,
                            ]);
                        }


                    }

                    $different_id = array_diff($ids, $collection_ids);
                    if (!empty($different_id)) {
                        foreach ($different_id as $unique_id) {
                            $item_npl = ProductWiseNplMonthly::find($unique_id)->delete();
                        }
                    }

                } else {
                    $collection = DB::table('customers')
                        ->select('branches.region', 'branches.zone', 'branches.name', 'customers.branch_id', 'customers.product_id', 'customers.product_type_id',
                            DB::raw("COUNT(customers.id) as no_of_accounts"),
                            DB::raw("SUM(customers.principle_amount) as principle_amount"))
                        ->join('branches', 'customers.branch_id', '=', 'branches.id')
                        ->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])
                        ->where('customers.status', '=', 1)
                        ->groupBy('customers.branch_id', 'customers.product_id', 'customers.product_type_id')
                        ->get();

                    foreach ($collection as $item) {
                        ProductWiseNplMonthly::create([
                            'branch_id' => $item->branch_id,
                            'product_id' => $item->product_id,
                            'product_type_id' => $item->product_type_id,
                            'no_of_accounts' => $item->no_of_accounts,
                            'principle_outstanding' => $item->principle_amount,
                        ]);
                    }
                }
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
            }


            // Product Wise NPL to Advances
            DB::beginTransaction();
            try {

                $branch_outstanding_today = ProductWiseNplAdvance::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();


                if ($branch_outstanding_today->isNotEmpty()) {
                    $collection =  DB::table('customers')
                        ->select('branches.region', 'branches.zone', 'branches.name', 'customers.branch_id', 'customers.product_id',
                            'customers.product_type_id', DB::raw("SUM(IF(customers.customer_status != 'Regular', 1, 0)
                         and IF(customers.customer_status != 'Irregular', 1, 0)) as no_of_accounts"),
                            DB::raw("SUM(customers.principle_amount) as principle_amount"))
                        ->join('branches', 'customers.branch_id', '=', 'branches.id')
                        ->where('customers.status', '=', 1)
                        ->groupBy('customers.branch_id','customers.product_id','customers.product_type_id')
                        ->orderBy('customers.branch_id', 'asc')
                        ->get();


                    $ids = $branch_outstanding_today->pluck('id')->toArray();
                    $collection_ids = [];

                    foreach ($collection as $item) {
                        $data_from_table = $branch_outstanding_today->where('branch_id', $item->branch_id)->where('product_id', $item->product_id)->where('product_type_id', $item->product_type_id)->first();

                        if (!empty($data_from_table)) {
                            $collection_ids[] = $data_from_table->id;
                        }

                        if (!empty($data_from_table)) {
                            $data_from_table->branch_id = $item->branch_id;
                            $data_from_table->product_id = $item->product_id;
                            $data_from_table->product_type_id = $item->product_type_id;
                            $data_from_table->no_of_accounts = $item->no_of_accounts;
                            $data_from_table->principle_outstanding = $item->principle_amount;
                            $data_from_table->save();
                        } else {
                            ProductWiseNplAdvance::create([
                                'branch_id' => $item->branch_id,
                                'product_id' => $item->product_id,
                                'product_type_id' => $item->product_type_id,
                                'no_of_accounts' => $item->no_of_accounts,
                                'principle_outstanding' => $item->principle_amount,
                            ]);
                        }


                    }

                    $different_id = array_diff($ids, $collection_ids);
                    if (!empty($different_id)) {
                        foreach ($different_id as $unique_id) {
                            $item_npl = ProductWiseNplAdvance::find($unique_id)->delete();
                        }
                    }

                } else {
                    $collection = DB::table('customers')
                        ->select('branches.region', 'branches.zone', 'branches.name', 'customers.branch_id', 'customers.product_id',
                            'customers.product_type_id', DB::raw("SUM(IF(customers.customer_status != 'Regular', 1, 0)
                         and IF(customers.customer_status != 'Irregular', 1, 0)) as no_of_accounts"),
                            DB::raw("SUM(customers.principle_amount) as principle_amount"))
                        ->join('branches', 'customers.branch_id', '=', 'branches.id')
                        ->where('customers.status', '=', 1)
                        ->groupBy('customers.branch_id','customers.product_id','customers.product_type_id')
                        ->orderBy('customers.branch_id', 'asc')
                        ->get();

                    foreach ($collection as $item) {
                        ProductWiseNplAdvance::create([
                            'branch_id' => $item->branch_id,
                            'product_id' => $item->product_id,
                            'product_type_id' => $item->product_type_id,
                            'no_of_accounts' => $item->no_of_accounts,
                            'principle_outstanding' => $item->principle_amount,
                        ]);
                    }
                }
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
            }


        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
