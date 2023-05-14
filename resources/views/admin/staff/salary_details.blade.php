<h3>{{ $staff->staff_name }}</h3>

<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
                <th>Salary Month & Year</th>
                <th>Payment Salary</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($staff_salaries as $staff_salary)
            <tr>
                <td>{{ $staff_salary->salary_month ."-". $staff_salary->salary_year }}</td>
                <td>{{ $staff_salary->payment_salary }}</td>
                <td>{{ date('d-M-Y h:m:s A', strtotime($staff_salary->payment_date)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
