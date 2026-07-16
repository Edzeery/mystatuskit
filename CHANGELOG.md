# Changelog

## v1.1.4

### ميزات جديدة

- **نظام `_shared` لتقليل التكرار** — الحالات المشتركة (active, pending, approved...) تُعرَّف مرة واحدة في `config/statuses.php['_shared']` وتُستعار عبر النطاقات. يمكن استدعاؤها كـ `string` (بلا تعديل) أو `array` مع icon فقط (تدمج مع _shared).
- **5 نطاقات مالية جديدة**: `budget` (9 حالات)، `expense` (9 حالات)، `income` (7 حالات)، `transaction` (8 حالات)، `account` (7 حالات).
- **توسيع نطاق `order`** — 8 حالات شحن/توصيل جديدة: `confirmed`, `preparing`, `shipped`, `delivered`, `returned`, `in_transit`, `on_hold`, `out_for_delivery`.
- **توسيع نطاق `payment`** — 5 حالات checkout: `checkout_paid`, `checkout_pending`, `checkout_failed`, `checkout_canceled`, `checkout_expired`.
- **توسيع نطاق `general`** — 55+ حالة جديدة تشمل: حالات البيع (paid, unpaid, partially_paid...)، حالات الشحن (shipped, delivered, in_transit...)، حالات الاشتراك (renewed, upgraded, downgraded...)، حالات الوسائط (play, pause, stop...)، حالات الدورة حياة (beta, deprecated, archived...)، وأيقونات عامة (yes/no, on/off, save, add, remove...).
- **مكوّن `<x-status-icon>` جديد** — عرض الأيقونة فقط (بدون نص وبلا خلفية). يدعم `set` و `class`.
- **دعم خاصية `icon` في `<x-status-badge>`** — يمكن إخفاء الأيقونة بتمرير `:icon="false"`.
- **`StatusResult::badgeWithoutIcon()`** — بادج بلا أيقونة (نص + ألوان فقط).
- **`StatusResult::iconOnly()`** — أيقونة فقط كـ HTML.

### تحسينات

- **إصلاح `general.inactive`** — كان `variant: danger` بالخطأ، أصبح `variant: gray`.
- **إصلاح `general.danger`** — كان يستعمل `icon: failed`، أصبح أكثر دقة.
- **إضافة أيقونات جديدة** في `config/icons.php` لـ 60+ حالة عبر 4 مجموعات (fa, bi, ion, heroicon).
- **ترجمات كاملة** لـ 3 لغات (ar, en, fr) تشمل كل الحالات الجديدة.
- **تحسين `StatusResult::resolvedData()`** — يحل تلقائيًا مشكلة البيانات كـ string من `_shared`.

---

## v1.1.3

### إصلاحات (Bug Fixes)

- **إصلاح أحداث Alpine.js في `<x-status-select>`** — `dispatchEvent(new Event('input'))` و `dispatchEvent(new Event('change'))` لم تكن تنتقل (bubble) إلى النافذة (window). تمت إضافة `{ bubbles: true }` لتمكين `@change.window` و `@input.window` في الصفحات الخارجية.
- **تحديث CDN Ionicons** — تغيير من `unpkg.com` إلى `cdn.jsdelivr.net` لتحسين السرعة والموثوقية (خاصة في منطقة الشرق الأوسط).

---

## v1.1.2

### إصلاحات (Bug Fixes)

- **remap أيقونات heroicon ناقصة** — `user-plus` → `user`، `cloud-arrow-up` → `arrow-path`، `toggle-on` → `check-circle`، `toggle-off` → `x-circle` (الملفات الأصلية غير موجودة في `resources/svg/heroicons/`).
- **إضافة أيقونة `verified`** إلى heroicon set (`check-circle`).
- **إضافة `online`/`offline`** إلى 4 مجموعات أيقونات (fa, bi, ion, heroicon) — كانت تنقص وتعود للأيقونة الافتراضية.

---

## v1.1.1

### إصلاحات (Bug Fixes)

- **حذف `src/View/Components/StatusBadge.php`** — كلاس dead code لم يُسجَّل في ServiceProvider أبداً (لم يُحذف فعلياً في v1.0.2 كما ورد في CHANGELOG).
- **إصلاح PHPDoc في `StatusManager::for()`** — حُذف `@throws InvalidArgumentException` الوهمي لأن الدالة لا ترمي Exception أبداً而是 تعيد `general.gray` كبديل.
- **حذف ملفات `lang/*.json`** — ملفات ترجمات Breeze/Jetstream عامة لا علاقة لها بالمكتبة (كانت تُسبب تعارضاً مع ترجمات المشروع).

### ميزات جديدة

- **اختبارات PHPUnit شاملة** — 6 ملفات اختبار (>50 اختبار) تغطي StatusManager, StatusResult, IconManager, Helpers, ServiceProvider, AssetsRenderer.
- **`<x-status-select>` يدعم Bootstrap + Tailwind** — الكلاسات CSS أصبحت ديناميكية حسب `config('status-kit-theme.default_framework')`. يعمل مع أي من الفريمووركين بدون تعديل.
- **ملفات Heroicons SVG مكتملة** — أُضيفت ~20 ملف SVG ناقصة (play, pause, stop, backward, forward, eye, heart, flag, bolt, fire, star, key, link, question-mark-circle, shopping-cart, photo, folder-open, document-arrow-down, paper-airplane, speaker-wave, speaker-x-mark, archive-box, hand-thumb-up, plus, minus, toggle-on, toggle-off, check-badge, map-pin).
- **PHPStan (Level 5)** — فحص Static Analysis لضمان جودة الكود.
- **Laravel Pint** — تنسيق الكود تلقائياً.
- **GitHub Actions CI** — اختبارات تلقائية عند كل push (PHP 8.1-8.3 × Laravel 10-12).
- **`.gitattributes` محسّن** — ملفات التطوير (tests, phpstan, pint, .github) لا تُنشر مع الحزمة عبر `composer install`.

