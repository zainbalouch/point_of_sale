@once
    <script>
        function openPrintPreview(url) {
            // Remove any existing print iframe
            const existingIframe = document.querySelector('iframe[style*="visibility: hidden"]');
            if (existingIframe) {
                existingIframe.remove();
            }

            var iframe = document.createElement('iframe');
            iframe.style.visibility = 'hidden';
            document.body.appendChild(iframe);

            iframe.src = url;

            iframe.onload = function() {
                iframe.contentWindow.print();
            };
        }
    </script>
    @if (session()->has('created_invoice_id'))
        @php
            $createdInvoiceId = session()->get('created_invoice_id');
        @endphp
        <script>
            openPrintPreview(@json(route('invoice.show', $createdInvoiceId)));
        </script>
    @endif
@endonce

