<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of payment methods.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('sort_order')->get();
        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new payment method.
     */
    public function create()
    {
        return view('admin.payment-methods.create');
    }

    /**
     * Store a newly created payment method.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'description' => 'required|string|max:500',
            'instructions_json' => 'required|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $paymentMethod = PaymentMethod::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'instructions' => $request->instructions_json,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->integer('sort_order', 0)
        ]);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method created successfully!');
    }

    /**
     * Show the form for editing the specified payment method.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment-methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified payment method.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $paymentMethod->id,
            'description' => 'required|string|max:500',
            'instructions_json' => 'required|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        $paymentMethod->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'instructions' => $request->instructions_json,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $request->integer('sort_order', 0)
        ]);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully!');
    }

    /**
     * Remove the specified payment method.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        // Check if payment method is being used
        if ($paymentMethod->bookingPayments()->count() > 0) {
            return redirect()->route('admin.payment-methods.index')
                ->with('error', 'Cannot delete payment method that is being used in bookings!');
        }

        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully!');
    }

    /**
     * Toggle payment method status
     */
    public function toggleStatus(PaymentMethod $paymentMethod)
    {
        $paymentMethod->update([
            'is_active' => !$paymentMethod->is_active
        ]);

        $status = $paymentMethod->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.payment-methods.index')
            ->with('success', "Payment method {$status} successfully!");
    }

    /**
     * Reorder payment methods
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer|exists:payment_methods,id'
        ]);

        foreach ($request->orders as $index => $paymentMethodId) {
            PaymentMethod::where('id', $paymentMethodId)
                ->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
