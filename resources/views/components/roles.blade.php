<x-app-layout>
    <x-slot name="header_content">
        <h1>Roles</h1>        
    </x-slot>
    <div>

@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Roles</h4>
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
               
                    <form action="add_roles" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}} 

                        <div class="input-group mb-3">
                                <div class="col-3">Role Name</div>
                                <div class="col-7">
                                <input type="text" name="name" id="name" class="form-control" value="">
                                </div>                                                         
                          
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
                                    <th>Roles</th>
                                    <th>Created</th>                                   
                                    <th>Permission</th> 
                                    <th></th>                         
                                </tr>
                              
                            </thead>      
                             <tbody>

                                @foreach ($datas as $data)
                                    <tr class="text-center">
                                        <td>{{ $data->name}}</td>
                                        <td>{{ $data->created_at}}</td>
                                        <td><button class='btn btn-primary viewdetails' data-id='{{ $data->id }}' >View Permission</button></td>
                                        <td>
                                        <button class='btn btn-danger' data-id='{{ $data->id }}' onclick="deleteRoles({{ $data->id }})">Delete Role</button>    
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

            </div>
            <div class="col-1">
                 <form name="frmDelete" action="delete_roles" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}} 
                    <input type="hidden" name="deleteRoleId" id="deleteRoleId" value="">
                </form>
            </div>
            
        </div>       

    </div>
</div>

    </div>
</x-app-layout>

<script type="text/javascript">
     $('#table-4 tbody').on('click','.viewdetails',function(){
        
        var roleId = $(this).attr('data-id');
        console.log("roleId:"+roleId);
        if(roleId){

        // AJAX request
        var url = "{{ route('roles_permission',[':roleId']) }}";
        url = url.replace(':roleId',roleId);
        console.log("url:"+url);
        // Empty modal data
        $('#permissioninfo tbody').empty();

        $.ajax({
            url: url,
            dataType: 'json',
            success: function(response){

                console.log("response:"+response);
                // Add details
                $('#permissioninfo tbody').html(response.html);

                // Display Modal
                $('#PermissionModalDetails').modal('show'); 
            }
        });
        }
    });


     function deleteRoles(roleId) {
        if (confirm('Are you sure want to delete this role?')) {
            document.getElementById("deleteRoleId").value=roleId;
            document.frmDelete.submit();
        }
    }

</script>