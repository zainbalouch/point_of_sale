@once
    <script>
        function openPrintPreview(url) {
            // For desktop browsers, use iframe approach
            const existingIframe = document.querySelector('iframe[style*="visibility: hidden"]');
            if (existingIframe) {
                existingIframe.remove();
            }

            var iframe = document.createElement('iframe');
            iframe.style.visibility = 'hidden';

            document.body.appendChild(iframe);

            iframe.src = url;

            // iframe.onload = function() {
            //     iframe.contentWindow.print();

            //     setTimeout(function() {
            //         document.body.removeChild(iframe);
            //     }, 2000);
            // };
        }

        function downloadPDF(url) {
            // Create a temporary link element
            const link = document.createElement('a');
            link.href = url;
            link.target = '_blank';
            link.download = 'invoice.pdf';

            // Append to body, click and remove
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
    @if (session()->has('created_invoice_id'))
        @php
            $createdInvoiceId = session()->get('created_invoice_id');
        @endphp
        <script>
            // Check if it's a mobile device
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

            if (isMobile) {
                // For mobile devices, use direct download
                downloadPDF(@json(route('invoice.show', $createdInvoiceId)));
            } else {
                // For desktop, use print preview
                openPrintPreview(@json(route('invoice.show', $createdInvoiceId)));
            }
        </script>
    @endif
@endonce
