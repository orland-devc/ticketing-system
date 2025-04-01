<form action="{{ route('tickets.guest.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="guest_name" placeholder="Your Name" required>
    <input type="date" name="guest_birthdate" required>
    <input type="email" name="guest_email" placeholder="Your Email (optional)">
    
    <!-- Rest of the ticket submission fields -->
    <select name="level" required>
        <option value="normal">Normal</option>
        <option value="important">Important</option>     
        <option value="critical">Critical</option>    
    </select>

    <input type="text" name="subject" required>
    <input type="text" name="category" required>
    <textarea name="content" required></textarea>
    <input type="file" name="attachments[]" multiple>
    
    <button type="submit">Submit Ticket</button>
</form>