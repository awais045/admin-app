<x-admin.wrapper>
    <x-slot name="title">
            {{ __($title) }}
    </x-slot>

    <div class="w-full py-2 overflow-hidden">
        {!! form($form) !!}
    </div>


<script>
//    window.addEventListener('DOMContentLoaded', function() {
//     let dbType = document.getElementById('db_type');
//     let hostnameField = document.getElementById('hostname');
//     let dbUserField = document.getElementById('db_user');
//     let dbPasswordField = document.getElementById('db_password');
// console.log(dbType)
//     if (dbType && hostnameField && dbUserField && dbPasswordField) {
//         function toggleFields() {
//             if (dbType.value === 'local') {
//                 hostnameField.disabled = true;
//                 dbUserField.disabled = true;
//                 dbPasswordField.disabled = true;
//                 hostnameField.value = '';
//                 dbUserField.value = '';
//                 dbPasswordField.value = '';
//             } else {
//                 hostnameField.disabled = false;
//                 dbUserField.disabled = false;
//                 dbPasswordField.disabled = false;
//             }
//         }

//         dbType.addEventListener('change', toggleFields);
//         toggleFields(); // Run on page load to set initial state
//     } else {
//         console.error("One or more form elements not found in the DOM.");
//     }
// });


</script>

</x-admin.wrapper>
