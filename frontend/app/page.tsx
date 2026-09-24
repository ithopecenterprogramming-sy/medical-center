'use client';

import HeroSection from '@/components/home/HeroSection';
import FeaturesSection from '@/components/home/FeaturesSection';
import FeatureCards from '@/components/FeatureCards';
import Link from 'next/link';
import { motion } from 'framer-motion';

export default function HomePage() {
  return (
    <main className="relative min-h-screen bg-slate-100/70 dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-300 overflow-hidden">
      
      {/* شبكة النقاط الخلفية الموحدة مع صفحة About */}
      <div 
        aria-hidden="true"
        className="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] dark:bg-[radial-gradient(#1e293b_1px,transparent_1px)] [background-size:24px_24px] opacity-50 pointer-events-none"
      />

      {/* الإضاءات الخلفية الدائرية (Ambient Lights) */}
      <div 
        aria-hidden="true"
        className="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-amber-500/15 dark:bg-amber-500/10 rounded-full blur-[140px] pointer-events-none"
      />
      <div 
        aria-hidden="true"
        className="absolute bottom-1/3 right-10 w-80 h-80 bg-blue-500/10 dark:bg-blue-600/10 rounded-full blur-[130px] pointer-events-none"
      />

      {/* محتوى الصفحة الرئيسي */}
      <div className="relative z-10 space-y-20 pb-20">
        
        {/* قسم البطل (Hero Section) */}
        <HeroSection />

        {/* كروت المميزات الأساسية المستقلة */}
        <section className="max-w-6xl mx-auto px-4 sm:px-6">
          <FeatureCards />
        </section>

        {/* قسم كيف نعمل (Features Section) */}
        <FeaturesSection />

        {/* قسم الدعوة للتواصل بتصميم مطابق لصفحة About */}
        <section className="max-w-6xl mx-auto px-4 sm:px-6">
          <motion.div 
            initial={{ opacity: 0, scale: 0.95 }}
            whileInView={{ opacity: 1, scale: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6 }}
            className="bg-white/90 dark:bg-gradient-to-r dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 border border-slate-200/80 dark:border-amber-500/30 rounded-3xl p-8 sm:p-12 text-center space-y-6 shadow-xl shadow-slate-200/50 dark:shadow-2xl relative overflow-hidden transition-colors duration-300"
          >
            <div 
              aria-hidden="true"
              className="absolute -right-10 -bottom-10 w-40 h-40 bg-amber-500/15 rounded-full blur-2xl pointer-events-none"
            />
            
            <h2 className="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white transition-colors duration-300">
              هل أنت جاهز لتجربة خدمة صحية أسرع؟
            </h2>
            <p className="text-slate-700 dark:text-slate-300 max-w-xl mx-auto text-sm sm:text-base font-medium transition-colors duration-300">
              سجل دخولك الآن واستفد من خدمات الحجز الفوري وإدارة ملفاتك الطبية بكل سهولة وأمان.
            </p>
            <div className="pt-2">
              <motion.div whileHover={{ scale: 1.02 }} whileTap={{ scale: 0.98 }} className="inline-block">
                <Link
                  href="/login"
                  className="inline-flex items-center justify-center bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black px-8 py-3.5 rounded-2xl transition-all shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40"
                >
                  الدخول للنظام الآن
                </Link>
              </motion.div>
            </div>
          </motion.div>
        </section>

      </div>
    </main>
  );
}