<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Room Booking Confirmed</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f5f7; color: #333333;-webkit-font-smoothing: antialiased;">

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f5f7; padding: 20px 0;">
    <tr>
        <td align="center">

            <!-- Main Container -->
            <table role="presentation" width="100%" id="email-container" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">

                <!-- Header Banner -->
                <tr>
                    <td align="center" style="background-color: #4f46e5; padding: 40px 20px; text-align: center;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px;">
                            Booking Confirmed!
                        </h1>
                        <p style="color: #e0e7ff; margin: 10px 0 0 0; font-size: 16px;">
                            Hi User, your room is ready for you.
                        </p>
                    </td>
                </tr>

                <!-- Body Content -->
                <tr>
                    <td style="padding: 30px 40px;">

                        <p style="font-size: 16px; line-height: 1.6; color: #4b5563; margin-top: 0;">
                            Your reservation at <strong>{{ config('app.name') }}</strong> has been successfully processed. Here are your booking details:
                        </p>

                        <!-- Booking Reference Card -->
                        <div style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 20px; margin: 25px 0;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="padding-bottom: 10px; font-size: 14px; color: #6b7280;">Booking Reference:</td>
                                    <td align="right" style="padding-bottom: 10px; font-size: 14px; font-weight: bold; color: #111827;">#{{  }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; font-size: 14px; color: #6b7280; border-top: 1px solid #f3f4f6;">Booking Space:</td>
                                    <td align="right" style="padding: 10px 0; font-size: 14px; font-weight: bold; color: #4f46e5; border-top: 1px solid #f3f4f6;">{{ $booking->room->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; font-size: 14px; color: #6b7280; border-top: 1px solid #f3f4f6;">Start Date/Time:</td>
                                    <td align="right" style="padding: 10px 0; font-size: 14px; color: #111827; border-top: 1px solid #f3f4f6;">
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('d-m-Y - g:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; font-size: 14px; color: #6b7280; border-top: 1px solid #f3f4f6;">End Date/Time:</td>
                                    <td align="right" style="padding: 10px 0; font-size: 14px; color: #111827; border-top: 1px solid #f3f4f6;">
                                        {{ \Carbon\Carbon::parse($booking->end_time)->format('d-m-Y - g:i A') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding-top: 10px; font-size: 14px; color: #6b7280; border-top: 1px solid #f3f4f6;">Amount Paid:</td>
                                    <td align="right" style="padding-top: 10px; font-size: 16px; font-weight: bold; color: #10b981; border-top: 1px solid #f3f4f6;">
                                        Booking_Price_Here
{{--                                            ${{ number_format($booking->total_price, 2) }}--}}
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <!-- Call to Action -->
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 30px 0 10px 0;">
                            <tr>
                                <td align="center">
{{--                                    <a href="{{ route('bookings.show', $booking->id) }}" style="background-color: #4f46e5; color: #ffffff; text-decoration: none; padding: 12px 30px; font-size: 15px; font-weight: 600; border-radius: 6px; display: inline-block; box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);">--}}
                                    <span style="background-color: #4f46e5; color: #ffffff; text-decoration: none; padding: 12px 30px; font-size: 15px; font-weight: 600; border-radius: 6px; display: inline-block; box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);">
                                        Manage Your Booking
                                    </span>
                                </td>
                            </tr>
                        </table>

                        <p style="font-size: 14px; line-height: 1.5; color: #6b7280; margin-top: 30px;">
                            Need to make changes or have questions? Just reply to this email or visit our Help Center.
                        </p>

                        <p style="font-size: 14px; color: #333333; margin: 20px 0 0 0; font-weight: 600;">
                            Cheers,<br>
                            The {{ config('app.name') }} Team
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color: #fafafa; padding: 24px 40px; text-align: center; border-top: 1px solid #f0f0f0;">
                        <p style="margin: 0; font-size: 12px; color: #9ca3af; line-height: 1.5;">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
                            You received this automated email because you made a reservation on our platform.
                        </p>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
