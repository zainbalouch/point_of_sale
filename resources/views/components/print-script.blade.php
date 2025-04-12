@once
    <script>
        function openPrintPreview(url) {
            var iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);

            iframe.src = url;

            iframe.onload = function() {
                iframe.contentWindow.print();

                setTimeout(function() {
                    document.body.removeChild(iframe);
                }, 2000);
            };
        }
    </script>
@endonce
