'use client';

import Link from 'next/link';
import { usePathname } from 'next/navigation';
import ThemeToggle from './ThemeToggle';

export default function Header() {
  const pathname = usePathname();

  const navLinks = [
    { name: 'الرئيسية', href: '/' },
    { name: 'عن المركز', href: '/about' },
  ];

  return (
    <header className="sticky top-0 z-50 w-full bg-slate-100/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-amber-500/20 shadow-sm transition-colors duration-300">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        
        {/* الشعار Logo */}
        <Link href="/" className="flex items-center gap-3.5 group">
          <div className="w-11 h-11 bg-gradient-to-tr from-amber-600 via-amber-500 to-amber-400 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-all duration-300">
            <span className="text-slate-950 font-black text-2xl">م</span>
          </div>
          <div className="flex flex-col">
            <span className="text-2xl font-black tracking-tight text-slate-900 dark:text-white group-hover:text-amber-500 transition-colors">
              المركز <span className="text-amber-500">الطبي</span>
            </span>
            <span className="text-[10px] text-amber-600 dark:text-amber-400/80 font-semibold tracking-wider uppercase">
              للرعاية المتقدمة
            </span>
          </div>
        </Link>

        {/* روابط الملاحة Navigation Links */}
        <nav className="hidden md:flex items-center gap-1 bg-white/50 dark:bg-slate-900/50 p-1.5 rounded-2xl border border-slate-200/50 dark:border-slate-800/50 backdrop-blur-sm">
          {navLinks.map((link) => {
            const isActive = pathname === link.href;
            return (
              <Link
                key={link.href}
                href={link.href}
                className={`px-5 py-2 rounded-xl text-sm font-bold transition-all duration-200 ${
                  isActive
                    ? 'bg-amber-500 text-slate-950 shadow-sm shadow-amber-500/20'
                    : 'text-slate-700 dark:text-slate-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-white/80 dark:hover:bg-slate-800/60'
                }`}
              >
                {link.name}
              </Link>
            );
          })}
        </nav>

        {/* أزرار الإجراءات Actions */}
        <div className="flex items-center gap-3">
          <ThemeToggle />

          <Link
            href="/login"
            className="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 px-5 py-2.5 rounded-xl font-black text-sm transition-all duration-300 shadow-md shadow-amber-500/20 hover:shadow-amber-500/40 hover:-translate-y-0.5 active:translate-y-0"
          >
            تسجيل الدخول
          </Link>
        </div>

      </div>
    </header>
  );
}