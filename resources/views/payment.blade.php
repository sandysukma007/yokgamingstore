<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
</head>
<body>
    <h1>Payment Page</h1>
    <form action="https://app.midtrans.com/snap/v1/transactions" method="POST" id="payment-form">

        <input type="hidden" name="token" id="snap-token" value="{{ $snapToken }}">
        <button type="submit">Pay Now</button>
    </form>

    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        var snapToken = document.getElementById('snap-token').value;
        snap.pay(snapToken, {
            onSuccess: function(result) {
                alert("Payment success!"); // Handle success
            },
            onPending: function(result) {
                alert("Waiting for payment confirmation..."); // Handle pending
            },
            onError: function(result) {
                alert("Payment failed!"); // Handle error
            }
        });
    </script>
</body>
</html>
