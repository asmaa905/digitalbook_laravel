<?php

namespace App\Http\Controllers\Publisher;

use App\Models\Book;
use App\Models\AudioVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioVersionController extends BaseController
{
    public function indexAudioOfSingleBook(Book $book)
    {
        $this->authorize('view', $book);
        
        $audioVersions = $book->audioVersions()->latest()->paginate(10);
        
        return $this->view('audio-versions.index', compact('book', 'audioVersions'));
    }

    public function index()
    {
        // Get all books that belong to the current publisher with their audio versions
        $books = Book::where('published_by', auth()->id())
            ->with(['audioVersions', 'author', 'category'])
            ->latest()
            ->paginate(10);
            
        return $this->view('audio-versions.index', compact('books'));
    }

    public function create(Request $request)
    {
        $book = null;
        $books = Book::where('published_by', auth()->id())->get();
        
        if ($request->has('book_id')) {
            $book = Book::findOrFail($request->book_id);
            $this->authorize('view', $book);
        }
        
        return $this->view('audio-versions.create', compact('book', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'audio_file' => 'required|file|mimes:mp3,wav,aac',
            'audio_duration' => 'required|numeric|min:0',
            'language' => 'required|string|max:10',
            'audio_review_file' => 'nullable|file|mimes:mp3,wav,aac',
            'audio_format_review' => 'required|string|in:MP3,AAC,WAV',
            'audio_format_full_audio' => 'required|string|in:MP3,AAC,WAV'
        ]);

        $book = Book::findOrFail($validated['book_id']);
        $this->authorize('update', $book);

        // Store audio file
        $validated['audio_link'] = $request->file('audio_file')->store('books/audio', 'public');
      
        // Store review file if exists
        if ($request->hasFile('audio_review_file')) {
            $validated['review_record_link'] = $request->file('audio_review_file')->store('books/review_audios', 'public');
        }
        
        $validated['created_by'] = auth()->id();

        AudioVersion::create($validated);

        return redirect()->route('publisher.audio-versions.index')
            ->with('success', 'Audio version added successfully!');
    }

    public function show(AudioVersion $audioVersion)
    {
        $this->authorize('view', $audioVersion->book);
        
        return $this->view('audio-versions.show', compact('audioVersion'));
    }

    public function edit(AudioVersion $audioVersion)
    {
        $this->authorize('update', $audioVersion->book);
        
        $books = Book::where('published_by', auth()->id())->get();
        
        return $this->view('audio-versions.create', compact('audioVersion', 'books'));
    }

    public function update(Request $request, AudioVersion $audioVersion)
    {
        $this->authorize('update', $audioVersion->book);
        
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'audio_file' => 'nullable|file|mimes:mp3,wav,aac',
            'audio_duration' => 'required|numeric|min:0',
            'language' => 'required|string|max:10',
            'audio_review_file' => 'nullable|file|mimes:mp3,wav,aac',
            'audio_format_review' => 'required|string|in:MP3,AAC,WAV',
            'audio_format_full_audio' => 'required|string|in:MP3,AAC,WAV'
        ]);

        if ($request->hasFile('audio_file')) {
            // Delete old audio file if exists
            if ($audioVersion->audio_link) {
                Storage::disk('public')->delete($audioVersion->audio_link);
            }
            $validated['audio_link'] = $request->file('audio_file')->store('books/audio', 'public');
        }

        if ($request->hasFile('audio_review_file')) {
            // Delete old review file if exists
            if ($audioVersion->review_record_link) {
                Storage::disk('public')->delete($audioVersion->review_record_link);
            }
            $validated['review_record_link'] = $request->file('audio_review_file')->store('books/review_audios', 'public');
        }

        $audioVersion->update($validated);

        return redirect()->route('publisher.audio-versions.index')
            ->with('success', 'Audio version updated successfully!');
    }

    public function destroy(AudioVersion $audioVersion)
    {
        $this->authorize('delete', $audioVersion->book);
        
        // Delete audio files if they exist
        if ($audioVersion->audio_link) {
            Storage::disk('public')->delete($audioVersion->audio_link);
        }
        if ($audioVersion->review_record_link) {
            Storage::disk('public')->delete($audioVersion->review_record_link);
        }
        
        $audioVersion->delete();

        return redirect()->route('publisher.audio-versions.index')
            ->with('success', 'Audio version deleted successfully!');
    }
}