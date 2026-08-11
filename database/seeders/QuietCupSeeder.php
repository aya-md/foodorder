<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Category;
use App\Models\Item;
use App\Models\Option;
use App\Models\OptionGroup;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class QuietCupSeeder extends Seeder
{
    public function run(): void
    {
        $business = Business::create([
            'name' => 'The Quiet Cup',
            'slug' => 'the-quiet-cup',
            'status' => 'approved',
            'is_open' => true,
            'table_count' => 8,
            'opening_hours' => 'Mon–Sun, 8:00 AM – 8:00 PM',
        ]);

        $owner = User::create([
            'name' => 'Aya',
            'email' => 'owner@thequietcup.test',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'business_id' => $business->id,
        ]);

        User::create([
            'name' => 'Sara',
            'email' => 'sara@thequietcup.test',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'business_id' => $business->id,
        ]);

        User::create([
            'name' => 'Yassine',
            'email' => 'yassine@thequietcup.test',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'business_id' => $business->id,
        ]);

        $menu = [
            'Moroccan Mornings' => [
                ['Traditional Mint Tea', 'Fresh mint, green tea, steeped the traditional way', 15, true],
                ['Msemen (Stack of 2)', 'Warm, layered flatbread, served with honey and butter', 25, true],
                ['Baghrir with Honey & Amlou', 'Moroccan pancakes with almond-argan spread', 30, true],
                ['Harira Cup', 'Traditional soup, seasonal availability', 22, false],
                ['Khobz Beldi with Olive Oil & Zaatar', 'Traditional bread, local olive oil, zaatar', 20, true],
            ],
            'Healthy Sips' => [
                ['Cold-Pressed Orange & Carrot Juice', 'Freshly pressed, no added sugar', 28, true],
                ['Green Detox Smoothie', 'Spinach, apple, ginger, lemon', 32, true],
                ['Matcha Latte', 'Ceremonial-grade matcha, oat milk', 35, true],
                ['Turmeric Golden Latte', 'Turmeric, ginger, black pepper, oat milk', 30, true],
                ['Avocado Banana Smoothie', 'Avocado, banana, almond milk, dates', 34, true],
            ],
            'Brunch & Bowls' => [
                ['Acai Bowl', 'Acai, granola, fresh seasonal fruit', 45, true],
                ['Avocado Toast', 'Sourdough, poached egg, chili flakes', 42, true],
                ['Overnight Oats', 'Almond butter, chia seeds, berries', 30, true],
                ['Shakshuka', 'Moroccan-style, eggs poached in spiced tomato sauce', 48, false],
                ['Greek Yogurt Bowl', 'Honey, walnuts, seasonal fruit', 35, true],
            ],
            'Classic Coffee Bar' => [
                ['Espresso', 'Double shot', 15, true],
                ['Cappuccino', 'Espresso, steamed milk, foam', 22, true],
                ['Café Latte', 'Espresso, steamed milk', 25, true],
                ['Americano', 'Espresso, hot water', 18, true],
                ['Flat White', 'Espresso, microfoam', 24, true],
            ],
            'Sweet Treats' => [
                ['Croissant', 'Butter croissant, baked daily', 14, true],
                ['Chocolate Muffin', 'Dark chocolate chunks', 16, true],
                ['Carrot Cake Slice', 'Cream cheese frosting, walnuts', 20, true],
                ['Cinnamon Roll', 'Warm, glazed', 18, true],
            ],
            'Cold & Indulgent' => [
                ['Iced Caramel Frappe', 'Blended coffee, caramel, whipped cream', 32, true],
                ['Nutella Milkshake', 'Nutella, vanilla ice cream, milk', 35, true],
                ['Iced Mocha', 'Espresso, chocolate, cold milk', 30, true],
            ],
        ];

        $allItems = [];

        foreach ($menu as $categoryName => $items) {
            $category = Category::create([
                'business_id' => $business->id,
                'name' => $categoryName,
                'position' => array_search($categoryName, array_keys($menu)),
            ]);

            foreach ($items as $index => [$name, $description, $price, $available]) {
                $item = Item::create([
                    'business_id' => $business->id,
                    'category_id' => $category->id,
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'available' => $available,
                ]);

                $allItems[$name] = $item;
            }
        }

        // Milk type options on Café Latte
        $milkGroup = OptionGroup::create([
            'business_id' => $business->id,
            'item_id' => $allItems['Café Latte']->id,
            'name' => 'Milk Type',
        ]);
        Option::create(['business_id' => $business->id, 'option_group_id' => $milkGroup->id, 'label' => 'Whole Milk', 'extra_price' => 0]);
        Option::create(['business_id' => $business->id, 'option_group_id' => $milkGroup->id, 'label' => 'Oat Milk', 'extra_price' => 5]);
        Option::create(['business_id' => $business->id, 'option_group_id' => $milkGroup->id, 'label' => 'Almond Milk', 'extra_price' => 5]);

        // Size options on Matcha Latte
        $sizeGroup = OptionGroup::create([
            'business_id' => $business->id,
            'item_id' => $allItems['Matcha Latte']->id,
            'name' => 'Size',
        ]);
        Option::create(['business_id' => $business->id, 'option_group_id' => $sizeGroup->id, 'label' => 'Regular', 'extra_price' => 0]);
        Option::create(['business_id' => $business->id, 'option_group_id' => $sizeGroup->id, 'label' => 'Large', 'extra_price' => 8]);

        $this->seedOrders($business, $allItems);
    }

    private function seedOrders(Business $business, array $allItems): void
    {
        $customerNames = ['Yasmine', 'Karim', 'Salma', 'Omar', 'Nour', 'Hamza', 'Imane', 'Reda'];
        $availableItems = array_values(array_filter($allItems, fn ($item) => $item->available));

        $ordersToCreate = [
            ['status' => 'pending', 'minutesAgo' => 3],
            ['status' => 'pending', 'minutesAgo' => 8],
            ['status' => 'pending', 'minutesAgo' => 15],
            ['status' => 'preparing', 'minutesAgo' => 12],
            ['status' => 'preparing', 'minutesAgo' => 20],
            ['status' => 'ready', 'minutesAgo' => 25],
            ['status' => 'completed', 'minutesAgo' => 40],
            ['status' => 'completed', 'minutesAgo' => 90],
            ['status' => 'completed', 'minutesAgo' => 150],
            ['status' => 'completed', 'minutesAgo' => 200],
            ['status' => 'cancelled', 'minutesAgo' => 60],
        ];

        // Older orders across the past week, for the revenue chart
        for ($daysAgo = 1; $daysAgo <= 6; $daysAgo++) {
            $ordersToCreate[] = ['status' => 'completed', 'daysAgo' => $daysAgo];
            if ($daysAgo % 2 === 0) {
                $ordersToCreate[] = ['status' => 'completed', 'daysAgo' => $daysAgo];
            }
        }

        foreach ($ordersToCreate as $data) {
            $createdAt = isset($data['daysAgo'])
                ? Carbon::now()->subDays($data['daysAgo'])->setTime(rand(8, 18), rand(0, 59))
                : Carbon::now()->subMinutes($data['minutesAgo']);

            $orderItems = collect($availableItems)->random(rand(1, 3));
            $total = 0;
            $lines = [];

            foreach ($orderItems as $item) {
                $quantity = rand(1, 2);
                $lineTotal = $item->price * $quantity;
                $total += $lineTotal;
                $lines[] = ['item' => $item, 'quantity' => $quantity];
            }

            $order = Order::create([
                'business_id' => $business->id,
                'customer_name' => $customerNames[array_rand($customerNames)],
                'phone' => '06'.rand(10000000, 99999999),
                'type' => rand(0, 1) ? 'dine_in' : 'take_away',
                'table_number' => rand(0, 1) ? (string) rand(1, 8) : null,
                'status' => $data['status'],
                'total' => $total,
                'tracking_uuid' => Str::uuid(),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            foreach ($lines as $line) {
                $order->items()->create([
                    'business_id' => $business->id,
                    'item_id' => $line['item']->id,
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['item']->price,
                ]);
            }
        }
    }
}
