@extends('layouts.master')

@section('content')


                        <table class="table table-bordered" id="user-transactions" width="100%">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Phone Number</th>
                                <th>Amount</th>
                                <th>Transaction ID</th>
                                <th>Transaction time</th>
                            </tr>
                            </thead>
                        </table>

@stop

@push('scripts')

    <script>

        $(function() {
            $('#user-transactions').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('anydata') !!}',
                columns: [
                    { data: 'first_name', name: 'first_name' },
                    { data: 'middle_name', name: 'middle_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'account_number', name: 'account_number' },
                    { data: 'amount', name: 'amount' },
                    { data: 'transaction_id', name: 'transaction_id' },
                    { data: 'transaction_time', name: 'transaction_time' }
                ]
            });
        });
    </script>

@endpush