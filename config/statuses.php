<?php

/**
 * ملف موحّد لكل حالات النظام (ألوان + hex + أيقونة عامة + variant).
 *
 * كل حالة تحتوي:
 * - variant : اسم عام محايد (success|warning|danger|info|gray) قابل للربط لاحقًا بأي مكتبة UI
 * - light   : كلاسات Tailwind للوضع الفاتح
 * - dark    : كلاسات Tailwind للوضع الداكن (بادئة dark: على كل الكلاسات)
 * - hex     : اللون الأساسي كـ hex (مفيد للرسوم البيانية / SVG / Inline style)
 * - icon    : مفتاح عام يُترجم عبر config/icons.php حسب المجموعة (fa/bi/ion/heroicon) وقت العرض
 *
 * التسميات النصية (Labels) موجودة في lang/{ar,en,fr}/statuses.php
 * ويُستدعى المفتاح بصيغة: "{domain}.{status}" مثل: payment.paid
 */

return [

    'payment' => [
        'paid'      => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',  'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'paid'],
        'pending'   => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'pending'],
        'completed' => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'completed'],
        'failed'    => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'failed'],
        'refunded'  => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'refunded'],
        'canceled'  => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'canceled'],
    ],

    'subscription' => [
        'active'    => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',  'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'active'],
        'pending'   => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'pending'],
        'trialing'  => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'active'],
        'past_due'  => ['variant' => 'warning', 'light' => 'text-orange-700 bg-orange-100', 'dark' => 'dark:text-orange-300 dark:bg-orange-900/40', 'hex' => '#ea580c', 'icon' => 'pending'],
        'expired'   => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'expired'],
        'canceled'  => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'canceled'],
        'suspended' => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'suspended'],
    ],

    'user' => [
        'active'           => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',  'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'active'],
        'inactive'         => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'inactive'],
        'pending'          => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'pending'],
        'suspended'        => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'suspended'],
        'banned'           => ['variant' => 'danger',  'light' => 'text-red-800 bg-red-200',       'dark' => 'dark:text-red-400 dark:bg-red-950',         'hex' => '#b91c1c', 'icon' => 'banned'],
        'email_unverified' => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'email_unverified'],
        'online'           => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',  'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'online'],
        'offline'          => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'offline'],
    ],

    'stores' => [
        'active'    => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',  'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'active'],
        'pending'   => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'pending'],
        'suspended' => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'suspended'],
        'closed'    => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'closed'],
        'draft'     => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'draft'],
        'blocked'   => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'blocked'],
        'approved'  => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',  'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'approved'],
        'rejected'  => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'rejected'],
    ],

    'order' => [
        'pending'    => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'pending'],
        'processing' => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'processing'],
        'completed'  => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',  'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'completed'],
        'canceled'   => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'canceled'],
        'refunded'   => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'refunded'],
    ],

    'product' => [
        'active'       => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',  'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'active'],
        'inactive'     => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'inactive'],
        'out_of_stock' => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'out_of_stock'],
        'discontinued' => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'discontinued'],
    ],

    // نطاق الأدوار (roles.php سابقًا) — أصبح نطاقًا ضمن نفس البنية الموحدة
    'role' => [
        'super_admin'       => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-400 dark:bg-red-950',      'hex' => '#991b1b', 'icon' => 'shield-exclamation'],
        'admin'             => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-400 dark:bg-yellow-950', 'hex' => '#f59e0b', 'icon' => 'shield-check'],
        'support_agent'     => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-400 dark:bg-blue-950',     'hex' => '#2563eb', 'icon' => 'chat-bubble'],
        'tech_support'      => ['variant' => 'gray',    'light' => 'text-gray-600 bg-gray-100',     'dark' => 'dark:text-gray-400 dark:bg-gray-900',     'hex' => '#6b7280', 'icon' => 'wrench-screwdriver'],
        'merchant'          => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-400 dark:bg-green-950',   'hex' => '#16a34a', 'icon' => 'building-storefront'],
        'user'              => ['variant' => 'info',    'light' => 'text-blue-600 bg-blue-100',     'dark' => 'dark:text-blue-400 dark:bg-blue-950',     'hex' => '#3b82f6', 'icon' => 'user-circle'],
        'owner'             => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-400 dark:bg-green-950',   'hex' => '#16a34a', 'icon' => 'shield-check'],
        'manager'           => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-400 dark:bg-yellow-950', 'hex' => '#ca8a04', 'icon' => 'clipboard-check'],
        'staff'             => ['variant' => 'gray',    'light' => 'text-gray-600 bg-gray-100',     'dark' => 'dark:text-gray-400 dark:bg-gray-900',     'hex' => '#9ca3af', 'icon' => 'user'],
        'guest'             => ['variant' => 'info',    'light' => 'text-blue-600 bg-blue-100',     'dark' => 'dark:text-blue-400 dark:bg-blue-950',     'hex' => '#3b82f6', 'icon' => 'user'],
        'moderator'         => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-400 dark:bg-red-950',      'hex' => '#ef4444', 'icon' => 'shield-exclamation'],
        'editor'            => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-400 dark:bg-blue-950',     'hex' => '#2563eb', 'icon' => 'pencil-square'],
        'support_team'      => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-400 dark:bg-blue-950',     'hex' => '#2563eb', 'icon' => 'headset'],
        'customer'          => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-400 dark:bg-green-950',   'hex' => '#16a34a', 'icon' => 'user-check'],
        'billing_manager'   => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-400 dark:bg-yellow-950', 'hex' => '#f59e0b', 'icon' => 'credit-card'],
        'technical_team'    => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-400 dark:bg-blue-950',     'hex' => '#2563eb', 'icon' => 'wrench-screwdriver'],
        'qa_team'           =>        ['variant' => 'gray',    'light' => 'text-gray-600 bg-gray-100',     'dark' => 'dark:text-gray-400 dark:bg-gray-900',     'hex' => '#6b7280', 'icon' => 'beaker'],
        'platform_manager'  => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-400 dark:bg-green-950',   'hex' => '#16a34a', 'icon' => 'server'],
        'deputy_super_admin' => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-400 dark:bg-red-950',      'hex' => '#991b1b', 'icon' => 'shield-exclamation'],
    ],

    'invoice' => [
        'draft'     => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',   'hex' => '#2563eb', 'icon' => 'draft'],
        'paid'      => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',  'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'paid'],
        'overdue'   => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'pending'],
        'cancelled' => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'canceled'],
    ],

    'notification' => [
        'new_user'               => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'new_user'],
        'new_payment'            => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'new_payment'],
        'subscription_activated' => ['variant' => 'info',    'light' => 'text-purple-700 bg-purple-100', 'dark' => 'dark:text-purple-300 dark:bg-purple-900/40', 'hex' => '#9333ea', 'icon' => 'subscription_activated'],
        'backup_completed'       => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#6b7280', 'icon' => 'backup_completed'],
        'system_alert'           => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#d97706', 'icon' => 'system_alert'],
        'delete'       => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'delete'],
    ],

    'general' => [
        'active'    => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',  'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'active'],
        'inactive'    => ['variant' => 'danger', 'light' => 'text-red-700 bg-red-100',  'dark' => 'dark:text-red-300 dark:bg-red-900/40',  'hex' => '#dc2626', 'icon' => 'inactive'],
        'info'    => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',   'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',   'hex' => '#2563eb', 'icon' => 'info'],
        'success' => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100', 'dark' => 'dark:text-green-300 dark:bg-green-900/40', 'hex' => '#16a34a', 'icon' => 'success'],
        'warning' => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'warning'],
        'danger'  => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',     'dark' => 'dark:text-red-300 dark:bg-red-900/40',     'hex' => '#dc2626', 'icon' => 'failed'],
        'gray'    => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',   'dark' => 'dark:text-gray-300 dark:bg-gray-800',      'hex' => '#9ca3af', 'icon' => 'default'],

        // بادجات جاهزة قابلة للاستعمال فوق أي منتج/عنصر (مثال: Status::for('general', 'featured'))
        'featured'    => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'featured'],
        'new'         => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'new'],
        'popular'     => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'popular'],
        'verified'    => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'verified'],
        'recommended' => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'recommended'],
        'limited'     => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'limited'],

        // أيقونات عامة جديدة
        'yes'       => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'yes'],
        'no'        => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'no'],
        'on'        => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'on'],
        'off'       => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'off'],
        'enable'    => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'enable'],
        'disable'   => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'disable'],
        'open'      => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'open'],
        'close'     => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'close'],
        'save'      => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'save'],
        'add'       => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'add'],
        'remove'    => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'remove'],
        'view'      => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'view'],
        'email'     => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'email'],
        'phone'     => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'phone'],
        'calendar'  => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'calendar'],
        'folder'    => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'folder'],
        'image'     => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'image'],
        'message'   => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'message'],
        'send'      => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'send'],
        'share'     => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'share'],
        'cart'      => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'cart'],
        'star'      => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'star'],
        'heart'     => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'heart'],
        'flag'      => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'flag'],
        'check'     => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'check'],
        'cross'     => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'cross'],
        'plus'      => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'plus'],
        'minus'     => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'minus'],
        'key'       => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'key'],
        'lock'      => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'lock'],
        'unlock'    => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'unlock'],
        'link'      => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'link'],
        'help'      => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'help'],
        'refresh'   => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'refresh'],
        'eye'       => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'eye'],
        'eye-off'   => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'eye-off'],

        // أيقونات الوسائط (play/pause...)
        'play'      => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'play'],
        'pause'     => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'pause'],
        'stop'      => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'stop'],
        'rewind'    => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'rewind'],
        'forward'   => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'forward'],
        'next'      => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'next'],
        'prev'      => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'prev'],
        'repeat'    => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'repeat'],
        'shuffle'   => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'shuffle'],
        'volume'    => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'volume'],
        'volume-mute' => ['variant' => 'gray',  'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'volume-mute'],
        'play-circle' => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100', 'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'play-circle'],
        'pause-circle' => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'pause-circle'],

        // دورة حياة عنصر (lifecycle) — قابلة لإعادة الاستعمال زادة عبر أي دومين
        'beta'        => ['variant' => 'info',    'light' => 'text-blue-700 bg-blue-100',     'dark' => 'dark:text-blue-300 dark:bg-blue-900/40',    'hex' => '#2563eb', 'icon' => 'beta'],
        'deprecated'  => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'deprecated'],
        'archived'    => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'archived'],
        'delete'      => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'delete'],
        'locked'      => ['variant' => 'gray',    'light' => 'text-gray-700 bg-gray-100',     'dark' => 'dark:text-gray-300 dark:bg-gray-800',       'hex' => '#9ca3af', 'icon' => 'locked'],
        'unlocked'    => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'unlocked'],
        'pending'     => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'pending'],
        'approved'    => ['variant' => 'success', 'light' => 'text-green-700 bg-green-100',   'dark' => 'dark:text-green-300 dark:bg-green-900/40',  'hex' => '#16a34a', 'icon' => 'approved'],
        'rejected'    => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'rejected'],
        'highlighted' => ['variant' => 'warning', 'light' => 'text-yellow-700 bg-yellow-100', 'dark' => 'dark:text-yellow-300 dark:bg-yellow-900/40', 'hex' => '#facc15', 'icon' => 'highlighted'],
        'trending'    => ['variant' => 'danger',  'light' => 'text-red-700 bg-red-100',       'dark' => 'dark:text-red-300 dark:bg-red-900/40',      'hex' => '#dc2626', 'icon' => 'trending'],
    ],

];
