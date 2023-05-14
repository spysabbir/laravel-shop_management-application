<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
                <th>Name</th>
                <th>{{ $contact_message->name }}</th>
            </tr>
            <tr>
                <th>Email</th>
                <th>{{ $contact_message->email }}</th>
            </tr>
            <tr>
                <th>Phone Number</th>
                <th>{{ $contact_message->phone_number }}</th>
            </tr>
            <tr>
                <th>Message Date</th>
                <th>{{ $contact_message->created_at->format('D d-M,Y h:m:s A') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Subject</td>
                <td>{{ $contact_message->subject }} </td>
            </tr>
            <tr>
                <td>Message</td>
                <td>{{ $contact_message->message }}</td>
            </tr>
        </tbody>
    </table>
</div>

