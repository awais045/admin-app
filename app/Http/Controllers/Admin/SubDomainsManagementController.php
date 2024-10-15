<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\SubDomain;
use App\Models\User;
use BalajiDharma\LaravelAdminCore\Actions\User\UserCreateAction;
use BalajiDharma\LaravelAdminCore\Actions\User\UserUpdateAction;
use BalajiDharma\LaravelAdminCore\Data\User\UserCreateData;
use BalajiDharma\LaravelAdminCore\Data\User\UserUpdateData;
use BalajiDharma\LaravelFormBuilder\FormBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Client\Request as MyRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubDomainsManagementController extends Controller
{
    protected $title = 'Users';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('adminViewAny', SubDomain::class);
        $users = (new SubDomain)->newQuery();

        if (request()->has('search')) {
            $users->where('name', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $sort_order = 'ASC';
            if (strncmp($attribute, '-', 1) === 0) {
                $sort_order = 'DESC';
                $attribute = substr($attribute, 1);
            }
            $users->orderBy($attribute, $sort_order);
        } else {
            $users->latest();
        }

        $users = $users->paginate(config('admin.paginate.per_page'))
            ->onEachSide(config('admin.paginate.each_side'));
        // dd($users);
        return view('admin.sub-domains.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(FormBuilder $formBuilder)
    {
        $this->authorize('adminCreate', User::class);
        $form = $formBuilder->create(\App\Forms\Admin\SubDomainForm::class, [
            'method' => 'POST',
            'url' => route('admin.sub-domains.store'),
        ]);
        $title = $this->title;

        return view('admin.form.edit', compact('form', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'domain_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9]+$/',
            ],
            'db_name' => 'required|string|max:255',
            'hostname' => $request->db_type === 'remote' ? 'required|string|max:255' : 'nullable',
            'db_user' => $request->db_type === 'remote' ? 'required|string|max:255' : 'nullable',
            'db_password' => $request->db_type === 'remote' ? 'required|string|max:255' : 'nullable',
            'subdomain_type' => 'required',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.sub-domains.create')
            ->with('message', $validator->errors());
            // return response()->json(['errors' => $validator->errors()], 422);
        }

        // $this->authorize('adminCreate', User::class);
        // $userCreateAction->handle($data);

        // $user = SubDomain::create([
        //     'subdomain' => $request->subdomain,
        //     'domain_name' => $request->domain_name,
        //     'db_name' => $request->db_name,
        //     'is_active' => $request->is_active,
        //     'name' => $request->name,
        // ]);
        DB::beginTransaction();

        $user = SubDomain::create([
            'subdomain' => $request->subdomain,
            'domain_name' => $request->domain_name,
            'db_name' => $request->db_name,
            'hostname' => $request->hostname,       // New field
            'domain_dns1' => $request->domain_dns1,       // New field
            'domain_dns2' => $request->domain_dns2,       // New field
            'db_user' => $request->db_user,         // New field
            'db_password' => $request->db_password, // New field
            'subdomain_type' => $request->subdomain_type, // New field for DNS1/DNS2
            'is_active' => $request->is_active,
            'name' => $request->name,
        ]);

        $insertedId = $user->id;
        $url = 'https://vwrjauqquwby2lasyumga4x6ki0jyrfh.lambda-url.us-west-1.on.aws/';
        // $url = 'https://vwrjauqquwby2sdsadsadalasyumga4x6ki0jyrfh.lambda-ad.us-wesdasdt-1.on.aws/';
        $data = [
            "database_name" => $request->db_name,
            "email" => "super_admin@gmail.com",
            "debug" => false
        ];
        $data = [
            'database_name' => $request->db_name,
            'email' => 'super_admin@gmail.com',
            'debug' => 'False', // Use single quotes for string values
        ];
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://vwrjauqquwby2sdsadsadalasyumga4x6ki0jyrfh.lambda-ad.us-wesdasdt-1.on.aws/', $data);

            if ($response->successful()) {
                $message =  'Data sent successfully!';
            } else {
                $message = 'Failed to send data! Error: ' . $response->status();
            }
        } catch (\Exception $e) {
            $message = 'An error occurred: ' . $e->getMessage();
        }
        SubDomain::where('id', $insertedId)->update([
            'lamda_response' =>$message
        ]);
        DB::commit();
        return redirect()->route('admin.sub-domains.index')
            ->with('message', __('Sub Domain created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function show(SubDomain $user)
    {
        $this->authorize('adminView', $user);
        $roles = Role::all();
        // $userHasRoles = array_column(json_decode($user->roles, true), 'id');
        return view('admin.sub-domains.show', compact('user', 'roles', 'userHasRoles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit(SubDomain $user, $id,FormBuilder $formBuilder)
    {
        $user = SubDomain::find($id);
        // $this->authorize('adminUpdate', $user);
        $form = $formBuilder->create(\App\Forms\Admin\SubDomainForm::class, [
            'method' => 'PUT',
            'url' => route('admin.sub-domains.update', $user->id),
            'model' => $user,
        ]);
        $title = $this->title;

        return view('admin.form.edit', compact('form', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateData $data, User $user, UserUpdateAction $userUpdateAction)
    {
        $this->authorize('adminUpdate', $user);
        $userUpdateAction->handle($data, $user);

        return redirect()->route('admin.sub-domains.index')
            ->with('message', __('User updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('adminDelete', $user);
        $user->delete();

        return redirect()->route('admin.sub-domains.index')
            ->with('message', __('User deleted successfully'));
    }

    /**
     * Show the user a form to change their personal information & password.
     *
     * @return \Illuminate\View\View
     */
    public function accountInfo()
    {
        $user = \Auth::user();

        return view('admin.sub-domains.account_info', compact('user'));
    }

    /**
     * Save the modified personal information for a user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accountInfoStore(Request $request)
    {
        $request->validateWithBag('account', [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . \Auth::user()->id],
        ]);

        $user = \Auth::user()->update($request->except(['_token']));

        if ($user) {
            $message = 'Account updated successfully.';
        } else {
            $message = 'Error while saving. Please try again.';
        }

        return redirect()->route('admin.account.info')->with('account_message', __($message));
    }

    /**
     * Save the new password for a user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePasswordStore(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', Rules\Password::defaults()],
            'confirm_password' => ['required', 'same:new_password', Rules\Password::defaults()],
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($validator->failed()) {
                return;
            }
            if (! Hash::check($request->input('old_password'), \Auth::user()->password)) {
                $validator->errors()->add(
                    'old_password',
                    __('Old password is incorrect.')
                );
            }
        });

        $validator->validateWithBag('password');

        $user = \Auth::user()->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        if ($user) {
            $message = 'Password updated successfully.';
        } else {
            $message = 'Error while saving. Please try again.';
        }

        return redirect()->route('admin.account.info')->with('password_message', __($message));
    }
}
