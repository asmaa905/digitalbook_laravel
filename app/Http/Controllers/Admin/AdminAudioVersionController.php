<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\User;
use App\Models\AudioVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAudioVersionController extends BaseController
{
    public function index()
    {
        $audioVersions = AudioVersion::with(['book', 'book.author', 'creator'])
        ->with(['book', 'creator'])
        ->latest()
            ->paginate(10);
            
        return $this->view('audio-versions.index', compact('audioVersions'));
    }

    public function create(Request $request)
    {
        
        $books = Book::with(['author', 'category', 'publishingHouse', 'audioVersions'])
        ->where('is_published', 'accepted')
        ->latest()
        ->get();
        $users = User::get();
        
        $selectedBook = $request->has('book_id') 
            ? Book::findOrFail($request->book_id)
            : null;
            
        return $this->view('audio-versions.create', compact('books', 'users', 'selectedBook'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            // 'creator_by' => 'required|exists:users,id',
            'audio_file' => 'required|file|mimes:mp3,wav,aac|max:65536',
            'audio_duration' => 'required|numeric|min:0',
            'language' => 'required|string|max:10',
            'review_record_file' => 'nullable|file|mimes:mp3,wav,aac|max:2048', 
            'is_published' => 'required|in:waiting,accepted,rejected',
        ]);

        // Store audio file
        $validated['audio_link'] = $request->file('audio_file')->store(
            'books/audio_versions', 'public'
        );
        if ($request->hasFile('review_record_file')) {
            $validated['review_record_link'] = $request->file('review_record_file')->store(
                'books/review_audios', 'public'
            );
        }
        
        
    
        // if (empty($validated['is_published'])) {
        //     $validated['is_published'] = 'waiting';
        // }
        $validated['created_by'] = auth()->id();

        AudioVersion::create($validated);

        return redirect()->route('admin.audio-versions.index')
            ->with('success', 'Audio version added successfully!');
    }

    public function show(AudioVersion $audioVersion)
    {
        $books = Book::with(['author', 'category', 'publishingHouse', 'audioVersions'])
            ->where('is_published', 'accepted')
            ->latest()
            ->get();
        $audio =AudioVersion::with(['creator']);
        return $this->view('audio-versions.show', compact('audioVersion', 'books'));
    }

    public function edit(AudioVersion $audioVersion)
    {
        
        $books = Book::with(['author', 'category', 'publishingHouse', 'audioVersions'])
        ->where('is_published', 'accepted')
        ->latest()
        ->get();
        $users = User::get();
        
        return $this->view('audio-versions.create', compact('audioVersion', 'books', 'users'));
    }

    public function update(Request $request, AudioVersion $audioVersion)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            // 'creator_by' => 'required|exists:users,id',
            'audio_file' => 'nullable|file|mimes:mp3,wav,aac|max:65536',
            'audio_duration' => 'required|numeric|min:0',
            'language' => 'required|string|max:10',
            'review_record_file' => 'nullable|file|mimes:mp3,wav,aac|max:2048', 
            'is_published' => 'required|in:waiting,accepted,rejected',
        ]);

        // Update audio file if provided
        if ($request->hasFile('audio_file')) {
            // Delete old file
            if ($audioVersion->audio_link) {
                Storage::disk('public')->delete($audioVersion->audio_link);
            }
            $validated['audio_link'] = $request->file('audio_file')->store(
                'books/books_audio_links', 'public'
            );
        }

        // Update review file if provided
        if ($request->hasFile('review_record_file')) {
            if ($audioVersion->review_record_link) {
                Storage::disk('public')->delete($audioVersion->review_record_link);
            }
            $validated['review_record_link'] = $request->file('review_record_file')->store(
                'books/review_audios', 'public'
            );
        }
        

        $audioVersion->update($validated);

        return redirect()->route('admin.audio-versions.index')
            ->with('success', 'Audio version updated successfully!');
    }

    public function destroy(AudioVersion $audioVersion)
    {
        // Delete files
        if ($audioVersion->audio_link) {
            Storage::disk('public')->delete($audioVersion->audio_link);
        }
        if ($audioVersion->review_record_link) {
            Storage::disk('public')->delete($audioVersion->review_record_link);
        }
        
        $audioVersion->delete();

        return redirect()->route('admin.audio-versions.index')
            ->with('success', 'Audio version deleted successfully!');
    }
}