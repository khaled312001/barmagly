# Screenshot Tool for Admin Dashboard

سكريبتات Python لأخذ screenshot للصفحة الكاملة من لوحة التحكم.

## المتطلبات

### الطريقة 1: استخدام Selenium

```bash
pip install selenium
```

تحميل ChromeDriver:
- Windows: تحميل من https://chromedriver.chromium.org/
- أو استخدام: `pip install webdriver-manager`

### الطريقة 2: استخدام Playwright (موصى به للصفحات الكاملة)

```bash
pip install playwright
playwright install chromium
```

## الاستخدام

### استخدام Selenium

```bash
python screenshot.py
```

أو مع معاملات مخصصة:
```bash
python screenshot.py http://127.0.0.1:8000/admin/dashboard output.png
```

### استخدام Playwright (الأفضل للصفحات الكاملة)

```bash
python screenshot_playwright.py
```

أو مع معاملات مخصصة:
```bash
python screenshot_playwright.py http://127.0.0.1:8000/admin/dashboard output.png
```

## المميزات

- ✅ يأخذ screenshot للصفحة الكاملة
- ✅ ينتظر تحميل الصفحة بالكامل
- ✅ يدعم السايد بار الكامل
- ✅ يعمل في الخلفية (headless mode)
- ✅ قابل للتخصيص

## ملاحظات

1. **Playwright** هو الأفضل لأخذ screenshot للصفحة الكاملة لأنه يدعم `full_page=True` بشكل أصلي
2. **Selenium** يحتاج إلى معالجة إضافية لأخذ screenshot للصفحة الكاملة
3. تأكد من أن الخادم يعمل على `http://127.0.0.1:8000` قبل تشغيل السكريبت

## تثبيت جميع المتطلبات

```bash
pip install -r requirements.txt
playwright install chromium
```

