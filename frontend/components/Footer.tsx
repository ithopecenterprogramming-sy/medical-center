'use client';

import Link from 'next/link';

export default function Footer() {
  return (
    <footer className="relative bg-slate-100/80 dark:bg-slate-950 text-slate-700 dark:text-slate-300 pt-16 pb-8 border-t border-slate-200 dark:border-amber-500/20 overflow-hidden mt-auto transition-colors duration-300">
      
      {/* إضاءة خلفية دافئة تتناسب مع الهوية */}
      <div className="absolute top-0 right-1/4 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-12 text-sm pb-12 border-b border-slate-200/80 dark:border-slate-800/80">
          
          {/* روابط سريعة */}
          <div className="space-y-4">
            <h3 className="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
              <span className="w-2 h-2 bg-amber-500 rounded-full"></span> روابط سريعة
            </h3>
            <ul className="space-y-2.5 font-medium text-slate-600 dark:text-slate-400">
              <li><Link href="/" className="hover:text-amber-500 transition-colors inline-block">الرئيسية</Link></li>
              <li><Link href="/about" className="hover:text-amber-500 transition-colors inline-block">عن المركز</Link></li>
              <li><Link href="/login" className="hover:text-amber-500 transition-colors inline-block">دخول الموظفين (Console)</Link></li>
            </ul>
          </div>

          {/* أرقام التواصل */}
          <div className="space-y-4">
            <h3 className="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
              <span className="w-2 h-2 bg-amber-500 rounded-full"></span> أرقام التواصل
            </h3>
            <ul className="space-y-3 font-medium text-slate-600 dark:text-slate-400" dir="ltr" style={{ textAlign: 'right' }}>
              <li className="flex justify-end items-center gap-3">
                <span className="hover:text-amber-500 transition-colors cursor-pointer font-semibold">+963 911 111 111</span>
                <div className="w-8 h-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg flex items-center justify-center text-amber-500 text-sm shadow-sm">📱</div>
              </li>
              <li className="flex justify-end items-center gap-3">
                <span className="hover:text-amber-500 transition-colors cursor-pointer font-semibold">+963 11 222 3333</span>
                <div className="w-8 h-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg flex items-center justify-center text-amber-500 text-sm shadow-sm">☎️</div>
              </li>
            </ul>
          </div>

          {/* تواصل إلكتروني وسوشيال ميديا */}
          <div className="space-y-4">
            <h3 className="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
              <span className="w-2 h-2 bg-amber-500 rounded-full"></span> تواصل إلكتروني
            </h3>
            <div className="space-y-4">
              <a href="mailto:info@medical-center.com" className="flex items-center gap-3 text-slate-600 dark:text-slate-400 hover:text-amber-500 transition-colors group">
                <div className="w-8 h-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors text-sm shadow-sm">✉️</div>
                <span dir="ltr" className="font-semibold text-sm">info@medical-center.com</span>
              </a>
              
              <div className="flex gap-3 pt-1">
                <a href="#" title="Facebook" className="w-10 h-10 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl flex items-center justify-center hover:bg-amber-500 hover:text-slate-950 transition-all text-lg shadow-sm">📘</a>
                <a href="#" title="Instagram" className="w-10 h-10 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl flex items-center justify-center hover:bg-amber-500 hover:text-slate-950 transition-all text-lg shadow-sm">📸</a>
              </div>
            </div>
          </div>

          {/* لوغو المركز والنبذة */}
          <div className="flex flex-col md:items-center text-center space-y-3 md:border-r md:border-slate-200 dark:md:border-slate-800 md:pr-6">
            <div className="w-16 h-16 bg-gradient-to-tr from-amber-600 via-amber-500 to-amber-400 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/20">
              <span className="text-slate-950 font-black text-3xl">م</span>
            </div>
            <div>
              <h2 className="text-xl font-black text-slate-900 dark:text-white">المركز <span className="text-amber-500">الطبي</span></h2>
              <p className="text-slate-600 dark:text-slate-400 text-xs font-medium leading-relaxed max-w-[200px] mx-auto mt-1">
                نظام متكامل يضمن لك الدقة، السرعة، والأمان في إدارة كافة العمليات الطبية.
              </p>
            </div>
          </div>

        </div>
        
        {/* حقوق النشر */}
        <div className="pt-6 text-center text-slate-500 dark:text-slate-500 text-xs font-medium">
          © {new Date().getFullYear()} المركز الطبي - جميع الحقوق محفوظة.
        </div>
      </div>
    </footer>
  );
}