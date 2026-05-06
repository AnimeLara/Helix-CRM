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

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = collect([
            User::factory()->create([
                'name' => 'Olivia Hart',
                'email' => 'admin@crm.test',
                'role' => 'admin',
                'job_title' => 'CRM Administrator',
                'phone' => '+1 415 555 0101',
                'theme' => 'dark',
                'avatar_color' => 'emerald',
            ]),
            User::factory()->create([
                'name' => 'Marcus Lee',
                'email' => 'manager@crm.test',
                'role' => 'manager',
                'job_title' => 'Sales Manager',
                'phone' => '+1 415 555 0102',
                'avatar_color' => 'amber',
            ]),
            User::factory()->create([
                'name' => 'Sofia Patel',
                'email' => 'sales@crm.test',
                'role' => 'sales',
                'job_title' => 'Account Executive',
                'phone' => '+1 415 555 0103',
                'avatar_color' => 'sky',
            ]),
        ]);

        Lead::factory(24)->create([
            'owner_id' => fn () => $users->random()->id,
        ]);

        $customers = Customer::factory(18)->create([
            'owner_id' => fn () => $users->random()->id,
        ]);

        $customers->each(function (Customer $customer) use ($users): void {
            Interaction::factory(random_int(2, 4))->create([
                'customer_id' => $customer->id,
                'user_id' => $users->random()->id,
            ]);
        });

        $deals = Deal::factory(14)->create([
            'customer_id' => fn () => $customers->random()->id,
            'lead_id' => fn () => Lead::query()->inRandomOrder()->value('id'),
            'owner_id' => fn () => $users->random()->id,
        ]);

        Task::factory(12)->create([
            'assigned_to' => fn () => $users->random()->id,
            'customer_id' => fn () => $customers->random()->id,
            'deal_id' => fn () => $deals->random()->id,
        ]);

        $this->seedActivities($users, $customers, $deals);
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
