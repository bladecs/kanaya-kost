<div id="message-sidebar" class="message-sidebar fixed right-0 w-1/4 bg-white shadow-lg border-l border-gray-200 z-40" style="display: none;">
    <!-- Chat Header -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200 bg-amber-500 text-white">
        <div class="flex items-center">
            <img src="https://randomuser.me/api/portraits/women/32.jpg"
                class="w-10 h-10 rounded-full object-cover mr-3" alt="Admin Kost">
            <div>
                <h3 class="font-semibold">Admin Kost</h3>
                <p class="text-xs text-amber-100">Online</p>
            </div>
        </div>
        <button id="close-messages" class="py-3 px-5 rounded-xl hover:bg-amber-600">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Chat Container -->
    <div class="chat-container overflow-y-auto p-4" style="height: calc(100% - 120px);">
        <!-- Chat Messages -->
        <div class="space-y-4" id="messages-container">
            @foreach($messages as $message)
                @if($message->is_admin)
                    <!-- Admin Message -->
                    <div class="flex items-start">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg"
                            class="w-8 h-8 rounded-full object-cover mr-2" alt="Admin Kost">
                        <div>
                            <div class="bg-gray-100 rounded-lg p-3 max-w-xs">
                                <p class="text-sm">{{ $message->content }}</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                @else
                    <!-- User Message -->
                    <div class="flex justify-end">
                        <div class="text-right">
                            <div class="bg-amber-500 text-white rounded-lg p-3 max-w-xs ml-auto">
                                <p class="text-sm">{{ $message->content }}</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Message Input -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
        <div class="flex items-center">
            <input type="text" id="message-input" placeholder="Type your message..."
                class="flex-1 border border-gray-300 rounded-l-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-amber-500">
            <button id="send-message" class="bg-amber-500 text-white px-4 py-2 rounded-r-lg hover:bg-amber-600">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Toggle chat sidebar
        $('#chat-toggle').click(function() {
            $('#message-sidebar').toggle();
        });

        $('#close-messages').click(function() {
            $('#message-sidebar').hide();
        });

        // Send message
        $('#send-message').click(sendMessage);
        $('#message-input').keypress(function(e) {
            if(e.which === 13) {
                sendMessage();
            }
        });

        function sendMessage() {
            const content = $('#message-input').val().trim();
            if(content) {
                $.post('/messages', {
                    content: content,
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    // Add message to UI
                    $('#messages-container').append(`
                        <div class="flex justify-end">
                            <div class="text-right">
                                <div class="bg-amber-500 text-white rounded-lg p-3 max-w-xs ml-auto">
                                    <p class="text-sm">${content}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Just now</p>
                            </div>
                        </div>
                    `);
                    $('#message-input').val('');
                    scrollToBottom();
                });
            }
        }

        // Poll for new messages
        function pollMessages() {
            $.get('/messages', function(messages) {
                // Implement logic to update UI with new messages
                // This is a simplified version
                scrollToBottom();
            });
            
            setTimeout(pollMessages, 5000); // Poll every 5 seconds
        }

        function scrollToBottom() {
            $('.chat-container').scrollTop($('.chat-container')[0].scrollHeight);
        }

        // Initial poll
        pollMessages();
        scrollToBottom();
    });
</script>
@endpush