### تحسينات

- **README شامل ومفصّل** — جدول محتويات، جدول Props كامل، أمثلة لكل مكوّن، قسم استكشاف أخطاء محسّن، قسم اختبارات.

---

## v1.1.0

### ميزات جديدة

- **`<x-status-select>` جديد**: قائمة اختيار مخصصة (Custom Dropdown) بـ Alpine.js، تعرض أيقونة + نقطة لون + تسمية لكل خيار. تدعم: بحث اختياري (`searchable`)، تنقل بالكيبورد (↑↓ Enter Escape)، `wire:model`/`wire:model.live` (Livewire)، `disabled`، `size` (sm/md/lg)، RTL و Dark mode تلقائيًا (بلا أي تعديل إضافي).
- إعدادات جديدة `config/status-kit-theme.php['select']` (`max_height`, `z_index`, `default_set`).

### ملاحظات توافق
- **إضافة متوافقة رجوعيًا بالكامل (Minor)** — بلا أي تعديل على `StatusManager`/`StatusResult`/API الحالي. يتطلب Alpine.js (متوفر تلقائيًا مع Livewire 3) و Bootstrap Icons لسهم/علامة الاختيار الثابتين فـ واجهة الـ Select.

راجع v1.0.6 أدناه لتصحيحات سبقت هاذ الإصدار.

---

## v1.0.6 (غير منشور بعد)

### إصلاحات (Bugs)

- **مفاتيح مكررة فـ `lang/ar/statuses.php`**: `featured`, `deprecated`, `archived` كانوا مكررين جوّا نفس `general`. تمت إزالة التكرار (القيمة الأولى فقط بقيت).
- **مفاتيح يتيمة `enabled`/`disabled`** فـ `lang/ar/statuses.php` (بلا أي مقابل فـ config، ومعناها متطابق مع `enable`/`disable` الموجودين) — تمت إزالتها.
- **11 حالة كانت لها ترجمة فـ AR بلا أي تعريف فـ `config/statuses.php`** (`beta`, `deprecated`, `archived`, `delete`, `locked`, `unlocked`, `pending`, `approved`, `rejected`, `highlighted`, `trending`): أُكملت بالكامل (variant/color/hex/icon) بدل ما تبقى معطلة.
- **أيقونات ناقصة** لـ 7 حالات جديدة (`beta`, `deprecated`, `archived`, `locked`, `unlocked`, `highlighted`, `trending`) عبر fa/bi/ion/heroicon.
- **عدم تطابق الترجمة بين اللغات**: EN كانت ناقصة 5 مفاتيح (`pending`, `approved`, `rejected`, `highlighted`, `trending`)، FR كانت ناقصة 13 مفتاح. الآن الثلاث لغات (AR/EN/FR) مطابقة **حرفيًا 1:1** مع مفاتيح `config/statuses.php['general']` (73 حالة، بلا نقص وبلا زوائد وبلا تكرار).
- **حذف الكود الميت** `src/View/Components/StatusBadge.php` (رجع من نسخة سابقة، بلا أي تسجيل فـ ServiceProvider).

### تحسينات

- زيد `.gitattributes` لفرض `LF` على كل ملفات النص، لتفادي تضارب CRLF/LF المستقبلي بين المحررين المختلفين (Windows/Linux).

---

## v1.0.2

### إصلاحات (Bugs)

- **الترجمة (`label()`) ماكانتش تشتغل فعليًا.** كانت تقرا من `lang/{locale}/statuses.php` بلا أي علاقة بملفات الحزمة (namespace غير متطابق بين `loadTranslationsFrom()` ومسار النشر). صار الآن يستعمل namespace موحّد `status-kit` في الحالتين (المصدر المدمج + الملفات المنشورة في `resources/lang/vendor/status-kit`).
- **الألوان ماكانتش تبان فالمشاريع المبنية على Bootstrap.** كل الألوان كانت Tailwind CSS classes ثابتة بلا أي بديل. صار فيه إعداد `config/status-kit-theme.php` يختار الفريموورك (`bootstrap` الافتراضي أو `tailwind`)، مع دعم Bootstrap 5.1+ (`text-bg-*`) جاهز بلا أي CSS إضافي.
- **أيقونات SVG/heroicon كبيرة جدًا وما ينفعش تتحكم فحجمها.** الملفات ماكانتش فيها `width`/`height`، فتفادينا الحجم الطبيعي الكبير بحقن `width="1em" height="1em"` افتراضيًا (قابل للتعديل عبر `status-kit-icons.svg_size`).

### تحسينات

- زيدت `StatusResult::badgeClasses()` لتوحيد منطق بناء كلاسات البادج (يستعملها `badge()` و`<x-status-badge>` معًا، بدل تكرار الكود).
- `color()` و`badge()` يقبلوا الآن `framework` صراحة (`'bootstrap'|'tailwind'`) للتحكم لكل استدعاء بلا الحاجة لتغيير الconfig العام.

### إزالات

- حذفنا `src/View/Components/StatusBadge.php` — كلاس Component كان موجود بلا أي تسجيل في `StatusKitServiceProvider` (كود ميت غير مستعمل، والمكوّن الفعلي Anonymous Component عبر `resources/views/components/status-badge.blade.php`).

---

## v1.0.1

- دعم Laravel 13 (`illuminate/support: ^13.0`).

## v1.0.0

- الإصدار الأول.
