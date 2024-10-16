<x-admin.wrapper>
    <x-slot name="title">
            {{ __('Users') }}
    </x-slot>

    <div class="w-full py-2">
        <div class="min-w-full border-base-200 shadow">
            <table>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Subdomain') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->subdomain }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Domain Name') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->domain_name }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('DB Name') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->db_name }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Is Active') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->is_active ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Name') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->name }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Hostname') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->hostname }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('DB User') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->db_user }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('DB Password') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->db_password }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Domain DNS1') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->domain_dns1 }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Domain DNS2') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->domain_dns2 }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Lamda Response') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->lamda_response }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Database Type') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->database_type }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Domain Type') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->domain_type }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Created At') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->created_at }}</td>
                </tr>
                <tr>
                    <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ __('Updated At') }}</td>
                    <td class="border-b border-slate-100 p-4 text-slate-500">{{ $subdomain->updated_at }}</td>
                </tr>
            </table>

        </div>
    </div>
</x-admin.wrapper>
