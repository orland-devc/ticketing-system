<?php

namespace App\Http\Controllers;

use App\Models\ChatBotGreetings;
use App\Models\DataBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataBankController extends Controller
{
    public function index()
    {
        // Retrieve all data banks
        $dataBanks = DataBank::all();

        // Pass the dataBanks to the dashboard view
        return view('data_bank', compact('dataBanks'));
    }

    public function create()
    {
        // Retrieve all data from the data_bank table
        $dataBanks = DataBank::all();

        // Pass the data to the view
        return view('data_bank', compact('dataBanks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chatPattern' => 'required|string|max:255',
            'chatResponse' => 'required|string',
        ]);

        DataBank::create([
            'chatPattern' => $request->chatPattern,
            'chatResponse' => $request->chatResponse,
            'author_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Data successfully stored!');
    }

    public function dataBankUpdate(Request $request, $id)
    {
        $request->validate([
            'chatPattern' => 'required|string',
            'chatResponse' => 'required|string',
        ]);

        DataBank::updateOrCreate([
            'id' => $id,
        ], [
            'chatPattern' => $request->chatPattern,
            'chatResponse' => $request->chatResponse,
            'author_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Data successfully stored!');
    }

    public function infoUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'greeting' => 'required|string',
            'fallback' => 'required|string',
            'repeat' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional file validation
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $uploadsDirectory = 'images/uploads/';
            $imageName = $file->getClientOriginalName();
            $path = $file->move($uploadsDirectory, $imageName);

            ChatBotGreetings::updateOrCreate(
                ['type' => 'profile_picture'],
                ['message' => $uploadsDirectory.$imageName]
            );
        }

        ChatBotGreetings::updateOrCreate(
            ['type' => 'chatbot_name'],
            ['message' => $request->input('name')]
        );

        ChatBotGreetings::updateOrCreate(
            ['type' => 'greeting'],
            ['message' => $request->input('greeting')]
        );

        ChatBotGreetings::updateOrCreate(
            ['type' => 'fallback'],
            ['message' => $request->input('fallback')]
        );

        ChatBotGreetings::updateOrCreate(
            ['type' => 'repeated'],
            ['message' => $request->input('repeat')]
        );

        return redirect()->back()->with('status', 'Chatbot information updated successfully!');
    }

    public function nameUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        ChatBotGreetings::updateOrCreate(
            ['type' => 'chatbot_name'],
            ['message' => $request->name]
        );

        return redirect()->back()->with('success', 'Data successfully stored!');
    }

    public function greetUpdate(Request $request)
    {
        $request->validate([
            'greeting' => 'required|string',
        ]);

        ChatBotGreetings::updateOrCreate(
            ['type' => 'greeting'],
            ['message' => $request->greeting]
        );

        return redirect()->back()->with('success', 'Data successfully stored!');
    }

    public function fallbackUpdate(Request $request)
    {
        $request->validate([
            'fallback' => 'required|string',
        ]);

        ChatBotGreetings::updateOrCreate(
            ['type' => 'fallback'],
            ['message' => $request->fallback]
        );

        return redirect()->back()->with('success', 'Data successfully stored!');
    }

    public function repeatedUpdate(Request $request)
    {
        $request->validate([
            'repeat' => 'required|string',
        ]);

        ChatBotGreetings::updateOrCreate(
            ['type' => 'repeated'],
            ['message' => $request->repeat]
        );

        return redirect()->back()->with('success', 'Data successfully stored!');
    }
}
