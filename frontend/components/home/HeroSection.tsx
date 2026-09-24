'use client';

import Link from 'next/link';
import { motion } from 'framer-motion';
import Counter from '@/components/ui/Counter';

export default function HeroSection() {
  const scrollToServices = (e: React.MouseEvent<HTMLAnchorElement>) => {
    e.preventDefault();
    const servicesSection = document.getElementById('services');
    if (servicesSection) {
      servicesSection.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
      });
    }
  };

  return (
    <section className="relative min-h-[calc(100vh-5rem)] flex flex-col justify-center items-center px-4 overflow-hidden text-slate-800 dark:text-slate-100 transition-colors duration-300">
      
      {/* توهج ذهبي ناعم في الخلفية */}
      <div 
        aria-hidden="true"
        className="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[380px] bg-amber-500/15 dark:bg-amber-500/10 rounded-full blur-[140px] pointer-events-none"
      />

      <motion.div 
        initial={{ opacity: 0, y: 30 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.7, ease: 'easeOut' }}
        className="max-w-4xl text-center space-y-8 z-10 py-12"
      >
        <motion.div 
          initial={{ opacity: 0, scale: 0.9 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.5, delay: 0.2 }}
          className="inline-flex items-center gap-2 bg-white/80 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 text-xs sm:text-sm font-bold px-5 py-2 rounded-full border border-amber-500/30 backdrop-blur-md shadow-sm"
        >
          <span className="w-2 h-2 rounded-full bg-amber-500 dark:bg-amber-400 animate-pulse" />
          الإصدار الذكي المطور للنظام
        </motion.div>

        <motion.h1 
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.3 }}
          className="text-4xl sm:text-6xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-[1.25] transition-colors duration-300"
        >
          المنصة الذكية لإدارة <br />
          <span className="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 via-amber-500 to-amber-400 dark:from-amber-300 dark:via-amber-400 dark:to-amber-500">
            المركز الطبي
          </span>
        </motion.h1>
        
        <motion.p 
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.4 }}
          className="text-base sm:text-xl text-slate-700 dark:text-slate-300 leading-relaxed max-w-2xl mx-auto font-medium transition-colors duration-300"
        >
          نظام متكامل يربط بين موظفي الاستقبال، الأطباء، والإدارة لمتابعة المواعيد وسجلات المرضى بكل سهولة وسرعة.
        </motion.p>
        
        <motion.div 
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.5 }}
          className="flex flex-col sm:flex-row gap-5 justify-center pt-4"
        >
          <motion.div whileHover={{ scale: 1.02 }} whileTap={{ scale: 0.98 }}>
            <Link
              href="/login"
              className="group flex items-center justify-center gap-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 text-lg font-black px-9 py-4 rounded-2xl shadow-lg shadow-amber-500/25 transition-all duration-300"
            >
              تسجيل الدخول للنظام
              <span className="group-hover:-translate-x-1.5 transition-transform duration-300 text-xl">←</span>
            </Link>
          </motion.div>

          <motion.a
            whileHover={{ scale: 1.02 }}
            whileTap={{ scale: 0.98 }}
            href="#services"
            onClick={scrollToServices}
            className="flex items-center justify-center bg-white/80 dark:bg-slate-900 text-slate-900 dark:text-slate-200 border border-slate-200 dark:border-slate-800 hover:border-amber-500/50 text-lg font-bold px-9 py-4 rounded-2xl hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 shadow-sm cursor-pointer"
          >
            استكشف الخدمات
          </motion.a>
        </motion.div>

        {/* شريط الإحصائيات */}
        <motion.div 
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.6 }}
          className="pt-10 grid grid-cols-2 sm:grid-cols-3 gap-4 border-t border-slate-200/80 dark:border-slate-800/80 max-w-2xl mx-auto"
        >
          <div className="text-center p-3">
            <h4 className="text-amber-600 dark:text-amber-400 font-bold text-lg sm:text-xl font-mono">
              <Counter to={100} duration={2} suffix="%" />
            </h4>
            <p className="text-slate-600 dark:text-slate-400 text-xs mt-0.5 font-medium">أمان البيانات والملفات</p>
          </div>

          <div className="text-center p-3">
            <h4 className="text-amber-600 dark:text-amber-400 font-bold text-lg sm:text-xl">فوري</h4>
            <p className="text-slate-600 dark:text-slate-400 text-xs mt-0.5 font-medium">مزامنة المواعيد</p>
          </div>

          <div className="col-span-2 sm:col-span-1 text-center p-3">
            <h4 className="text-amber-600 dark:text-amber-400 font-bold text-lg sm:text-xl">شامل</h4>
            <p className="text-slate-600 dark:text-slate-400 text-xs mt-0.5 font-medium">لوحات تحكم متعددة الأدوار</p>
          </div>
        </motion.div>

      </motion.div>
    </section>
  );
}