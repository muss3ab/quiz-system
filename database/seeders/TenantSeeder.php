<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Database\Factories\TenantFactory;


class TenantSeeder extends Seeder
{
    public function run()
    {
        // Create predefined tenants
        $predefinedTenants = [
            [
                'name' => 'Acme Corporation',
                'domain' => 'acme',
                'email' => 'admin@acme.com',
            ],
            [
                'name' => 'TechStart Inc',
                'domain' => 'techstart',
                'email' => 'admin@techstart.com',
            ],
            [
                'name' => 'Global Learning',
                'domain' => 'globallearn',
                'email' => 'admin@globallearn.com',
            ],
        ];

        foreach ($predefinedTenants as $tenantData) {
            $tenant = Tenant::create([
                'id' => $tenantData['name'],
                'data' => [
                    'admin_email' => $tenantData['email'],

                ]
            ]);

            // Create domain for each tenant
            $tenant->domains()->create([
                'domain' => $tenantData['domain'],
            ]);
        }

      
    }
}
