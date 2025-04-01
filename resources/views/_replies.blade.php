<div class="space-y-4">
    <div class="replies-container">
        @forelse ($ticket->replies as $reply)
            @php
                $contentLength = strlen($reply->content);
                $widthClass = $contentLength > 500 ? 'max-w-5xl' : ($contentLength > 100 ? 'max-w-3xl' : 'max-w-2xl');
                $name = $reply->sender->name ?? $ticket->guest_name;
                // $alignmentClass = ($reply->sender && $reply->sender->name === Auth::user()->name) ? 'ml-auto bg-baby-blue border-0 text-white' : 'mr-auto bg-white border-0';
                // $colorClass = ($reply->sender && $reply->sender->name === Auth::user()->name) ? 'text-white' : 'text-gray-700';
                // $miniFontClass = ($reply->sender && $reply->sender->name === Auth::user()->name) ? 'text-gray-100' : 'text-gray-500';
            @endphp
            <div class="bg-white mb-4 p-6 rounded-xl border shadow-md text-gray-700 break-words">
                <div class="flex items-start">
                    @if ($reply->sender && $reply->sender->profile_picture)
                        <img src="{{ asset($reply->sender->profile_picture) }}" alt="{{ $name }}" class="h-12 rounded-full mr-4 border border-gray-400">
                    @else
                        <div class="h-12 w-12 text-2xl font-bold rounded-full flex items-center justify-center mr-2 border border-gray-400 bg-gray-200 text-gray-600">
                            {{ strtoupper(substr($name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="w-full">
                        <div class="select-none">
                            <p class="text-sm font-semibold">{{ $name }}</p>
                            <span class="text-xs text-gray-500">{{ $reply->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <p class="text-gray-500 mt-5">{!! nl2br(e($reply->content)) !!}</p>

                        @if ($reply->attachments->isNotEmpty())
                            <div class="gap-4 grid grid-cols-4 select-none">
                                @foreach ($reply->attachments as $attachment)
                                    @php
                                        $maxLength = 5;
                                        $partialFileName = Str::limit($attachment->file_name, $maxLength, '');
                                        $extension = pathinfo($attachment->file_name, PATHINFO_EXTENSION);
                                    
                                        if (strlen($attachment->file_name) > $maxLength) {
                                            $partialFileName .= ' . . .' . $extension;
                                        }
                                    @endphp
                                
                                    <a href="#" class="flex justify-between text-blue-500 rounded-md my-4 flex items-center p-3 bg-blue-100 border-2 border-blue-300 hover:bg-blue-200" onclick="viewImage('{{ asset($attachment->file_location) }}', '{{ $attachment->file_name }}', {{ $loop->index }})">
                                        <div class="flex items-center gap-4">
                                            @if (Str::contains($attachment->file_name, '.pdf'))
                                                <img src='{{ asset("images/PDF_icon2.png") }}' alt="" class="h-12 w-12 rounded-md object-cover object-center">
                                            @elseif (Str::contains($attachment->file_name, '.docx'))
                                                <img src='{{ asset("images/docx_icon.png") }}' alt="" class="h-12 w-12 rounded-md object-cover object-center">
                                            @elseif (Str::contains($attachment->file_name, '.pptx'))
                                                <img src='{{ asset("images/ppt_icon.png") }}' alt="" class="h-12 w-12 rounded-md object-cover object-center">
                                            @else
                                                <img src="{{ asset($attachment->file_location) }}" alt="" class="h-12 w-12 rounded-md object-cover object-center">
                                            @endif
                                            {{ $partialFileName }}
                                        </div>
                                            
                                        <div>
                                            @if ($attachment->getSize() > 999999)
                                                <span class="text-xs text-gray-500">{{ number_format($attachment->getSize() / (1024 * 1024), 2) }} MB</span>
                                            @else
                                                <span class="text-xs text-gray-500">{{ number_format($attachment->getSize() / 1024, 0) }} KB</span>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif 
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-4 rounded-lg border border-2 mb-2 shadow-sm">
                <p class="text-gray-500 italic">No replies yet.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .bg-baby-blue {
        background-color: rgb(59 130 246);    
    }
</style>