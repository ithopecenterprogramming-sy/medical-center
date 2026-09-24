'use client';

import { useState } from 'react';
import Link from 'next/link';

export default function ForgotPasswordPage() {
  const [email, setEmail] = useState('');
  const [isSubmitted, setIsSubmitted] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (email) {
      // هنا يتم ربط الـ API لإرسال رابط إعادة التعيين
      setIsSubmitted(true);
    }
  };

  return (
    <div className="relative min-h-[calc(100vh-5rem)] flex items-center justify-center p-4 bg-slate-100/70 dark:bg-slate-950 transition-colors duration-300 overflow-hidden">
      
      {/* 🌟 شبكة النقاط الخلفية */}
      <div className="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] opacity-50 pointer-events-none"></div>

      {/* 🌟 إضاءات تفاعلية خلف الكارت */}
      <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[450px] h-[350px] bg-amber-500/15 dark:bg-amber-500/10 rounded-full blur-[120px] pointer-events-none"></div>

      {/* بطاقة إعادة استعادة كلمة المرور Card */}
      <div className="relative z-10 w-full max-w-md bg-white/90 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200/80 dark:border-slate-800 rounded-3xl p-8 sm:p-10 shadow-2xl shadow-slate-300/40 dark:shadow-none transition-colors duration-300">
        
        {/* رأس البطاقة */}
        <div className="text-center space-y-2 mb-8">
          <div className="w-14 h-14 bg-gradient-to-tr from-amber-600 via-amber-500 to-amber-400 rounded-2xl flex items-center justify-center mx-auto shadow-lg shadow-amber-500/25 mb-4 text-slate-950 text-2xl font-black">
            🔑
          </div>
          <h1 className="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
            استعادة كلمة المرور
          </h1>
          <p className="text-slate-500 dark:text-slate-400 text-xs sm:text-sm font-medium leading-relaxed">
            أدخل بريدك الإلكتروني وسيتم إرسال رابط لإعادة تعيين كلمة المرور الخاصة بك.
          </p>
        </div>

        {!isSubmitted ? (
          <form className="space-y-5" onSubmit={handleSubmit}>
            {/* حقل البريد الإلكتروني */}
            <div className="space-y-1.5">
              <label className="block text-xs font-bold text-slate-700 dark:text-slate-300">
                البريد الإلكتروني
              </label>
              <div className="relative">
                <input
                  type="email"
                  required
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  placeholder="name@medical-center.com"
                  className="w-full pl-4 pr-11 py-3 rounded-2xl bg-slate-50/80 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/80 text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 text-sm font-medium focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all duration-200"
                />
                <div className="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base pointer-events-none">
                  ✉️
                </div>
              </div>
            </div>

            {/* زر إرسال الرابط */}
            <button
              type="submit"
              className="w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black py-3.5 rounded-2xl transition-all shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:-translate-y-0.5 active:translate-y-0 text-sm mt-2"
            >
              إرسال رابط التعيين
            </button>
          </form>
        ) : (
          /* رسالة التأكيد بعد الإرسال */
          <div className="text-center space-y-4 py-4">
            <div className="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-800 dark:text-amber-300 text-sm font-medium leading-relaxed">
              تم إرسال تعليمات إعادة تعيين كلمة المرور إلى البريد الإلكتروني: <br />
              <strong className="text-slate-900 dark:text-white font-bold">{email}</strong>
            </div>
            <button
              onClick={() => setIsSubmitted(false)}
              className="text-xs text-slate-500 hover:text-amber-500 transition-colors underline"
            >
              إعادة الإرسال أو تغيير البريد الإلكتروني
            </button>
          </div>
        )}

        {/* العودة لصفحة تسجيل الدخول */}
        <div className="mt-8 text-center border-t border-slate-200/80 dark:border-slate-800/80 pt-6">
          <Link
            href="/login"
            className="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-amber-600 dark:hover:text-amber-400 transition-colors"
          >
            <span>→</span> العودة لصفحة تسجيل الدخول
          </Link>
        </div>

      </div>
    </div>
  );
}