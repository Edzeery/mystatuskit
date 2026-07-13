# Changelog

## v1.0.2 (غير منشور بعد)

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
