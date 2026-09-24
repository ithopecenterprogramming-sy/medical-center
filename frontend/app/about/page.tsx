'use client';

import Link from 'next/link';
import { motion } from 'framer-motion';
import FeatureCards from '@/components/FeatureCards';

export default function AboutPage() {
  return (
    <main className="relative min-h-[calc(100vh-5rem)] bg-slate-100/70 dark:bg-slate-950 text-slate-800 dark:text-slate-100 py-16 px-4 overflow-hidden transition-colors duration-300">
      
      {/* شبكة النقاط الخلفية */}
      <div 
        aria-hidden="true" 
        className="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] opacity-50 pointer-events-none" 
      />

      {/* إضاءات خلفية ملونة */}
      <div 
        aria-hidden="true" 
        className="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[300px] bg-amber-500/15 dark:bg-amber-500/10 rounded-full blur-[130px] pointer-events-none" 
      />
      <div 
        aria-hidden="true" 
        className="absolute bottom-10 right-10 w-72 h-72 bg-blue-500/10 dark:bg-blue-600/10 rounded-full blur-[120px] pointer-events-none" 
      />

      <div className="max-w-6xl mx-auto space-y-16 relative z-10">
        
        {/* Header الصفحة */}
        <motion.header 
          initial={{ opacity: 0, y: -20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="text-center space-y-4 max-w-3xl mx-auto"
        >
          <div className="inline-flex items-center gap-2 bg-white/80 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 text-xs font-bold px-4 py-1.5 rounded-full border border-amber-500/30 backdrop-blur-md shadow-sm">
            <span className="w-2 h-2 rounded-full bg-amber-500 dark:bg-amber-400 animate-pulse" />
            رؤيتنا ورسالتنا
          </div>
          
          <h1 className="text-4xl sm:text-6xl font-black tracking-tight text-slate-900 dark:text-white transition-colors duration-300">
            عن <span className="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 via-amber-500 to-amber-400 dark:from-amber-300 dark:via-amber-400 dark:to-amber-500">المركز الطبي</span>
          </h1>
          
          <p className="text-slate-700 dark:text-slate-300 text-base sm:text-xl leading-relaxed font-medium transition-colors duration-300">
            نحن نقدم حلولاً برمجية متكاملة لربط كافة الأقسام الطبية والإدارية، لضمان أعلى مستويات الكفاءة وأفضل خدمة للمرضى.
          </p>
        </motion.header>

        {/* كروت المميزات */}
        <FeatureCards />

        {/* قسم الدعوة للتواصل / الدخول */}
        <motion.section 
          initial={{ opacity: 0, scale: 0.95 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.6, delay: 0.4 }}
          className="bg-white/90 dark:bg-gradient-to-r dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 border border-slate-200/80 dark:border-amber-500/30 rounded-3xl p-8 sm:p-12 text-center space-y-6 shadow-xl shadow-slate-200/50 dark:shadow-2xl relative overflow-hidden transition-colors duration-300"
        >
          <div 
            aria-hidden="true" 
            className="absolute -right-10 -bottom-10 w-40 h-40 bg-amber-500/15 rounded-full blur-2xl pointer-events-none" 
          />
          
          <h2 className="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white transition-colors duration-300">
            هل أنت عضو في الفريق الطبي أو الإداري؟
          </h2>
          
          <p className="text-slate-700 dark:text-slate-300 max-w-xl mx-auto text-sm sm:text-base font-medium transition-colors duration-300">
            قم بتسجيل الدخول للوصول إلى لوحة التحكم الخاصة بك ومتابعة مهامك اليومية بكل سهولة.
          </p>
          
          <div className="pt-2">
            <motion.div whileHover={{ scale: 1.02 }} whileTap={{ scale: 0.98 }} className="inline-block">
              <Link
                href="/login"
                className="inline-flex items-center justify-center bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black px-8 py-3.5 rounded-2xl transition-all shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40"
              >
                الانتقال لصفحة الدخول
              </Link>
            </motion.div>
          </div>
        </motion.section>

      </div>
    </main>
  );
}