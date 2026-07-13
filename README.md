# Laravel Status Kit

مكتبة موحّدة لإدارة **ألوان وأيقونات الحالات** (Status Colors & Badges) في أي مشروع Laravel — بدون أي اعتماد على Filament أو أي حزمة UI خارجية.

تدعم: `payment`, `subscription`, `user`, `stores`, `order`, `product`, `role`, `general` — وأي نطاق مخصص تضيفه أنت.

---

## 1. التثبيت

### أ) عبر Composer (من مستودع محلي/خاص)
```bash
composer require edzeery/my-status-kit
```
> إن لم تُنشر الحزمة على Packagist بعد، أضف مستودعها في `composer.json` الخاص بمشروعك:
> ```json
> "repositories": [
>   { "type": "path", "url": "../laravel-status-kit" }
> ]
> ```

الحزمة تُسجَّل تلقائيًا (Auto-Discovery). لا حاجة لإضافة Provider يدويًا.

### ب) نشر الملفات القابلة للتخصيص (اختياري لكن مُستحسن)
```bash
php artisan vendor:publish --tag=status-kit-config   # config/icons.php + config/statuses.php
php artisan vendor:publish --tag=status-kit-lang      # lang/vendor/status-kit/{ar,en,fr}
php artisan vendor:publish --tag=status-kit-views     # قالب البادج
php artisan vendor:publish --tag=status-kit-svg       # ملفات heroicons SVG
```

---

## 2. تثبيت مكتبات الأيقونات (FontAwesome / Bootstrap Icons / Ionicons)

هذه المكتبات هي أصول Frontend (CSS/JS) وليست حزم Composer، لذا هناك 3 طرق — اختر ما يناسبك:

### الطريقة الأسرع: CDN جاهز من الحزمة نفسها
أضف في `<head>` من `layout` الرئيسي:
```blade
@statusKitAssets(['fa', 'bi', 'ion'])
```
أو من PHP:
```php
{!! status_kit_assets(['fa', 'ion']) !!}
```
هذا يُدرج روابط CDN المعرّفة في `config/icons.php['cdn']` تلقائيًا. **مناسب للتطوير السريع**، لكن يعتمد على اتصال خارجي.

### الطريقة الموصى بها للإنتاج: تثبيت محلي عبر NPM
```bash
npm install @fortawesome/fontawesome-free bootstrap-icons ionicons
```
ثم في `resources/js/app.js` أو `resources/css/app.css`:
```css
@import '@fortawesome/fontawesome-free/css/all.min.css';
@import 'bootstrap-icons/font/bootstrap-icons.css';
```
```js
import 'ionicons/dist/ionicons.js'; // أو عبر <script type="module"> في blade
```
ثم `npm run build`.

### الطريقة اليدوية: تحميل وتحفيظ محلي
حمّل الملفات من المصادر الرسمية وضعها في `public/vendor/`:
- FontAwesome: https://fontawesome.com/download
- Bootstrap Icons: https://icons.getbootstrap.com
- Ionicons: https://ionic.io/ionicons

ثم أضف الروابط يدويًا في layout بدل `@statusKitAssets`.

> **ملاحظة Heroicons**: لا تحتاج أي تثبيت — ملفات SVG مضمّنة داخل الحزمة (`resources/svg/heroicons`) وتُعرض مباشرة بدون خط خارجي. الأيقونات المرفقة هي نسخ مبسّطة (placeholder) بنفس تسمية Heroicons الرسمية؛ لمطابقة بصرية 100% استبدل الملفات بالنسخة الأصلية من [heroicons.com](https://heroicons.com) أو `npm i heroicons` ثم انسخها لنفس المجلد بنفس الأسماء.

---

## 3. الاستعمال

### Facade
```php
use Edzeery\MyStatusKit\Facades\Status;

Status::for('payment', 'paid')->color();       // "text-green-700 bg-green-100 dark:text-green-300 dark:bg-green-900/40"
Status::for('payment', 'paid')->hex();          // "#16a34a"
Status::for('payment', 'paid')->variant();      // "success"
Status::for('payment', 'paid')->label();        // مترجمة حسب اللغة الحالية
Status::for('payment', 'paid')->icon('fa');     // <i class="fas fa-check-circle"></i>
Status::for('payment', 'paid')->badge('ion');   // HTML بادج كامل جاهز
Status::for('payment', 'paid')->toArray();      // لإرساله كـ JSON مثلاً في API
```

### Helpers (نفس أسلوب المكتبة القديمة، متوافقة رجوعيًا)
```php
status_color('subscription', 'active');
status_hex('subscription', 'active');
status_label('subscription', 'active', 'fr');   // فرض لغة معينة
status_icon('subscription', 'active', 'bi');
status_badge('subscription', 'active');

icon('paid', 'fa', 'text-lg');                  // كما في المكتبة القديمة تمامًا
svg_icon('custom-logo', 'w-6 h-6');              // من resources/svg
getIconHtml('paid');                             // متوافقة كليًا مع النسخة القديمة
```

### Blade Component
```blade
<x-status-badge domain="payment" status="paid" set="fa" />
<x-status-badge domain="user" status="banned" set="heroicon" class="text-sm" />
```

### الأدوار (roles.php سابقًا أصبحت نطاق "role")
```php
Status::for('role', 'super_admin')->badge('heroicon');
```

---

## 4. إضافة نطاق أو حالة جديدة

بعد نشر `config/statuses.php`، أضف مباشرة:
```php
'invoice' => [
    'draft' => ['variant' => 'gray', 'light' => 'text-gray-700 bg-gray-100', 'dark' => 'dark:text-gray-300 dark:bg-gray-800', 'hex' => '#9ca3af', 'icon' => 'draft'],
],
```
وأضف الترجمة في `lang/vendor/status-kit/{ar,en,fr}/statuses.php`:
```php
'invoice' => ['draft' => 'مسودة'],
```

---

## 5. جدول الترحيل من الملفات القديمة

| القديم | الجديد |
|---|---|
| `config('payment-colors.payment.paid')` | `Status::for('payment', 'paid')->color()` |
| `config('subscription-colors.subscription.active')` | `Status::for('subscription', 'active')->color()` |
| `config('status-colors.order.pending')` | `Status::for('order', 'pending')->color()` |
| `config('roles.admin')` | `Status::for('role', 'admin')` |
| `icon('paid', 'fa')` | نفسها بدون تغيير |
| `getIconHtml(...)` | نفسها بدون تغيير |
| مفتاح `filament` | أصبح `variant` (نفس المعنى، بدون اعتماد على Filament) |
| أيقونات `heroicon-o-*` | أصبحت مفاتيح عامة (`icon` في statuses.php) تُترجم حسب `$set` وقت العرض |

---

## 6. البنية الداخلية (لمن يريد التخصيص العميق)
- `IconManager` — كل منطق عرض الأيقونات (fa/bi/ion/heroicon/svg).
- `StatusManager` — قراءة config وبناء `StatusResult`.
- `StatusResult` — DTO بواجهة fluent (`->color()->icon()->label()...`).
- كل شيء مسجّل كـ Singleton في `StatusKitServiceProvider`.

---

## المتطلبات
- PHP `^8.1`
- Laravel `^10 | ^11 | ^12`
- Tailwind CSS (للكلاسات الجاهزة في `light`/`dark`) — أو استخدم `hex()` مع أي نظام تنسيق آخر.
