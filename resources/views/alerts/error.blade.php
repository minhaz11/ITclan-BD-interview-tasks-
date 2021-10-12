@if (Session::has('error'))
   
        <script>
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
    })
            Toast.fire({
            icon: 'error',
            title: '{{ Session::get('error') }}'
            })
        </script>
   
@endif