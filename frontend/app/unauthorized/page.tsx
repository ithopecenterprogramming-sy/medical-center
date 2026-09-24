'use client';

import Link from 'next/link';

export default function UnauthorizedPage() {
  return (
    <div className="min-h-screen flex items-center justify-center bg-slate-950 text-white p-4">
      <div className="text-center space-y-4 max-w-md border border-slate-800 p-8 rounded-3xl bg-slate-900">
        <div className="w-16 h-16 bg-red-500/10 text-red-500 rounded-2xl flex items-center justify-center mx-auto text-2xl font-bold">
          403
        </div>
        <h1 className="text-xl font-bold">غير مصرح لك بالوصول</h1>
        <p className="text-slate-400 text-xs leading-relaxed">
          عذراً، لا تمتلك الصلاحيات الكافية لعرض هذه الصفحة. يرجى التواصل مع مسؤول النظام إن كان هذا خطأً.
        </p>
        <Link
          href="/dashboard"
          className="inline-block bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold px-6 py-3 rounded-xl transition-all"
        >
          العودة للوحة التحكم
        </Link>
      </div>
    </div>
  );
}