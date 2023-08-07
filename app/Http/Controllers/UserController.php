<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:Full Access')->only('create');
        $this->middleware('permission:Full Access')->only('index');
        $this->middleware('permission:Full Access')->only('store');
        $this->middleware('permission:Full Access')->only('edit');
        $this->middleware('permission:Full Access')->only('update');
    }

    public function index()
    {
        $users = QueryBuilder::for(User::with('branch','roles'))
            ->allowedFilters([
                AllowedFilter::scope('search_string'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('branch_id')
            ])->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'designation' => 'required',
            'status' => 'required',
            'role' => 'required',
        ]);


        $role = Role::where('name',$request->role)->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'branch_id' => $request->branch_id,
            'designation' => $request->designation,
            'status' => $request->status,
        ]);
        $user->assignRole($role);

        Artisan::call('permission:cache-reset');

        return to_route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required',
            'designation' => 'required',
            'status' => 'required',
            'role' => 'required',
        ]);


        $user->roles()->detach();
        $role = Role::where('name',$request->role)->first();
        $user->assignRole($role);

        $user->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'branch_id' => $request->branch_id,
            'designation' => $request->designation,
            'status' => $request->status,
        ]);
        Artisan::call('permission:cache-reset');
        session()->flash('message', 'User has been successfully updated...');
        return to_route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
