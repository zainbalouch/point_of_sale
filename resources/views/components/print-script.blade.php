@once
    <script>
        function openPrintPreview(url) {
            // Check if it's a mobile device
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

            if (isMobile) {
                // For mobile devices, open in new window and print
                const printWindow = window.open(url, '_blank');
                printWindow.onload = function() {
                    // Add print-specific styles
                    const style = printWindow.document.createElement('style');
                    style.textContent = `
                        @media print {
                            body {
                                background-color: white !important;
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                            }
                            * {
                                background-color: transparent !important;
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                            }
                            img {
                                background-color: transparent !important;
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                            }
                        }
                    `;
                    printWindow.document.head.appendChild(style);
                    printWindow.print();
                };
            } else {
                // For desktop browsers, use iframe approach
                const existingIframe = document.querySelector('iframe[style*="visibility: hidden"]');
                if (existingIframe) {
                    existingIframe.remove();
                }

                var iframe = document.createElement('iframe');
                iframe.style.visibility = 'hidden';
                document.body.appendChild(iframe);

                iframe.src = url;

                iframe.onload = function() {
                    // Add print-specific styles for desktop as well
                    const style = iframe.contentDocument.createElement('style');
                    style.textContent = `
                        @media print {
                            body {
                                background-color: white !important;
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                            }
                            * {
                                background-color: white !important;
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                            }
                            img {
                                background-color: transparent !important;
                                -webkit-print-color-adjust: exact !important;
                                print-color-adjust: exact !important;
                            }
                        }
                    `;
                    iframe.contentDocument.head.appendChild(style);
                    iframe.contentWindow.print();
                };
            }
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

