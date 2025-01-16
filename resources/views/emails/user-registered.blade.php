<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activeer uw account</title>
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: ct_font_greycliff_-__manual_, sans-serif;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Wider layout */
            margin: 30px auto;
            background-color: #ffffff;
            overflow: hidden;
        }

        .card-body {
            padding: 40px; /* Spacious layout */
            text-align: center;
        }

        .card-body img {
            max-width: 250px; /* Bigger logo */
            margin-bottom: 30px;
        }

        .card-body h1 {
            font-size: 28px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 20px;
        }

        .card-body p {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .card-body p:last-of-type {
            margin-bottom: 10px; /* Reduce space after the last paragraph */
        }

        .card-body strong {
            color: #FFA532;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 50px;
            background: linear-gradient(90deg, #EC507C, #FF9939);
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 50px;
            text-transform: uppercase;
            transition: background 0.3s ease-in-out;
        }

        .cta-button:hover {
            background: linear-gradient(90deg, #d94b6c, #e6882e);
        }

        .email-link {
            color: #007bff; /* Blue color from the screenshot */
            text-decoration: none; /* No underline */
        }

        .email-link:hover {
            color: #0056b3; /* Darker blue on hover */
        }

        .footer {
            margin-top: 5px; /* Further reduce space */
            text-align: center;
            color: #6c757d;
            font-size: 16px;
            padding: 15px; /* Slightly smaller padding */
            background-color: #f9f9f9;
            border-top: 1px solid #eeeeee;
        }

        .footer a {
            color: #007bff; /* Blue for URL in the footer */
            text-decoration: none;
        }

        .footer a:hover {
            color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
<div class="card">
    <div class="card-body">
        <img src="https://intranet.2befresh.nl/uploads/new-2befresh-logo-full.png" alt="2BeFresh Logo">
        <h1>Activeer uw account</h1>
        <p>Hallo <strong>{{ $firstName }} {{ $lastName }}</strong>,</p>
        <p>Welkom bij <strong>2BeFresh!</strong> We zijn verheugd u te verwelkomen. Om aan de slag te gaan, activeer uw account door op de onderstaande knop te klikken:</p>
        <a href="{{ $verificationUrl }}" class="cta-button">Activeer uw account</a>
        <p>Deze stap is noodzakelijk om toegang te krijgen tot uw account en alle functies van <strong>2BeFresh</strong>.</p>
        <p>Heeft u vragen of hulp nodig? Neem gerust contact op met ons ondersteuningsteam via <a href="mailto:support@2befresh.nl" class="email-link">support@2befresh.nl</a>.</p>
        <p>Met vriendelijke groet,<br>Het 2BeFresh Team</p>
    </div>
    <div class="footer">
        <p>Als u problemen ondervindt bij het klikken op de knop "Activeer uw account", kopieer en plak de onderstaande URL in uw webbrowser:</p>
        <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
    </div>
</div>
</body>
</html>
