<div class="flex items-center leading-tight space-x-3 top-options">

    @if(session('message'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: '{{ Session::get('message') }}', 
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 px-4 py-2 rounded'
                }
            });
        </script>
    @endif

    @if ($ticket->status == 'closed')
        <p class="italic text-sm">This ticket has been closed at {{ $ticket->updated_at->format('M d, Y h:i A') }}</p>
    @else
        <a href="#" class="options px-4 py-2 hover:bg-blue-200" title="Assign" onclick="showReplySection()">
            <i class="fas fa-reply mr-2"></i>
            Reply
        </a>
        @if (empty($ticket->assigned_to))
            <a href="#" onclick="showAssignTab()" class="options px-4 py-2 hover:bg-blue-200" title="Assign">
                <i class="fas fa-share mr-2"></i>
                Assign
            </a>
        @else
            <a href="#" class="options px-4 py-2 hover:bg-blue-200">
                <i class="fas fa-share mr-2"></i>
                Forwarded to {{$ticket->ticket->name}}
            </a>
        @endif

        <a href="#" class="options px-4 py-2 hover:bg-blue-200">
            <i class="fas fa-paper-plane mr-2"></i>
            Send as message
        </a>
        <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="m-0 ml-2" id="closeTicketForm">
            @csrf
            @method('PUT')
            <button type="button" id="closeTicketButton" class="hover:bg-blue-500 bg-blue-400 text-white px-4 py-2 rounded-md font-bold mb-0">
                <i class="far fa-check-circle mr-2"></i>
                Close Ticket
            </button>
        </form>
        
        <script>
            function showTicketClosedAlert() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will close the ticket!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, close it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show a waiting SweetAlert
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we process your request.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
            
                        // Submit the form via AJAX
                        const form = document.getElementById('closeTicketForm');
                        const formData = new FormData(form);
                        const actionUrl = form.getAttribute('action');
            
                        fetch(actionUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            setTimeout(() => { // Add a delay of 3 seconds
                                Swal.fire({
                                title: 'Closed!',
                                text: 'The ticket has been closed successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-300 px-4 py-2 rounded'
                                }
                            });

                            }, 2000);
                        })
                        .catch(error => {
                            setTimeout(() => { // Add a delay of 3 seconds
                                Swal.fire(
                                    'Error!',
                                    'There was a problem closing the ticket.',
                                    'error'
                                );
                            }, 2000);
                        });
                    }
                });
            }
        document.getElementById('closeTicketButton').addEventListener('click', function() {
            showTicketClosedAlert();
        });
        </script>
        
    @endif
</div>


<style>
    .options {
        font-size: 18px;
        display: flex;
        align-items: center;
        background: #f0f9ff;
        border-radius: 6px;
        color: #0076b0;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }
    .custom-ok-button {
        background-color: #0076b0 !important; /* Custom background color */
        color: white !important; /* Custom text color */
        border: none !important; /* Remove any default border */
    }

    .custom-ok-button:hover {
        background-color: #005e8d !important; /* Custom hover background color */
        color: white !important; /* Ensure text remains visible on hover */
    }

</style>