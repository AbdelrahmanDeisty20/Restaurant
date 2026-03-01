<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 8px; }
        .code { font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #e74c3c; text-align: center; padding: 20px; background: #f8f8f8; border-radius: 8px; margin: 20px 0; }
        .note { color: #888; font-size: 13px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>مرحباً {{ $name }}</h2>
        <p>كود التحقق الخاص بتسجيل حسابك:</p>
        <div class="code">{{ $code }}</div>
        <p class="note">⏱ صالح لمدة <strong>10 دقائق</strong> فقط.</p>
        <p class="note">إذا لم تطلب هذا الكود، تجاهل هذا الإيميل.</p>
    </div>
</body>
</html>
