'use client';

import { useState } from 'react';
import Link from 'next/link';

export default function LoginPage() {
  const [showPassword, setShowPassword] = useState(false);

  return (
    <div className="relative min-h-[calc(100vh-5rem)] flex items-center justify-center p-4 bg-slate-100/70 dark:bg-slate-950 transition-colors duration-300 overflow-hidden">
      
      {/* 🌟 شبكة النقاط الخلفية لمنع المساحات الفارغة الناصعة */}
      <div className="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] opacity-50 pointer-events-none"></div>

      {/* 🌟 إضاءات تفاعلية ملونة خلف الكارت */}
      <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[450px] h-[350px] bg-amber-500/15 dark:bg-amber-500/10 rounded-full blur-[120px] pointer-events-none"></div>
      <div className="absolute top-10 right-10 w-64 h-64 bg-blue-500/10 dark:bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>

      {/* بطاقة تسجيل الدخول Card */}
      <div className="relative z-10 w-full max-w-md bg-white/90 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 rounded-3xl p-8 sm:p-10 shadow-2xl shadow-slate-300/40 dark:shadow-none transition-colors duration-300">
        
        {/* شريط أعلى الكارت ترحيبي */}
        <div className="text-center space-y-2 mb-8">
          <div className="w-14 h-14 bg-gradient-to-tr from-amber-600 via-amber-500 to-amber-400 rounded-2xl flex items-center justify-center mx-auto shadow-lg shadow-amber-500/25 mb-4">
            <span className="text-slate-950 font-black text-2xl">م</span>
          </div>
          <h1 className="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
            تسجيل الدخول
          </h1>
          <p className="text-slate-500 dark:text-slate-400 text-xs sm:text-sm font-medium">
            مرحباً بك، يرجى إدخال بياناتك للدخول للنظام
          </p>
        </div>

        <form className="space-y-5" onSubmit={(e) => e.preventDefault()}>
          
          {/* حقل اسم المستخدم / البريد */}
          <div className="space-y-1.5">
            <label className="block text-xs font-bold text-slate-700 dark:text-slate-300">
              اسم المستخدم / البريد الإلكتروني
            </label>
            <div className="relative">
              <input
                type="text"
                placeholder="اسم المستخدم أو البريد..."
                className="w-full pl-4 pr-11 py-3 rounded-2xl bg-slate-50/80 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 text-sm font-medium focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all duration-200"
              />
              <div className="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none">
                👤
              </div>
            </div>
          </div>

          {/* حقل كلمة المرور */}
          <div className="space-y-1.5">
            <label className="block text-xs font-bold text-slate-700 dark:text-slate-300">
              كلمة المرور
            </label>
            <div className="relative">
              <input
                type={showPassword ? 'text' : 'password'}
                placeholder="••••••••"
                className="w-full pl-11 pr-11 py-3 rounded-2xl bg-slate-50/80 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 text-sm font-medium focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all duration-200"
              />
              <div className="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none">
                🔐
              </div>
              <button
                type="button"
                onClick={() => setShowPassword(!showPassword)}
                className="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xs font-medium transition-colors"
              >
                {showPassword ? 'إخفاء' : 'إظهار'}
              </button>
            </div>
          </div>

          {/* تذكرني + نسيت كلمة المرور */}
          <div className="flex items-center justify-between text-xs font-medium pt-1">
            <label className="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 transition-colors">
              <input
                type="checkbox"
                className="w-4 h-4 rounded border-slate-300 dark:border-slate-700 text-amber-500 focus:ring-amber-500/30 accent-amber-500 cursor-pointer"
              />
              تذكرني
            </label>
       
            {/* هنا التحديث 👉 */}
            <Link 
              href="/forgot-password" 
              className="text-amber-600 dark:text-amber-400 hover:underline transition-all font-semibold"
            >
              نسيت كلمة المرور؟
            </Link>
          </div>

          {/* زر تسجيل الدخول */}
          <button
            type="submit"
            className="w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black py-3.5 rounded-2xl transition-all shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-0.5 active:translate-y-0 text-sm mt-2"
          >
            دخول للنظام
          </button>
        </form>

        {/* العودة للرئيسية */}
        <div className="mt-8 text-center border-t border-slate-200/80 dark:border-slate-800/80 pt-6">
          <Link
            href="/"
            className="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-amber-600 dark:hover:text-amber-400 transition-colors"
          >
            <span>←</span> العودة للصفحة الرئيسية
          </Link>
        </div>

      </div>
    </div>
  );
}