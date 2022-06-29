<x-app-layout>
    <x-slot name="header_content">
        <h1>Available Voucher</h1>        
    </x-slot>
    <div>
        <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th>Created</th>
                        <th>Customer Name</th>                        
                        <th>Registered</th>                        
                        <th>Channel</th>                        
                        <th></th> 
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($userList as $data)
                        <tr class="text-center">
                            <td>{{ \Carbon\Carbon::parse($data->created)->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $data->name }}</td>  
                            <td><?php if ($data->isActivated==1) echo "Yes"; else echo "No"; ?></td>
                            <td>{{ $data->channel }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
    </div>
</x-app-layout>