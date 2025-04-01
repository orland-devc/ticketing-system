<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the faqs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manage-chatbot');
    }

    /**
     * Show the form for creating a new faq.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage-chatbot.create');
    }

    /**
     * Store a newly created faq in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        Faq::create($validatedData);

        return redirect()->route('manage-chatbot.index')->with('success', 'FAQ created successfully.');
    }

    /**
     * Display the specified faq.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        return view('manage-chatbot', compact('faq'));
    }

    /**
     * Show the form for editing the specified faq.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('manage-chatbot', compact('faq'));
    }

    /**
     * Update the specified faq in storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        // $validatedData = $request->validate([
        //     'question' => 'required|string',
        //     'answer' => 'required|string',
        // ]);

        // $faq->update($validatedData);

        $faq = Faq::find($id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();

        return redirect()->route('manage-chatbot.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified faq from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $faq)
    {
        Faq::destroy($faq);

        return redirect()->route('manage-chatbot.index')->with('success', 'FAQ deleted successfully.');
    }
}
