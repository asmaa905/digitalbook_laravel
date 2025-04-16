<div class="table-responsive mt-3">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Cover</th>
                <th>Title</th>
                <th>Publisher</th>
                <th>Category</th>
                  <th>Ratingss</th>
                  <th>Reviews</th>
                  <th>Published Date</th>
             
                <th>Status</th>
                <th>PDF</th>
                <th>Audio Versions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td>
                    @if($book->image)
                    <div style="width:50px;height:50px; border-raduis:5px;border:1px solid #ddd;padding:6px">
                        <img src="{{ asset('storage/'.$book->image) }}"  class="w-100 h-100"></div>
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="width:50px;height:70px;">
                            <i class="fas fa-book text-muted"></i>
                        </div>
                    @endif
                </td>
               <td> @if (strlen($book->title) > 15)
                    {{substr($book->title, 0, 15) . "..."}}
                @else 
                {{cutText($book->title)}} 
                @endif
                </td>
                <td>{{ $book->publisher->name ?? 'Unknown' }}</td>
                <td>{{ $book->category->name ?? 'Uncategorized' }}</td>

                <td><a href="{{ route('user.books.show', $book->id) }}" class="btn  btn-sm bg-light">{{ $book->rating ?? 0 }} <i class="fas fa-star fa-sm text-gray-300"></i></a></td>
                <td><a href="{{ route('user.books.show', $book->id) }}" class="btn  btn-sm bg-light">{{ count($book->reviews) ?? 0 }} <i class="fas fa-comment fa-sm text-gray-300"></i></a></td>
                <td>{{ $book->publish_date ? $book->publish_date->format('M d, Y') : 'Not published' }}</td>
                <td>
                <span class="badge bg-{{$book->is_published === 'accepted' 
                                            ? 'success' 
                                            : ($book->is_published === 'rejected' 
                                                ? 'danger' 
                                                : 'info') 
                                    }}">
                                        {{ ucfirst($book->is_published) }}
                                    </span>

                </td>

                <td>
                    @if($book->pdf_link)
                        
                        <a class="button badge bg-warning text-white text-primary" style="text-decoration-line:underline"  download="{{$book->title}}.pdf" 
                        href="{{ asset('storage/'.$book->pdf_link) }}" target="_blank" >
                         Download
                        </a>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('publisher.books.show', $book->id) }}" class="btn btn-sm btn-light">
                        {{ $book->audioVersions->count() }} <i class="fas fa-headphones fa-sm text-gray-300"></i>
                    </a>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('publisher.books.show', $book->id) }}" class="btn  btn-sm bg-light">
                            <i class="fas fa-eye  fa-sm text-info"></i>
                        </a>
                        <a href="{{ route('publisher.books.edit', $book->id) }}" class="btn  btn-sm bg-light">
                            <i class="fas fa-edit fa-sm text-success"></i>
                        </a>
                        <form action="{{ route('publisher.books.destroy', $book->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn  btn-sm bg-light" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash  fa-sm text-danger"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="text-center">No {{ $type }} books found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">
    {{ $books->links() }}
</div>