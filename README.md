# Edzeery Laravel Status Kit

[![Latest Version on Packagist](https://img.shields.io/packagist/v/edzeery/mystatuskit.svg)](https://packagist.org/packages/edzeery/mystatuskit)
[![Total Downloads](https://img.shields.io/packagist/dt/edzeery/mystatuskit.svg)](https://packagist.org/packages/edzeery/mystatuskit)
[![License](https://img.shields.io/packagist/l/edzeery/mystatuskit.svg)](https://github.com/Edzeery/mystatuskit/blob/main/LICENSE)

مكتبة موحّدة لإدارة **ألوان وأيقونات الحالات** (Status Colors & Badges) في أي مشروع Laravel — بدون أي اعتماد على Filament أو أي حزمة UI خارجية.

تدعم: `payment`, `subscription`, `user`, `stores`, `order`, `product`, `role`, `general` — وأي نطاق مخصص تضيفه أنت.

---

## 1. التثبيت

الحزمة منشورة الآن رسميًا على **[Packagist](https://packagist.org/packages/edzeery/mystatuskit)**، بالإضافة إلى المصدر على GitHub: **https://github.com/Edzeery/mystatuskit**

### أ) الطريقة الموصى بها — Packagist (سطر واحد، بدون أي إعداد إضافي)
```bash
composer require edzeery/mystatuskit
```
هذا كافٍ فـ أي مشروع Laravel، بلا حاجة لإضافة `repositories` فـ `composer.json`. Composer يجيب أحدث نسخة مستقرة متوافقة تلقائيًا حسب [Semantic Versioning](https://semver.org).

للتقييد بنسخة رئيسية معينة (اختياري):
```bash
composer require edzeery/mystatuskit:^1.0
```

### ب) البديل: مستودع VCS مباشرة من GitHub
مفيد إذا بغيت commit معيّن قبل ما يوصل Packagist (نادر، Packagist يتحدّث أوتوماتيكيًا عبر webhook)، أو لأي سبب آخر تفضّل فيه GitHub مباشرة:
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Edzeery/mystatuskit"
        }
    ],
    "require": {
        "edzeery/mystatuskit": "^1.0"
    }
}
```
ثم:
```bash
composer update edzeery/mystatuskit
```

### ج) للتطوير المحلي فقط (بدون GitHub، نفس الجهاز)
```json
"repositories": [
    { "type": "path", "url": "../laravel-status-kit" }
]
```
مفيد أثناء تطوير الحزمة نفسها: أي تعديل ينعكس فورًا بدون commit/push/تاغ جديد.

> **الطريقتان (ب) و(ج) يبقيان يشتغلوا بشكل طبيعي حتى بعد النشر على Packagist** — مفيدين تحديدًا وقت تطوير الحزمة نفسها أو اختبار تعديل قبل ما يوصل لـ Release رسمي.

الحزمة تُسجَّل تلقائيًا (Auto-Discovery) في كل الحالات أعلاه. لا حاجة لإضافة Provider يدويًا.

### د) نشر الملفات القابلة للتخصيص (اختياري لكن مُستحسن)
```bash
php artisan vendor:publish --tag=status-kit-config   # config/icons.php + config/statuses.php + config/status-kit-theme.php
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

## 2.5 اختيار فريموورك الألوان (Bootstrap 5 أو Tailwind)

الحزمة تدعم فريمووركين للألوان/البادج، افتراضيًا **Bootstrap 5** (`text-bg-success`, `text-bg-danger`...):

```bash
php artisan vendor:publish --tag=status-kit-config   # ينشر config/status-kit-theme.php أيضًا
```

فـ `config/status-kit-theme.php`:
```php
'default_framework' => 'bootstrap', // أو 'tailwind' لاستعمال كلاسات light/dark القديمة من statuses.php
```

يمكن أيضًا تجاوز الافتراضي لكل استدعاء على حدة:
```php
Status::for('payment', 'paid')->color(framework: 'tailwind');
Status::for('payment', 'paid')->badge(framework: 'tailwind');
```

> Bootstrap 5.1+ يوفر كلاسات `text-bg-*` جاهزة بلا أي CSS إضافي. إذا مشروعك Tailwind، بدّل الإعداد لـ `'tailwind'` وستُستعمل كلاسات `light`/`dark` اليدوية المعرّفة مع كل حالة في `config/statuses.php`.

---

## 3. الاستعمال

### Facade
```php
use Edzeery\MyStatusKit\Facades\Status;

Status::for('payment', 'paid')->color();       // "text-bg-success" (Bootstrap 5) — أو Tailwind إذا بدّلت الframework، راجع القسم أعلاه
Status::for('payment', 'paid')->hex();          // "#16a34a"
Status::for('payment', 'paid')->variant();      // "success"
Status::for('payment', 'paid')->label();        // مترجمة حسب اللغة الحالية
Status::for('payment', 'paid')->icon('fa');     // <i class="fas fa-check-circle"></i>
Status::for('payment', 'paid')->badge('ion');   // HTML بادج كامل جاهز
Status::for('payment', 'paid')->toArray();      // لإرساله كـ JSON مثلاً في API

// بادجات عامة جاهزة (نطاق "general") قابلة للاستعمال فوق أي عنصر
Status::for('general', 'featured')->badge('fa');     // ⭐ مميز — أصفر
Status::for('general', 'new')->badge('bi');          // جديد — أزرق
Status::for('general', 'popular')->badge('ion');     // الأكثر رواجًا — أحمر
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
<x-status-badge domain="general" status="featured" set="fa" />
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

## 7. الإصدارات (Releases)

عند إصدار تحديث جديد للحزمة مستقبلًا:
1. عدّل الكود ثم ادفعه لفرع `main` (عبر GitHub Desktop أو `git push`).
2. من GitHub: `Releases → Draft a new release` → أنشئ Tag جديد يتبع [Semantic Versioning](https://semver.org):
   - إصلاح بسيط (bug fix) → `v1.0.1`
   - ميزة جديدة متوافقة رجوعيًا → `v1.1.0`
   - تغيير يكسر التوافق (breaking change) → `v2.0.0`
3. **Packagist يتحدّث أوتوماتيكيًا** عبر الـ GitHub webhook فور نشر Tag جديد (بشرط تفعيل الـ webhook من صفحة الحزمة على packagist.org — راجع "Settings" فيها إذا توقف التحديث لأي سبب).
4. المشاريع التي تستعمل `"edzeery/mystatuskit": "^1.0"` (أو `composer require edzeery/mystatuskit` بلا تقييد) ستحصل على التحديثات المتوافقة تلقائيًا عبر `composer update`، بدون كسر أي مشروع يستخدم إصدار أقدم.

راجع [CHANGELOG.md](CHANGELOG.md) لتفاصيل كل إصدار.

آخر إصدار حالي: **v1.0.2**

---

## المتطلبات
- PHP `^8.1`
- Laravel `^10 | ^11 | ^12 | ^13`
- Bootstrap 5.1+ (الافتراضي، عبر كلاسات `text-bg-*`) أو Tailwind CSS (اختياري عبر `config/status-kit-theme.php`) — أو استخدم `hex()` مع أي نظام تنسيق آخر.