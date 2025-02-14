<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
</head>

<body>
    <form action="https://app.midtrans.com/snap/v1/transactions" method="POST" id="payment-form">

        <input type="hidden" name="token" id="snap-token" value="{{ $snapToken }}">
        <button type="submit">Pay Now</button>
    </form>

    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        var snapToken = document.getElementById('snap-token').value;
        var cartItems = {!! $cartItems !!}; // Ambil data dari Blade

        console.log("Data keranjang yang dikirim:", cartItems);

        snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log("onSuccess dipanggil!", result);
                alert("Payment success!");

                let payload = {
                    order_id: result.order_id,
                    gross_amount: result.gross_amount,
                    transaction_status: result.transaction_status,
                    item_details: cartItems // Kirim item dari database
                };

                fetch("{{ route('payment.success') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Response dari server:", data);
                        if (data.success) {
                            window.location.href = "/payment/success"; // Redirect ke halaman sukses
                        }
                    })
                    .catch(error => console.error("Fetch error:", error));
            },
            onPending: function(result) {
                alert("Waiting for payment confirmation...");
            },
            onError: function(result) {
                alert("Payment failed!");
            }
        });
    </script>


</body>

</html>
