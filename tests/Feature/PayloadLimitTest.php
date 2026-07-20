<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Service;
use Tests\TestCase;

class PayloadLimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_order_request_rejects_payload_over_3000_chars(): void
    {
        $service = Service::create([
            'title' => 'Test Service',
            'description' => 'Test Description',
            'status' => 'active'
        ]);

        $request = new StoreOrderRequest();
        $rules = $request->rules();
        $messages = $request->messages();

        $data = [
            'customer_name' => 'Test Customer',
            'phone' => '0500000000',
            'location' => 'Jeddah',
            'service_id' => $service->id,
            'description' => str_repeat('a', 3001),
        ];

        $validator = Validator::make($data, $rules, $messages);

        $this->assertTrue($validator->fails());
        $this->assertEquals('تفاصيل الطلب يجب ألا تتجاوز 3000 حرف', $validator->errors()->first('description'));
    }

    public function test_store_project_request_rejects_payload_over_3000_chars(): void
    {
        $request = new StoreProjectRequest();
        $rules = $request->rules();
        $messages = $request->messages();

        $data = [
            'title' => 'Test Project',
            'category' => 'Smart Home',
            'description' => str_repeat('a', 3001),
        ];

        $validator = Validator::make($data, $rules, $messages);

        $this->assertTrue($validator->fails());
        $this->assertEquals('تفاصيل الطلب يجب ألا تتجاوز 3000 حرف', $validator->errors()->first('description'));
    }

    public function test_store_service_request_rejects_payload_over_3000_chars(): void
    {
        $request = new StoreServiceRequest();
        $rules = $request->rules();
        $messages = $request->messages();

        $data = [
            'title' => 'Test Service',
            'description' => str_repeat('a', 3001),
        ];

        $validator = Validator::make($data, $rules, $messages);

        $this->assertTrue($validator->fails());
        $this->assertEquals('تفاصيل الطلب يجب ألا تتجاوز 3000 حرف', $validator->errors()->first('description'));
    }
}
