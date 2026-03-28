<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    // INDEX
  public function index(Request $request) 
    {
        
        if ($request->expectsJson()) {
            $banks = Bank::orderBy('created_at','desc')->get();
            return response()->json(['status' => 'success', 'data' => $banks]);
        }
        // ---------------------------------

        $banks = Bank::orderBy('created_at','desc')->paginate(10);
        return view('backend.pages.banks.index', compact('banks'), ['title' => 'Bank Data']);
    }

    public function create()
    {
        return view('backend.pages.banks.create', ['title' => 'Add Bank']);
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'bank_name'      => 'required|string|max:255',
            'account_name'   => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
        ]);

        Bank::create($request->all());
        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Bank created successfully.']);
        }
        // ---------------------------------

        return redirect()->route('admin.banks.index')->with('success', 'Bank created successfully.');
    }

    // EDIT (Tidak perlu diubah)
    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return view('backend.pages.banks.edit', compact('bank'), ['title' => 'Edit Bank']);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);

        $request->validate([
            'bank_name'      => 'required|string|max:255',
            'account_name'   => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
        ]);

        $bank->update($request->all());
        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Bank updated successfully.']);
        }
        // ---------------------------------

        return redirect()->route('admin.banks.index')->with('success', 'Bank updated successfully.');
    }

    // DELETE
    public function destroy(Request $request, $id) 
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();
        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Bank deleted successfully.']);
        }

        return redirect()->route('admin.banks.index')->with('success', 'Bank deleted successfully.');
    }
}
