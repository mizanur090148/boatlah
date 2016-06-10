<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BoatLah</title>
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

        html,
        body {
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
        .table td{
            border-top: 1px solid #e1e1e1;
        }
    </style>
</head>

<body>
<div id="wrapper">
    <table style="margin-bottom: 40px;">
        <tbody>
        <tr>
            <td style="padding: 0;">
                <table>
                    <tr>
                        <td style="text-align: center; border: 1px solid #111; border-bottom: 0;">
                            @if($invoice_header_image!=null)
                                <img style="width: 960px; max-width: 960px; height: auto;" src="{{public_path().$invoice_header_image}}" alt="......" >
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 0;">
                <table>
                    <tr>
                        <td style="border: 1px solid #111; padding: 0;">
                            <table>
                                <tr>
                                    <td style="border-bottom: 1px solid #111; text-align: center;">INVOICE TO</td>
                                </tr>
                                <tr rowspan="3">
                                    <td>
                                        {{$user_data['name']}} <br/> {{$user_data['address']}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="border: 1px solid #111; padding: 0;">
                            <table>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="2" style="border-top: 1px solid #111; padding: 0;">
                            <table>
                                <tr>
                                    <td style="border-bottom: 1px solid #111; border-right: 1px solid #111; width: 30%">INVOICE NO.</td>
                                    <td style="border: 1px solid #111; border-top: 0;">{{$trip->invoice_code}}</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #111; border-right: 1px solid #111; width: 30%">DATE</td>
                                    <td style="border: 1px solid #111; border-top: 0;">{{date('d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #111; border-right: 1px solid #111; width: 30%">ORIGIN</td>
                                    <td style="border: 1px solid #111; border-top: 0;">origin </td>
                                </tr>
                                <tr>
                                    <td style="border-right: 1px solid #111; width: 30%">TERMS</td>
                                    <td style="border: 1px solid #111; border-bottom: 0;">terms</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="font-weight: bold; text-align: center; border: 1px solid #111;">TRIP DETAILS</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #111;">Passenger Name</td>
                        <td style="border: 1px solid #111;">ORIGIN</td>
                        <td style="border: 1px solid #111;">DESTINATION</td>
                        <td style="border: 1px solid #111;">VESSEL NAME</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #111;">{{$trip->passenger_name}}</td>
                        <td style="border: 1px solid #111;">{{$trip->start->title}}</td>
                        <td style="border: 1px solid #111;">{{$trip->destination->title}}</td>
                        <td style="border: 1px solid #111;">{{$trip->vessel_name}}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #111; padding: 0;">
                            <table>
                                <tr>
                                    <td>Start Date & Time</td>
                                </tr>
                                <tr>
                                    <td>End Date & Time</td>
                                </tr>
                                <tr>
                                    <td>Total Trip Time</td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="3" style="border: 1px solid #111; padding: 0;">
                            <table>
                                <tr>
                                    <td style="border-bottom: 1px solid #111;">{{date('Y-m-d H:i:s',$trip->started_at)}}</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #111;">{{date('Y-m-d H:i:s',$trip->completed_at)}}</td>
                                </tr>
                                <tr>
                                    <td>Total Trip Time</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 0;">
                <table>
                    <tr>
                        <td style="font-weight: bold; border: 1px solid #111;">Description</td>
                        <td style="font-weight: bold; border: 1px solid #111;">Qty</td>
                        <td style="font-weight: bold; border: 1px solid #111;">Rate</td>
                        <td style="font-weight: bold; border: 1px solid #111;">Amount</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #111;">Boat Charges for the trip</td>
                        <td style="border: 1px solid #111;"></td>
                        <td style="border: 1px solid #111;"></td>
                        <td style="border: 1px solid #111;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #111;">Additional charges for extra Time</td>
                        <td style="border: 1px solid #111;"></td>
                        <td style="border: 1px solid #111;"></td>
                        <td style="border: 1px solid #111;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #111;">Fuel Surcharge</td>
                        <td style="border: 1px solid #111;"></td>
                        <td style="border: 1px solid #111;"></td>
                        <td style="border: 1px solid #111;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #111;">Total </td>
                        <td style="border: 1px solid #111;"></td>
                        <td style="border: 1px solid #111;"></td>
                        <td style="border: 1px solid #111;">{{$trip->cost}}</td>
                    </tr>
                    <tr>
                        <td style="border-left: 1px solid #111;">GST</td>
                        <td></td>
                        <td>7%</td>
                        <td style="border: 1px solid #111;"></td>
                    </tr>
                    <tr>
                        <td style="border-left: 1px solid #111;">Total Invoice Amount</td>
                        <td></td>
                        <td>900</td>
                        <td style="border: 1px solid #111;">{{$trip->cost}}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: center; border: 1px solid #111; border-bottom: none;">{{ucfirst($amount_in_words)}} SGD Only</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 0;">
                <table>
                    <tr>
                        <td style="text-align: center; border: 1px solid #111;">{{$trip->remarks}}</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; border: 1px solid #111;">This is an auto-generated Invoice. No signature is required.</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; border: 1px solid #111;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; border: 1px solid #111;">
                            @if($invoice_footer_image!=null)
                                <img style="width: 960px; max-width: 960px; height: auto;" src="{{public_path().$invoice_footer_image}}" alt="......" >
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; border: 1px solid #111;">Powered by <img src="{{public_path().'/images/logo.png'}}" alt="Logo"></td>
                    </tr>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

</div>
</body>

</html>
