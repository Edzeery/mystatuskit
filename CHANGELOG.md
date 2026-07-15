# Changelog

## v1.1.0 

### ميزات جديدة

- **`<x-status-select>` جديد**: قائمة اختيار مخصصة (Custom Dropdown) بـ Alpine.js، تعرض أيقونة + نقطة لون + تسمية لكل خيار. تدعم: بحث اختياري (`searchable`)، تنقل بالكيبورد (↑↓ Enter Escape)، `wire:model`/`wire:model.live` (Livewire)، `disabled`, `size` (sm/md/lg)، RTL و Dark mode تلقائيًا (بلا أي تعديل إضافي).
- إعدادات جديدة `config/status-kit-theme.php['select']` (`max_height`, `z_index`, `default_set`).

### ملاحظات توافق
- **إضافة متوافقة رجوعيًا بالكامل (Minor)** — بلا أي تغيير على `StatusManager`/`StatusResult`/API الحالي. يتطلب Alpine.js (متوفر تلقائيًا مع Livewire 3) و Bootstrap Icons لسهم/علامة الاختيار الثابتين فـ واجهة الـ Select.

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
