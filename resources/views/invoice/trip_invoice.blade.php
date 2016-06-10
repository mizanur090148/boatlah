
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boatlah</title>

    <style>
        * {
            margin: 0;
            padding: 0;
        }
        html {
            font-family: sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        html, body {
            width: 100%;
            height: 100%;
        }
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            background-color: #fff;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
            max-width: 100%;
            width: 100%;
        }
        td,
        th {
            padding: 10px;
            vertical-align: top;
            line-height: 1.42857;
            text-align: left;
        }

        #wrapper {
            width: 940px;
            margin: auto;
            padding: 50px 0;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div>
        @if($invoice_header_image!=null)
            <img style="width: 100%; max-width: 100%; height: auto;" src="{{public_path().$invoice_header_image}}" alt="......" style="width: 100%">
        @endif
    </div>
    <table style="margin-bottom: 40px;">
        <tbody>
        <tr>
            <td><h1>BoatLah.com</h1></td>
            <td>
                <h2>Trip ID: {{$trip->trip_id}}</h2>
                <p>Date of invoice: {{date('d/m/Y')}}</p>
            </td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody>
        <tr>
            <td>
                <p><strong>To</strong></p>
                <p>
                    @if($trip->contract_company!=null) 
                        {{$trip->user->name}}
                    @else
                        {{$trip->user->name}}
                    @endif
                </p>
                <p>{{$trip->user->email}}</p>
            </td>
            <td>
                <p><strong>From</strong></p>
                <p>
                    {{$trip->owner->name}}
                </p>               
            </td>
        </tr>
        </tbody>
    </table>
    <table style="margin-top: 100px;">
        <thead>
        <tr>
            <th style="color: #777; border-bottom: 1px solid #e1e1e1;">Trip ID</th>
            <th style="color: #777; border-bottom: 1px solid #e1e1e1;">Price</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="border-bottom: 1px solid #e1e1e1;">{{$trip->trip_id}}</td>
            <td style="border-bottom: 1px solid #e1e1e1;">{{$trip->cost}}</td>
        </tr>
      
        </tbody>
    </table>

    <div style="padding-top: 40px;">
        {{--<img src="image src den na kere" alt="image src den na kere">--}}
        {{--<p>Thank you!</p>--}}
    </div>
    <div>
        @if($invoice_footer_image!=null)
            <img style="width: 100%; max-width: 100%; height: auto;" src="{{public_path().$invoice_footer_image}}" alt="......" style="width: 100%">
        @endif
    </div>
</div>



</body>
</html>