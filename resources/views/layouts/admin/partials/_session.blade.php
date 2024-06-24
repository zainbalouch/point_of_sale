@if(session('success'))
<script type="text/javascript">
Toastify({
    text: "{{ session('success') }}",
    duration: 5000,
    destination: "https://github.com/apvarun/toastify-js",
    newWindow: true,
    close: true,
    gravity: "top", // `top` or `bottom`
    position: "center", // `left`, `center` or `right`
    stopOnFocus: true, // Prevents dismissing of toast on hover
    className: "success",
    backgroundColor: "rgb(45, 203, 115)",
}).showToast();
</script>
@endif

@if(session('error'))
<script type="text/javascript">
Toastify({
    text: "{{ session('error') }}",
    duration: 100000,
    destination: "https://github.com/apvarun/toastify-js",
    newWindow: true,
    close: true,
    gravity: "top", // `top` or `bottom`
    position: "center", // `left`, `center` or `right`
    stopOnFocus: true, // Prevents dismissing of toast on hover
    className: "danger",
    backgroundColor: "rgb(255, 108, 108)",
}).showToast();
</script>
@endif