<<<<<<< HEAD

=======
>>>>>>> 98c86bc (store order with order item)
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Platform</title>
    <style>
        /* Inline styles for simplicity, consider using CSS classes for larger templates */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f1f1f1;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 200px;
        }

        .message {
            padding: 20px;
            background-color: #ffffff;
        }

        .message p {
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">


        <div class="message">

            <p>Dear Customer,<br>
                Your Order :
                <br><br>
===================                
<br>
            @foreach ($mailData['item'] as $items)

            @foreach ( $items as $key=>$value)


                    {{ $key }} : {{ $value }}


            @endforeach

            <br><br>
            @endforeach

<br>
            Total Price : {{ $mailData['total'] }}
            <br><br>
            <p>Thank you for providing your Email with Multishop.
        </div>

    </div>
</body>

</html>
