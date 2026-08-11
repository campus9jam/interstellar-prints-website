<?php
/**
 * Interstellar Prints Global Ltd. — Email Formatting & Sending
 * Uses PHP mail() (works with cPanel hosting mail server).
 */

require_once __DIR__ . '/../config.php';

/**
 * Send an HTML email with order details.
 */
function send_order_email($to, $subject, $order_ref, $data, $type = 'quote') {
    $rows_html = '';
    foreach ($data as $label => $value) {
        if ($value === '' || $value === null) continue;
        $rows_html .= "<tr>"
            . "<td style='padding:8px 16px;color:#6b7280;font-size:13px;border-bottom:1px solid #e5e7eb;width:40%;'>"
            . htmlspecialchars($label)
            . "</td>"
            . "<td style='padding:8px 16px;color:#1f2937;font-size:14px;font-weight:500;border-bottom:1px solid #e5e7eb;'>"
            . htmlspecialchars($value)
            . "</td></tr>";
    }

    $type_label = $type === 'logistics' ? 'Logistics / Delivery Booking' : 'Stationery / Merchandise Quote';
    $accent_color = '#0ea5e9';
    $navy = '#03162e';

    $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:Inter,Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:32px 0;">
    <tr><td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

        <!-- Header -->
        <tr>
          <td style="background:linear-gradient(135deg,{$navy} 0%,#0a2d5c 100%);padding:32px 40px;text-align:center;">
            <h1 style="margin:0;color:#fff;font-size:22px;font-family:Montserrat,sans-serif;letter-spacing:1px;">INTERSTELLAR PRINTS GLOBAL</h1>
            <p style="margin:4px 0 0;color:#38bdf8;font-size:11px;letter-spacing:3px;text-transform:uppercase;">Your Brand, Everywhere</p>
          </td>
        </tr>

        <!-- Order Reference -->
        <tr>
          <td style="padding:24px 40px;background:#f8fafc;border-bottom:1px solid #e5e7eb;">
            <p style="margin:0 0 4px;color:#6b7280;font-size:13px;">New {$type_label}</p>
            <p style="margin:0;color:{$navy};font-size:20px;font-weight:700;font-family:Montserrat,sans-serif;">Order Ref: {$order_ref}</p>
          </td>
        </tr>

        <!-- Details -->
        <tr>
          <td style="padding:24px 40px;">
            <table width="100%" cellpadding="0" cellspacing="0">
              {$rows_html}
            </table>
          </td>
        </tr>

        <!-- Footer -->
        <tr>
          <td style="padding:20px 40px;background:{$navy};">
            <p style="margin:0;color:#9ca3af;font-size:12px;text-align:center;">
              This order was submitted via your website.<br>
              Reply to the customer's email or call them directly to proceed.
            </p>
          </td>
        </tr>

      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;

    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . COMPANY_NAME . ' <' . SENDER_EMAIL . '>',
        'Reply-To: noreply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost'),
        'X-Mailer: PHP/' . phpversion(),
    ];

    return mail($to, $subject, $html, implode("\r\n", $headers));
}
