<form action="{{ route('tickets.guest.verify') }}" method="POST">
    @csrf
    <input type="text" name="guest_name" placeholder="Your Name" required>
    <input type="date" name="guest_birthdate" required>
    <button type="submit">Verify Ticket</button>
</form>
