<x-app-layout>
    <x-slot name="header_content">
        <h1>Customer Data</h1>        
    </x-slot>
    <div>
        <x-userdata-table :datas="$datas" :custnamechosen="$custnamechosen"></x-userdata-table>
    </div>
</x-app-layout>


