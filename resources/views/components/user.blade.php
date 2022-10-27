<x-app-layout>
    <x-slot name="header_content">
        <h1>Users</h1>        
    </x-slot>
    <div>

@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>User</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="row">
            <div class="col-12">
               
                    <form action="add_user" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}} 

                        <div class="input-group mb-3">
                            <div class="col-3">Name</div>
                            <div class="col-7">
                            <input type="text" name="name" id="name" class="form-control" value="">
                            </div>                                 
                        </div> 

                        <div class="input-group mb-3">
                            <div class="col-3">Email</div>
                            <div class="col-7">
                            <input type="text" name="email" id="email" class="form-control" value="">
                            </div>                                 
                        </div> 

                        <div class="input-group mb-3">
                            <div class="col-3">Channel</div>
                            <div class="col-7">
                                <select name="selectChannel" id="selectChannel" class="form-control">   
                                    <option value="">Select Channel</option>                         
                                    @foreach ($channelList as $channel)
                                    <option value="{{$channel}}" <?php if ($channelSelected==$channel) echo "selected"; ?>>{{$channel}}</option>                            
                                    @endforeach
                                </select>          
                            </div>                           
                        </div> 

                        <div class="input-group mb-3">
                            <div class="col-3">Roles</div>
                            <div class="col-7">
                                <select name="selectRoles" id="selectRoles" class="form-control">   
                                    <option value="">Select Roles</option>                         
                                    @foreach ($rolesList as $roles)
                                    <option value="{{$roles->id}}" <?php if ($rolesSelected==$roles->id) echo "selected"; ?>>{{$roles->name}}</option>                            
                                    @endforeach
                                </select> 
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> <span>Add</span></button>
                                </div>     
                            </div>          
                        </div>                                   
                    </form>

                    <div id="searchResultList">                        
                    </div>

                    <div class="table-responsive">
                        <table id="table-4" class="table table-striped">        
                            <thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>                                   
                                    <th>Channel</th>                                   
                                    <th></th> 
                                    <th></th>                         
                                </tr>
                              
                            </thead>      
                             <tbody>

                                @foreach ($datas as $data)
                                    <tr class="text-center">
                                        <td>{{ $data->name}}</td>
                                        <td>{{ $data->email}}</td>
                                        <td>{{ $data->rolesName }}</td>
                                        <td>{{ $data->channel}}</td>    
                                         <td>
                                        <button class='btn btn-danger' data-id='{{ $data->id }}' onclick="deleteUser({{ $data->id }})">Delete User</button>    
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

            </div>
            <div class="col-1">
                <form name="frmDelete" action="delete_user" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}} 
                    <input type="hidden" name="deleteUserId" id="deleteUserId" value="">
                </form>
            </div>
            
        </div>       

    </div>
</div>

    </div>
</x-app-layout>
<script type="text/javascript">
    function deleteUser(userId) {
        if (confirm('Are you sure want to delete this user?')) {
            document.getElementById("deleteUserId").value=userId;
            document.frmDelete.submit();
        }
    }
</script>