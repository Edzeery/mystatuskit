@props([
    'domain',
    'name'        => null,
    'selected'    => null,
    'set'         => null,
    'placeholder' => null,
    'disabled'    => false,
    'searchable'  => false,
    'size'        => 'md', // sm | md | lg
    'class'       => '',
])

@php
    /**
     * كل بيانات الأيقونات/الألوان/التسميات تُبنى هنا سيرفر-سايد (مصدرها config/statuses.php
     * الموثوق به، مو مدخلات مستخدم)، وتُمرَّر لـ Alpine عبر @js() لعرضها بـ x-html بأمان.
     */
    $statusManager = app(\Edzeery\MyStatusKit\StatusManager::class);
    $items = $statusManager->domain($domain);

    $iconSet = $set
        ?? config('status-kit-theme.select.default_set')
        ?? config('status-kit-icons.default_set', 'ion');

    $jsOptions = collect($items)->map(fn ($result, $key) => [
        'value' => $key,
        'label' => $result->label(),
        'icon'  => $result->icon($iconSet),
        'hex'   => $result->hex(),
    ])->values()->all();

    $placeholderText = $placeholder ?? match (app()->getLocale()) {
        'ar'    => 'اختر...',
        'fr'    => 'Choisir...',
        default => 'Select...',
    };

    $maxHeight = config('status-kit-theme.select.max_height', '16rem');
    $zIndex    = config('status-kit-theme.select.z_index', 50);
    $uid       = 'status-select-' . \Illuminate\Support\Str::random(8);
@endphp

@once
    <style>
        .status-select-trigger {
            background-color: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: var(--bs-border-radius);
            padding: .375rem .75rem;
            color: var(--bs-body-color);
            cursor: pointer;
            width: 100%;
            text-align: start;
        }
        .status-select-trigger.is-disabled { opacity: .6; cursor: not-allowed; pointer-events: none; }
        .status-select-trigger.size-sm { padding: .25rem .5rem; font-size: .875rem; }
        .status-select-trigger.size-lg { padding: .5rem 1rem; font-size: 1.125rem; }
        .status-select-trigger .status-select-chevron { transition: transform .15s ease; }
        .status-select-trigger .status-select-chevron.rotate-180 { transform: rotate(180deg); }
        .status-select-icon svg { width: 1.1em; height: 1.1em; vertical-align: -0.15em; }
        .status-select-dot { width: .55em; height: .55em; border-radius: 50%; flex: none; }
        .status-select-menu {
            position: absolute;
            inset-inline-start: 0;
            top: calc(100% + .25rem);
            min-width: 100%;
            background-color: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: var(--bs-border-radius);
            box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .15);
            overflow-y: auto;
            padding: .35rem;
            animation: statusSelectPop .15s ease-out;
        }
        @keyframes statusSelectPop {
            from { opacity: 0; transform: translateY(-4px) scale(.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .status-select-option {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .4rem .55rem;
            border-radius: calc(var(--bs-border-radius) - 2px);
            cursor: pointer;
        }
        .status-select-option.is-highlighted,
        .status-select-option:hover { background-color: var(--bs-tertiary-bg); }
        .status-select-option.is-selected { font-weight: 600; }
    </style>
@endonce

<div
    {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => trim("status-select position-relative $class")]) }}
    x-data="{
        open: false,
        highlighted: -1,
        query: '',
        searchable: {{ $searchable ? 'true' : 'false' }},
        disabled: {{ $disabled ? 'true' : 'false' }},
        selected: @js($selected),
        options: @js($jsOptions),
        placeholder: @js($placeholderText),
        get filteredOptions() {
            if (! this.searchable || this.query.trim() === '') return this.options;
            const q = this.query.toLowerCase();
            return this.options.filter(o => o.label.toLowerCase().includes(q));
        },
        get current() {
            return this.options.find(o => o.value === this.selected) || null;
        },
        toggle() {
            if (this.disabled) return;
            this.open = ! this.open;
            if (this.open) {
                this.query = '';
                this.highlighted = this.options.findIndex(o => o.value === this.selected);
            }
        },
        select(value) {
            this.selected = value;
            this.open = false;
            this.$nextTick(() => {
                this.$refs.hiddenInput.dispatchEvent(new Event('input'));
                this.$refs.hiddenInput.dispatchEvent(new Event('change'));
            });
        },
        moveHighlight(delta) {
            if (! this.open) { this.toggle(); return; }
            const max = this.filteredOptions.length - 1;
            this.highlighted = Math.min(max, Math.max(0, this.highlighted + delta));
        },
        selectHighlighted() {
            const opt = this.filteredOptions[this.highlighted];
            if (opt) this.select(opt.value);
        },
    }"
    @click.outside="open = false"
>
    <input
        type="hidden"
        x-ref="hiddenInput"
        @if($name) name="{{ $name }}" @endif
        x-model="selected"
        {{ $attributes->whereStartsWith('wire:model') }}
    >

    <button
        type="button"
        id="{{ $uid }}-trigger"
        class="status-select-trigger size-{{ $size }} d-flex align-items-center justify-content-between"
        :class="{ 'is-disabled': disabled }"
        @if($disabled) disabled @endif
        role="combobox"
        aria-haspopup="listbox"
        :aria-expanded="open.toString()"
        aria-controls="{{ $uid }}-listbox"
        @click="toggle()"
        @keydown.arrow-down.prevent="moveHighlight(1)"
        @keydown.arrow-up.prevent="moveHighlight(-1)"
        @keydown.enter.prevent="open ? selectHighlighted() : toggle()"
        @keydown.escape="open = false"
    >
        <span class="d-inline-flex align-items-center gap-2 overflow-hidden">
            <template x-if="current">
                <span class="status-select-icon" x-html="current.icon"></span>
            </template>
            <span class="text-truncate" :class="{ 'text-body-secondary': ! current }" x-text="current ? current.label : placeholder"></span>
        </span>
        <i class="bi bi-chevron-down status-select-chevron small ms-2" :class="{ 'rotate-180': open }"></i>
    </button>

    <ul
        x-show="open"
        x-cloak
        id="{{ $uid }}-listbox"
        role="listbox"
        class="status-select-menu list-unstyled mb-0"
        style="max-height: {{ $maxHeight }}; z-index: {{ $zIndex }};"
    >
        @if($searchable)
            <li class="px-1 pb-2">
                <input
                    type="text"
                    x-model="query"
                    @click.stop
                    class="form-control form-control-sm"
                    placeholder="{{ app()->getLocale() === 'ar' ? 'بحث...' : (app()->getLocale() === 'fr' ? 'Rechercher...' : 'Search...') }}"
                >
            </li>
        @endif

        <template x-for="(opt, idx) in filteredOptions" :key="opt.value">
            <li
                role="option"
                class="status-select-option"
                :class="{ 'is-highlighted': highlighted === idx, 'is-selected': opt.value === selected }"
                :aria-selected="opt.value === selected"
                @click="select(opt.value)"
                @mouseenter="highlighted = idx"
            >
                <span class="status-select-dot" :style="`background-color:${opt.hex}`"></span>
                <span class="status-select-icon" x-html="opt.icon"></span>
                <span class="flex-grow-1" x-text="opt.label"></span>
                <i class="bi bi-check-lg" x-show="opt.value === selected"></i>
            </li>
        </template>

        <li x-show="filteredOptions.length === 0" class="text-body-secondary small px-2 py-1">
            {{ app()->getLocale() === 'ar' ? 'لا توجد نتائج' : (app()->getLocale() === 'fr' ? 'Aucun résultat' : 'No results') }}
        </li>
    </ul>
</div>
