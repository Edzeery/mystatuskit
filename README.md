# MyStatusKit — Laravel Status Kit

### (`edzeery/mystatuskit`)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/edzeery/mystatuskit.svg)](https://packagist.org/packages/edzeery/mystatuskit)
[![Total Downloads](https://img.shields.io/packagist/dt/edzeery/mystatuskit.svg)](https://packagist.org/packages/edzeery/mystatuskit)
[![License](https://img.shields.io/packagist/l/edzeery/mystatuskit.svg)](https://github.com/Edzeery/mystatuskit/blob/main/LICENSE)
[![Tests](https://github.com/Edzeery/mystatuskit/actions/workflows/tests.yml/badge.svg)](https://github.com/Edzeery/mystatuskit/actions)

مكتبة موحّدة لإدارة **ألوان وأيقونات وقوائم الحالات** (Status Colors, Icons, Badges &amp; Select) في أي مشروع Laravel — **بدون أي اعتماد على Filament أو أي حزمة UI خارجية**.

- **90+ حالة جاهزة** عبر 10 نطاقات (domains): `payment`, `subscription`, `user`, `stores`, `order`, `product`, `role`, `invoice`, `notification`, `general`
- **5 مجموعات أيقونات**: FontAwesome, Bootstrap Icons, Ionicons, Heroicons (SVG مضمّن), SVG مخصص
- **فريمووركان للألوان**: Bootstrap 5 و Tailwind CSS — مع سهولة التبديل
- **Blade Components**: `<x-status-badge>`, `<x-status-dot>`, `<x-status-icon>`, `<x-status-select>` (Alpine.js), `<x-status-progress>`, `<x-status-badge-wire>` (Livewire)
- **متوافق مع**: PHP 8.1+ / Laravel 10, 11, 12, 13
- **Livewire 3**: `<x-status-select>` و `<x-status-badge-wire>` يدعمان `wire:model` و `wire:model.live`

---

## المحتويات

- [1. التثبيت](#1-التثبيت)
- [2. تثبيت مكتبات الأيقونات](#2-تثبيت-مكتبات-الأيقونات)
- [3. اختيار فريموورك الألوان](#3-اختيار-فريموورك-الألوان)
- [4. الاستعمال](#4-الاستعمال)
- [5. إضافة نطاق أو حالة جديدة](#5-إضافة-نطاق-أو-حالة-جديدة)
- [6. جدول الترحيل](#6-جدول-الترحيل)
- [7. البنية الداخلية](#7-البنية-الداخلية)
- [8. الاختبارات](#8-الاختبارات)
- [9. استكشاف الأخطاء](#9-استكشاف-الأخطاء)
- [10. الإصدارات](#10-الإصدارات)
- [11. المتطلبات](#11-المتطلبات)
- [12. الترخيص](#12-الترخيص)

---

## 1. التثبيت

### الطريقة الموصى بها — Packagist

```bash
composer require edzeery/mystatuskit
```

هذا كافٍ في أي مشروع Laravel — الحزمة تُسجَّل تلقائياً (Auto-Discovery) بدون أي إعداد يدوي.

> **ملاحظة:** إذا أردت تقييد نسخة معينة:
> ```bash
> composer require edzeery/mystatuskit:^1.2
> ```

### البديل: مستودع VCS من GitHub

مفيد إذا أردت commit معيّن قبل أن يصل Packagist:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Edzeery/mystatuskit"
        }
    ],
    "require": {
        "edzeery/mystatuskit": "^1.2"
    }
}
```

ثم:
```bash
composer update edzeery/mystatuskit
```

### للتطوير المحلي

```json
"repositories": [
    { "type": "path", "url": "../mystatuskit" }
]
```

### نشر الملفات القابلة للتخصيص (اختياري لكن مُستحسن)

```bash
php artisan vendor:publish --tag=status-kit-config   # config/icons.php + config/statuses.php + config/theme.php
php artisan vendor:publish --tag=status-kit-lang      # lang/vendor/status-kit/{ar,en,fr}
php artisan vendor:publish --tag=status-kit-views     # قوالب البادج والـ Select
php artisan vendor:publish --tag=status-kit-svg       # ملفات heroicons SVG
```

> **تحذير:** بعد كل `composer update` للحزمة، إذا كنت ناشر `status-kit-views` من قبل، أعد نشرها مع `--force`:
> ```bash
> php artisan vendor:publish --tag=status-kit-views --force
> php artisan view:clear
> ```

---

## 2. تثبيت مكتبات الأيقونات

هذه المكتبات هي أصول Frontend (CSS/JS) وليست حزم Composer:

### الطريقة الأسرع: CDN من الحزمة مباشرة

في `<head>` من layout الرئيسي:

```blade
@statusKitAssets(['fa', 'bi', 'ion'])
```

أو من PHP:

```php
{!! status_kit_assets(['fa', 'ion']) !!}
```

يُدرج روابط CDN من `config/icons.php['cdn']`. **مناسب للتطوير**، لكن يعتمد على اتصال خارجي.

### الطريقة الموصى بها للإنتاج: تثبيت محلي عبر NPM

```bash
npm install @fortawesome/fontawesome-free bootstrap-icons ionicons
```

في `resources/css/app.css`:

```css
@import '@fortawesome/fontawesome-free/css/all.min.css';
@import 'bootstrap-icons/font/bootstrap-icons.css';
```

في `resources/js/app.js` (اختياري لـ Ionicons):

```js
import 'ionicons/dist/ionicons.js';
```

ثم `npm run build`.

### الطريقة اليدوية

حمّل الملفات من المصادر الرسمية وضعها في `public/vendor/`:
- FontAwesome: https://fontawesome.com/download
- Bootstrap Icons: https://icons.getbootstrap.com
- Ionicons: https://ionic.io/ionicons

### ملاحظة Heroicons

لا تحتاج أي تثبيت — ملفات SVG مضمّنة داخل الحزمة (`resources/svg/heroicons`). تُعرض مباشرة بدون أي خط خارجي.

---

## 3. اختيار فريموورك الألوان

الحزمة تدعم فريمووركين، الافتراضي **Bootstrap 5**:

```bash
php artisan vendor:publish --tag=status-kit-config
```

في `config/status-kit-theme.php`:

```php
'default_framework' => 'bootstrap', // أو 'tailwind'
```

يمكن تجاوز الافتراضي لكل استدعاء:

```php
Status::for('payment', 'paid')->color(framework: 'tailwind');
Status::for('payment', 'paid')->badge(framework: 'bootstrap');
```

| الفريموورك | الكلاسات المستعملة |
|---|---|
| **Bootstrap 5** (الافتراضي) | `text-bg-success`, `text-bg-danger`... (جاهزة من Bootstrap 5.1+) |
| **Tailwind CSS** | كلاسات `light`/`dark` اليدوية المعرّفة مع كل حالة في `config/statuses.php` |

---

## 4. الاستعمال

### 4.1 Facade — الواجهة الرئيسية

```php
use Edzeery\MyStatusKit\Facades\Status;

// جلب بيانات الحالة
Status::for('payment', 'paid')->color();       // "text-bg-success" (Bootstrap) أو كلاسات Tailwind
Status::for('payment', 'paid')->hex();          // "#16a34a"
Status::for('payment', 'paid')->variant();      // "success"
Status::for('payment', 'paid')->label();        // "مدفوع" (مترجم حسب اللغة)
Status::for('payment', 'paid')->label('en');    // "Paid" (فرض لغة)
Status::for('payment', 'paid')->icon('fa');     // <i class="fas fa-check-circle"></i>
Status::for('payment', 'paid')->badge('bi');    // HTML بادج كامل جاهز
Status::for('payment', 'paid')->toArray();      // ['domain' => ..., 'status' => ..., ...]

// جلب كل حالات نطاق معين
Status::domain('payment');  // ['paid' => StatusResult, 'pending' => StatusResult, ...]

// التحقق من وجود حالة
Status::exists('payment', 'paid');      // true
Status::exists('payment', 'nonexistent'); // false

// جلب كل النطاقات
Status::domains(); // ['payment', 'subscription', 'user', ...]

// تسجيل حالات جديدة أثناء التشغيل
Status::register('custom', 'new_status', [
    'variant' => 'info', 'hex' => '#2563eb', 'icon' => 'info',
]);
Status::registerMany('custom', ['s1' => [...], 's2' => [...]]);

// التحقق من الحالة الحالية
$result = Status::for('payment', 'paid');
$result->is('paid');                            // true
$result->isOneOf(['paid', 'completed']);         // true
$result->inDomain('payment');                    // true
echo $result;                                    // "مدفوع" (Stringable)
json_encode($result);                            // {"domain":"payment","status":"paid",...} (JsonSerializable)
```

### 4.2 Helpers (متوافقة مع المكتبة القديمة)

```php
status_color('payment', 'paid');               // "text-bg-success"
status_hex('payment', 'paid');                 // "#16a34a"
status_label('payment', 'paid');               // "مدفوع"
status_label('payment', 'paid', 'fr');         // "Payé"
status_icon('payment', 'paid', 'bi');          // <i class="bi bi-check-circle"></i>
status_badge('payment', 'paid');               // HTML بادج كامل

icon('paid', 'fa', 'text-lg');                 // أيقونة فقط
svg_icon('custom-logo', 'w-6 h-6');            // SVG من resources/svg
getIconHtml('paid');                            // متوافقة مع النسخة القديمة (deprecated)
status_kit_assets(['fa', 'ion']);               // إدراج CDN
status_exists('payment', 'paid');               // true
status_domain('payment');                       // ['paid' => StatusResult, ...]
status_domains();                               // ['payment', 'subscription', ...]
status('payment', 'paid');                      // كائن StatusResult كامل
```

### 4.3 Blade Component — البادج

```blade
<x-status-badge domain="payment" status="paid" set="fa" />
<x-status-badge domain="user" status="banned" set="heroicon" class="text-sm" />
<x-status-badge domain="general" status="featured" set="fa" :icon="false" />
```

**Props:**

| Prop | النوع | الافتراضي | الوصف |
|---|---|---|---|
| `domain` | string | **إجباري** | نطاق الحالة (payment, user, general...) |
| `status` | string | **إجباري** | اسم الحالة (paid, active, banned...) |
| `set` | string | null | مجموعة الأيقونات (fa/bi/ion/heroicon/svg) |
| `icon` | bool | true | إظهار/إخفاء الأيقونة |
| `class` | string | '' | كلاسات CSS إضافية |

### 4.4 Blade Component — النقطة اللونية (Dot)

نقطة لونية صغيرة بدون نص، مناسبة للقوائم والجداول:

```blade
<x-status-dot domain="payment" status="paid" />
<x-status-dot domain="user" status="active" size="lg" />
<x-status-dot domain="order" status="pending" size="sm" />
```

**Props:**

| Prop | النوع | الافتراضي | الوصف |
|---|---|---|---|
| `domain` | string | **إجباري** | نطاق الحالة |
| `status` | string | **إجباري** | اسم الحالة |
| `size` | string | 'md' | الحجم: `sm` / `md` / `lg` |
| `class` | string | '' | كلاسات CSS إضافية |

### 4.5 Blade Component — الأيقونة فقط (Icon)

```blade
<x-status-icon domain="payment" status="paid" set="bi" />
<x-status-icon domain="role" status="admin" set="heroicon" class="w-5 h-5" />
```

### 4.6 Blade Component — شريط التقدم (Progress)

شريط تقدم ملوّن يعرض نسبة مئوية مع دعم ARIA:

```blade
<x-status-progress domain="payment" status="paid" value="75" />
<x-status-progress domain="order" status="shipped" value="100" size="lg" />
<x-status-progress domain="subscription" status="active" value="45" size="sm" :show-label="false" />
```

**Props:**

| Prop | النوع | الافتراضي | الوصف |
|---|---|---|---|
| `domain` | string | **إجباري** | نطاق الحالة |
| `status` | string | **إجباري** | اسم الحالة |
| `value` | int | 100 | النسبة المئوية (0-100) |
| `size` | string | 'md' | الحجم: `sm` / `md` / `lg` |
| `showLabel` | bool | true | إظهار `sr-only` label |
| `class` | string | '' | كلاسات CSS إضافية |

### 4.7 Blade Component — البادج Livewire (Badge Wire)

بادجLivewire متوافق مع `wire:model` و `wire:model.live`:

```blade
<x-status-badge-wire domain="payment" status="paid" set="fa" />
<x-status-badge-wire domain="subscription" status="active" wire:model.live="subscriptionStatus" />
```

### 4.9 Blade Component — القائمة المخصصة (Select)

`<x-status-select>` — قائمة اختيار مخصصة مبنية بـ **Alpine.js**، تعرض أيقونة + نقطة لون + تسمية لكل حالة.

```blade
{{-- استعمال بسيط --}}
<x-status-select domain="payment" name="status" selected="paid" />

{{-- مع Livewire 3 wire:model --}}
<x-status-select domain="subscription" wire:model.live="subscriptionStatus" />

{{-- مع بحث (مفيد للدومينات الكبيرة مثل general) --}}
<x-status-select domain="general" searchable placeholder="اختر حالة..." />

{{-- تحكم إضافي --}}
<x-status-select
    domain="order"
    name="order_status"
    selected="pending"
    set="bi"
    size="lg"
    disabled
/>
```

**Props:**

| Prop | النوع | الافتراضي | الوصف |
|---|---|---|---|
| `domain` | string | **إجباري** | نطاق الحالات |
| `name` | string | null | اسم حقل الإدخال المخفي (للنماذج) |
| `selected` | string | null | القيمة المحددة مسبقاً |
| `set` | string | null | مجموعة الأيقونات |
| `placeholder` | string | تلقائي حسب اللغة | نص بديل |
| `disabled` | bool | false | تعطيل القائمة |
| `searchable` | bool | false | تفعيل حقل البحث |
| `size` | string | 'md' | الحجم: `sm` / `md` / `lg` |
| `class` | string | '' | كلاسات CSS إضافية |

**متطلبات:**
- **Alpine.js** (متوفر تلقائيًا مع Livewire 3)
- **Bootstrap Icons** للسهم وعلامة الاختيار (`bi bi-chevron-down`, `bi bi-check-lg`) — ثابتة بغض النظر عن `set`

**إعدادات قابلة للتخصيص** عبر `config/status-kit-theme.php`:

```php
'select' => [
    'max_height'  => '16rem',  // ارتفاع أقصى للائحة
    'z_index'     => 50,       // z-index لوحة الاختيار
    'default_set' => null,     // null = يتبع status-kit-icons.default_set
],
```

### 4.10 الأدوار

```php
Status::for('role', 'super_admin')->badge('heroicon');
Status::for('role', 'admin')->badge('fa');
```

### 4.11 Eloquent Cast — StatusCast

تحويل قاعدة البيانات تلقائيًا إلى كائن `StatusResult`:

```php
use Edzeery\MyStatusKit\Casts\StatusCast;

class Order extends Model
{
    protected $casts = [
        'status' => StatusCast::class . ':payment',
    ];
}

// الاستعمال:
$order = Order::find(1);
$order->status->label();   // "مدفوع"
$order->status->hex();     // "#16a34a"
echo $order->status;       // "مدفوع" (Stringable)
```

**ملاحظة:** النطاق (`domain`) يُمرر كمعامل إضافي بعد dấu `:` في تعريف الـ Cast.

### 4.12 Blade Directives

```blade
{{-- تكرار حالات نطاق معين --}}
@statusFor('payment')
    <div>{{ $key }}: {{ $statusResult->label() }}</div>
@endstatusFor

{{-- عرض إحصائيات النطاق --}}
@statusLegend('payment')
    @foreach($__statusLegendItems as $key => $result)
        <span class="badge">{{ $result->label() }}</span>
    @endforeach
@endStatusLegend
```

---

## 5. إضافة نطاق أو حالة جديدة

### الخطوة 1: تعريف الحالة في config

بعد نشر `config/statuses.php`:

```php
// config/statuses.php
'invoice' => [
    'draft' => [
        'variant' => 'info',
        'light'   => 'text-blue-700 bg-blue-100',
        'dark'    => 'dark:text-blue-300 dark:bg-blue-900/40',
        'hex'     => '#2563eb',
        'icon'    => 'draft',
    ],
],
```

### الخطوة 2: إضافة الترجمات

في كل ملف لغة (`lang/vendor/status-kit/{ar,en,fr}/statuses.php`):

```php
// lang/vendor/status-kit/ar/statuses.php
'invoice' => ['draft' => 'مسودة'],

// lang/vendor/status-kit/en/statuses.php
'invoice' => ['draft' => 'Draft'],

// lang/vendor/status-kit/fr/statuses.php
'invoice' => ['draft' => 'Brouillon'],
```

> **مهم:** تأكد أن المفتاح موجود بالضبط في الثلاث ملفات — بلا نقص وبلا تكرار.

### الخطوة 3: إضافة الأيقونة (اختياري)

في `config/icons.php`، أضف المفتاح لكل مجموعة:

```php
'fa'    => ['draft' => 'fa-file'],
'bi'    => ['draft' => 'bi-file-earmark'],
'ion'   => ['draft' => 'document-outline'],
```

### الاستعمال:

```php
Status::for('invoice', 'draft')->badge('fa');
// أو
status_badge('invoice', 'draft', 'bi');
```

---

## 6. جدول الترحيل من الملفات القديمة

| الطريقة القديمة | الطريقة الجديدة |
|---|---|
| `config('payment-colors.payment.paid')` | `Status::for('payment', 'paid')->color()` |
| `config('subscription-colors.subscription.active')` | `Status::for('subscription', 'active')->color()` |
| `config('status-colors.order.pending')` | `Status::for('order', 'pending')->color()` |
| `config('roles.admin')` | `Status::for('role', 'admin')` |
| `icon('paid', 'fa')` | `icon('paid', 'fa')` (بدون تغيير) |
| `getIconHtml(...)` | `getIconHtml(...)` (بدون تغيير) |
| مفتاح `filament` | أصبح `variant` (نفس المعنى) |
| أيقونات `heroicon-o-*` | مفاتيح عامة تُترجم حسب `$set` وقت العرض |

---

## 7. البنية الداخلية

```
src/
├── StatusKitServiceProvider.php   # التسجيل والتحميل
├── StatusManager.php              # قراءة config وبناء StatusResult
├── IconManager.php                # منطق عرض الأيقونات (fa/bi/ion/heroicon/svg)
├── DTO/
│   └── StatusResult.php           # DTO بواجهة fluent + Stringable + JsonSerializable
├── Casts/
│   └── StatusCast.php             # Eloquent Cast لتحويل DB إلى StatusResult
├── Facades/
│   ├── Status.php                 # Facade للStatusManager
│   └── Icon.php                   # Facade للIconManager
├── Support/
│   └── AssetsRenderer.php         # إدراج CDN مع دعم SRI
└── Helpers/
    └── helpers.php                # دوال مساعدة (status_color, status_exists, ...)

resources/views/components/
├── status-badge.blade.php         # البادج (ARIA: role="status")
├── status-badge-wire.blade.php    # البادج Livewire (wire:ignore.self)
├── status-dot.blade.php           # النقطة اللونية (sm/md/lg)
├── status-icon.blade.php          # الأيقونة فقط (ARIA: role="img")
├── status-progress.blade.php      # شريط التقدم (ARIA: progressbar)
└── status-select.blade.php        # القائمة المخصصة (Alpine.js)

resources/svg/heroicons/           # ملفات SVG مضمّنة (Heroicons)

config/
├── statuses.php                   # تعريف الحالات (ألوان + hex + أيقونة + variant + _shared)
├── icons.php                      # mapping المفاتيح لأسماء الأيقونات لكل مجموعة (مع SRI hashes)
└── theme.php                      # إعدادات الفريموورك + heroicon_dir + svg_cache + fallback_locale

lang/{ar,en,fr}/statuses.php      # الترجمات
```

---

## 8. الاختبارات

الحزمة تتضمن اختبارات PHPUnit شاملة:

```bash
# تشغيل كل الاختبارات
composer test

# تشغيل اختبارات معيّنة
vendor/bin/phpunit --filter StatusManagerTest
vendor/bin/phpunit --filter StatusResultTest
vendor/bin/phpunit --filter IconManagerTest
vendor/bin/phpunit --filter HelpersTest
vendor/bin/phpunit --filter ServiceProviderTest
vendor/bin/phpunit --filter AssetsRendererTest
vendor/bin/phpunit --filter AdvancedTest
```

**جودة الكود:**

```bash
# فحص PHPStan (Static Analysis)
composer analyse

# تنسيق الكود عبر Pint
composer format
```

---

## 9. استكشاف الأخطاء

### `Unable to locate a class or view for component [status-select]`

**السبب:** نشرت `status-kit-views` من نسخة قديمة.

**الحل:**

```bash
php artisan vendor:publish --tag=status-kit-views --force
php artisan view:clear
```

إذا استمر:

```bash
php artisan optimize:clear
composer dump-autoload
```

### الترجمة ترجع بالإنجليزي بدلاً من النص الصحيح

**السبب:** عدم تطابق المفتاح بين `config/statuses.php` و `lang/{locale}/statuses.php`.

**الحل:**
1. تأكد أن المفتاح موجود في كل ملفات اللغة الثلاث
2. نفّذ:
```bash
php artisan config:clear
```

### الألوان ما تبانش

**السبب:** `config/status-kit-theme.php['default_framework']` لا يطابق CSS framework الفعلي.

**الحل:** عدّل الإعداد ليتطابق مع مشروعك (`bootstrap` أو `tailwind`).

### `<x-status-select>` لا يعمل مع Tailwind

**السبب:** تأكد أن `config/status-kit-theme.php['default_framework']` = `'tailwind'`.

**ملاحظة:** القائمة المخصصة تحتاج **Bootstrap Icons** للسهم وعلامة الاختيار (`bi bi-chevron-down`, `bi bi-check-lg`) — حتى مع Tailwind للألوان.

---

## 10. الإصدارات

###_rules

1. عدّل الكود وادفعه لفرع `main`
2. من GitHub: `Releases → Draft a new release`
3. أنشئ Tag يتبع [Semantic Versioning](https://semver.org):
   - **Bug fix** → `v1.1.x`
   - **ميزة جديدة متوافقة** → `v1.x.0`
   - **breaking change** → `v2.0.0`
4. Packagist يتحدث تلقائياً عبر GitHub webhook

**آخر إصدار: v1.2.0**

---

## 11. المتطلبات

| المتطلب | الإصدار |
|---|---|
| PHP | `^8.1` |
| Laravel | `^10 | ^11 | ^12 | ^13` |
| Alpine.js | فقط إذا استعملت `<x-status-select>` |
| Bootstrap 5.1+ | الافتراضي للألوان |
| Livewire 3 | اختياري — لـ `wire:model` في `<x-status-select>` |

---

## 12. الترخيص

MIT License — مفتوح المصدر بالكامل.

---

## المساهمة

مرحباً بك في المساهمة! يرجى فتح Issue أو Pull Request على GitHub:
https://github.com/Edzeery/mystatuskit
