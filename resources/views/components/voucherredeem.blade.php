<x-app-layout>
    <x-slot name="header_content">
        <h1>Redeemed Voucher</h1>        
    </x-slot>
    <div>
        <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th>Created</th>
                        <th>Order Id</th> 
                        <th>Customer Name</th>                        
                        <th>Phone Number</th>                        
                        <th>Email</th>                        
                        <th>Registered</th>                        
                        <th>Channel</th>                                                
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($userList as $data)
                        <tr class="text-center">
                            <td>{{ \Carbon\Carbon::parse($data->created)->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $data->orderId }}</td>  
                            <td>{{ $data->name }}</td>  
                            <td>{{ $data->phoneNumber }}</td>  
                            <td>{{ $data->email }}</td>  
                            <td><?php if ($data->isActivated==1) echo "Yes"; else echo "No"; ?></td>
                            <td>{{ $data->channel }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
    </div>
</x-app-layout>