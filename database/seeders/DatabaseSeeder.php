<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Interaction;
use App\Models\Lead;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = collect([
            User::query()->updateOrCreate([
                'email' => 'admin@crm.test',
            ], [
                'name' => 'Olivia Hart',
                'password' => 'password',
                'role' => 'admin',
                'job_title' => 'CRM Administrator',
                'phone' => '+1 415 555 0101',
                'theme' => 'dark',
                'avatar_color' => 'emerald',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]),
            User::query()->updateOrCreate([
                'email' => 'manager@crm.test',
            ], [
                'name' => 'Marcus Lee',
                'password' => 'password',
                'role' => 'manager',
                'job_title' => 'Sales Manager',
                'phone' => '+1 415 555 0102',
                'avatar_color' => 'amber',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]),
            User::query()->updateOrCreate([
                'email' => 'sales@crm.test',
            ], [
                'name' => 'Sofia Patel',
                'password' => 'password',
                'role' => 'sales',
                'job_title' => 'Account Executive',
                'phone' => '+1 415 555 0103',
                'avatar_color' => 'sky',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]),
        ]);

        if (Lead::count() < 20) {
            Lead::factory(24 - Lead::count())->create([
                'owner_id' => fn () => $users->random()->id,
            ]);
        }

        if (Customer::count() < 15) {
            Customer::factory(18 - Customer::count())->create([
                'owner_id' => fn () => $users->random()->id,
            ]);
        }

        $customers = Customer::all();

        $customers->each(function (Customer $customer) use ($users): void {
            if ($customer->interactions()->count() === 0) {
                Interaction::factory(random_int(2, 4))->create([
                    'customer_id' => $customer->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        });

        if (Deal::count() < 10) {
            Deal::factory(14 - Deal::count())->create([
                'customer_id' => fn () => $customers->random()->id,
                'lead_id' => fn () => Lead::query()->inRandomOrder()->value('id'),
                'owner_id' => fn () => $users->random()->id,
            ]);
        }

        $deals = Deal::all();

        if (Task::count() < 10) {
            Task::factory(12 - Task::count())->create([
                'assigned_to' => fn () => $users->random()->id,
                'customer_id' => fn () => $customers->random()->id,
                'deal_id' => fn () => $deals->random()->id,
            ]);
        }

        if (Activity::count() === 0) {
            $this->seedActivities($users, $customers, $deals);
        }
    }

    protected function seedActivities(Collection $users, Collection $customers, Collection $deals): void
    {
        $activityFeed = [
            ['deal_closed', 'Closed the Northstar renewal for $48,500.', 'badge-check'],
            ['lead_qualified', 'Qualified a website lead from the SaaS campaign.', 'sparkles'],
            ['meeting_booked', 'Booked a product walkthrough with Redwood Labs.', 'calendar-days'],
            ['task_completed', 'Completed follow-up tasks for the enterprise pipeline.', 'check-circle'],
            ['customer_note', 'Added implementation notes for a VIP customer.', 'chat-bubble-left-right'],
            ['forecast_update', 'Updated revenue forecast ahead of the weekly review.', 'chart-bar'],
        ];

        foreach (range(1, 18) as $index) {
            [$action, $description, $icon] = $activityFeed[array_rand($activityFeed)];
            $subject = $index % 2 === 0 ? $customers->random() : $deals->random();

            Activity::log(
                $action,
                $description,
                $subject,
                $users->random()->id,
                $icon,
            );
        }
    }
}
